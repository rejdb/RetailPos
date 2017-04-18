function receivingCtrl($scope, curl, transact, Auth, spinner, ItemFact, Inventory, BrnFact,
                       $filter, $timeout, $location) {
    console.log("Initializing Receiving Module!");
    if (!$('#page-wrapper').hasClass('nav-small')) {$('#page-wrapper').addClass('nav-small');}
    var tbxCnf;
    Auth.config(function(rsp) {
        tbxCnf = rsp;
        $scope.tbxConfig = tbxCnf;
    });
    
    $scope.ShowBranchSelect = true;
    
    var usr = Auth.currentUser();
    $scope.register = {
        BranchName: usr.Branch.Description,
        CreatedBy: usr.DisplayName,
        header: {
            InvoiceNo: '',
            TransDate: $filter('date')(new Date(), 'MM/dd/yyyy'),
            Branch: usr.Branch.BranchID,
            Quantity: 0,
            Total: 0,
            GTotal: 0,
            Comments: '',
            CreatedBy: usr.UID
        },
        rows: []
    }
    
    ItemFact.activeProducts(1, function(itm) { $scope.productLists = itm; $scope.itemLoader = false;});
    Inventory.getWarehouse(function(whs) {$scope.WhsList = whs;});
    BrnFact.getActive(1,function(brn) {$scope.branches = brn;});
    
    $scope.resetBranch = function(hdr){
        hdr.Branch = -1;
        $scope.ShowBranchSelect = false;
    }
    
    $scope.GetBranch = function(selected) {
        $scope.register.header.Branch = parseInt(selected.originalObject.BranchID);
        $scope.register.BranchName = selected.originalObject.Description;
        $scope.ShowBranchSelect = true;
    }
    
    //Search Products
    $scope.GetProduct = function(selected) {
        var SearchProduct = selected.originalObject.BarCode;
        
        $scope.itemLoader = true;
        ItemFact.search({
            IsActive: 1,
            BarCode: SearchProduct
        }, function(rsp){
            $scope.itemLoader = false;
            
            if(!rsp.status) {
                spinner.notif(rsp.message, 1500);
            }else{
                var data = rsp.data[0];
                $scope.register.header.Quantity += 1;
                $scope.register.header.Total += parseFloat(data.StdCost);
                $scope.register.header.GTotal += parseFloat(data.StdCost) * ((parseInt(tbxCnf.IsPurchaseTaxable)==1) ? 
                                                                             (1+(parseInt(tbxCnf.InputTax)/100)) : 1);
                
                var item = {
                    PID: parseInt(data.PID),
                    BarCode: data.BarCode,
                    ProductDesc: data.ProductDesc,
                    SKU: data.SKU,
                    StdCost: parseFloat(data.StdCost),
                    Quantity: 1, 
                    Discount: 0, 
                    Warehouse: '1',
                    InputVat: (parseInt(tbxCnf.IsPurchaseTaxable)==1) ? parseInt(tbxCnf.InputTax) : 0,
                    Total: parseFloat(data.StdCost),
                    GTotal: parseFloat(data.StdCost) * ((parseInt(tbxCnf.IsPurchaseTaxable)==1) ? (1+(parseInt(tbxCnf.InputTax)/100)) : 1),
                    IsSerialized: parseInt(data.IsSerialized),
                    Serials: []
                };
                
                $scope.register.rows.push(item);
            }
        });
    }
    
    $scope.removeItem = function(index) {
        $scope.register.rows.splice(index,1);
        $scope.updateValue();
    }
    
    $scope.Filler = function(WhsID) {
        var selected = [];
        selected = $filter('filter')($scope.WhsList, {WhsCode: WhsID}, true);
        return (WhsID && selected.length) ? selected[0].WhsName : 'Select Warehouse';
    }
    
    $scope.updateValue = function() {
        $scope.register.header.Total = 0;
        $scope.register.header.GTotal = 0;
        $scope.register.header.Quantity = 0;
        
        $timeout(function() {
            angular.forEach($scope.register.rows, function(index) {
                $scope.register.header.Quantity += index.Quantity;
                $scope.register.header.Total += index.Total;
                $scope.register.header.GTotal += index.GTotal;
            });
        },100);
    }
    
    $scope.checkSerial = function(data, register, tag, index, type) {    
        spinner.show();
        
        var result;
        curl.ajaxG('/inventories/CheckSerial/' + tag.Serial, 
                function(rsp) {
            spinner.hide();
            result = !rsp.status;
        });
        
        return result; 
    }
    
    $scope.countSerial = function(row, data) {
        var r = data.length;
        var q = row.Quantity;

        if(r>q) {
            return 'Received exceeds Quantity! Contact HO if it really exceed.';
        }
    }
    
    $scope.SubmitRegister = function(hdr,rows) {
        var TransID = transact.TransID(hdr.Branch);
        $scope.register.header.TransID = TransID;
        $scope.register.header.TransDate = $filter('date')(Date.parse(hdr.TransDate), 'yyyy-MM-dd');
        
        var found = 0;
        var currentdate = $filter('date')(new Date(), 'yyyy-MM-dd');
        
        if(rows.length == 0) {
            return spinner.notif('Please select a product to received',1000);}
        
        angular.forEach(rows, function(row) {
            if(row.IsSerialized==1) {
                if(row.Serials.length != row.Quantity) {
                    found++;
                }
            }
        });
        
        if(found>0) {
            return spinner.notif(found + ' row item does not have completed serial!');
        }
        
        if(hdr.InvoiceNo.length == 0) {
            return spinner.notif('Please enter a Reference Number.',1000);}
        
        
        if(hdr.Branch == 0) {
            $scope.ShowBranchSelect = false;
            return spinner.notif('Please select Branch',1000);}
        
        spinner.show();
        curl.post('/transactions/SubmitReceiving', $scope.register, function(rsp) {
            spinner.hide();
            spinner.notif(rsp.message, 1000, rsp.status);
            if(rsp.status) {
                $location.path('/stocks/receiving/receipt/' + TransID);
            }
        });
    }
    
    console.log("Receiving module has been initialized!");
}

function receivingReceiptCtrl($scope, $stateParams, curl, Auth, transact) {
    if (!$('#page-wrapper').hasClass('nav-small')) {$('#page-wrapper').addClass('nav-small');}
    Auth.config(function(rsp) {
        $scope.config = rsp;
    });
    
    spinner.show();
    curl.get('/transactions/ReceivingReceipt/' + $stateParams.TransID, function(rsp) {
        spinner.hide();
        $scope.register = rsp;
    });
}

function receivingHistoryCtrl($scope, transact, Auth, spinner, filterFilter, $filter, BrnFact) {
if (!$('#page-wrapper').hasClass('nav-small')) {$('#page-wrapper').addClass('nav-small');}
    $scope.pList = [];
    $scope.currentPage = 1;
    $scope.pageSize = 10; // items per page
    
    var usr = Auth.currentUser();
    
    $scope.advance = {
        AllBranch: (usr.Roles!=4) ? true:false,
        Branch: usr.Branch.BranchID,
        DateFrom: $filter('date')(new Date(), 'MM/dd/yyyy'),
        DateTo: $filter('date')(new Date(), 'MM/dd/yyyy')
    }
    

    // $watch search to update pagination
	$scope.$watch('find', function (newVal, oldVal) {
		$scope.filtered = filterFilter($scope.pList, newVal);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);
    
    $scope.$watch('pageSize', function () {
		$scope.filtered = filterFilter($scope.pList, $scope.find);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);
    
    spinner.show();
    var params = (usr.Roles!=4) ? 'TransDate="' + $filter('date')(new Date(), 'yyyy-MM-dd') + '"' : 'Branch =' +usr.Branch.BranchID;
    transact.history(params, 'view_receiving', function(rsp) {
        $scope.pList = rsp; spinner.hide();
        $scope.totalItems = $scope.pList.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
    });
    
    
    BrnFact.getActive(1, function(rsp) {$scope.branches = rsp});
    
    $scope.filter = function(id) {
        spinner.show();
        var params = (usr.Roles!=4) ? 'InvoiceNo like "%'+id+'%"' : 'InvoiceNo like "%'+id + '%" and Branch =' + usr.Branch.BranchID;
        transact.history(params, 'view_receiving', function(rsp) {
            spinner.hide();
            if(rsp.length==0) {
                spinner.alert({status:false,message:"No Record Found!"}, 1000);
            }else{
                $scope.collapse = true;
                $scope.sFormSingle.$setPristine();
                $scope.search.TransID='';
                $scope.pList=rsp;
            }
        });
    }
    
    $scope.AdvanceFilter = function(f) {
        $scope.pList = [];
        
        var DateFrom = $filter('date')(new Date(f.DateFrom), 'yyyy-MM-dd');
        var DateTo = $filter('date')(new Date(f.DateTo), 'yyyy-MM-dd');
        var branch = (f.AllBranch) ? '':' and Branch =' + ((usr.Roles !=4) ? parseInt(f.Branch) :parseInt(usr.Branch.BranchID));
        
        var params = 'TransDate <= "' + DateTo + '" and TransDate >= "' + DateFrom + '"' + branch;
        
        spinner.show();
        transact.history(params, 'view_receiving', function(rsp) {
            spinner.hide();
            
            $scope.pList=rsp;
            $scope.collapse = true;
            if(rsp.length==0) {
                spinner.notif('No Record Found!', 1000);
            }
        });
    }
    
    $scope.exportFields = {
        TransDate: 'Date',
        InvoiceNo: 'Reference Number',
        BranchCode: 'Store Code',
        Description: 'Store Name',
        CategoryDesc: 'Store Category',
        GroupDesc: 'Store Group',
        TypeDesc: 'Store Type',
        ChannelDesc: 'Store Channel',
        CityDesc: 'Store City',
        Quantity: 'Quantity',
        Total: 'Total',
        GTotal: 'Grand Total',
        Comments: 'Comments',
        DisplayName: 'Cashier'
    }
}

app.controller('receivingCtrl', receivingCtrl);
app.controller('receivingReceiptCtrl', receivingReceiptCtrl);
app.controller('receivingHistoryCtrl', receivingHistoryCtrl);

$(document).ready(function() {
    $('.podate').datepicker();
    $('#PoBranch, #PoSupplier').select2();
});