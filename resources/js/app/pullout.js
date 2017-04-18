

function pulloutCtrl($scope, curl, transact, Auth, spinner, ItemFact, Inventory, BrnFact,
                       $filter, $timeout, $location) {
    console.log("Initializing Pull-out Module!");
    if (!$('#page-wrapper').hasClass('nav-small')) {$('#page-wrapper').addClass('nav-small');}
    
    var tbxCnf;
    $scope.WhsList = [];
    $scope.branches = [];
    
    Auth.config(function(rsp) {
        tbxCnf = rsp;
        $scope.tbxConfig = tbxCnf;
    });
    
    $scope.ShowBranchSelect = true;
    
    var usr = Auth.currentUser();
    $scope.register = {
        BranchName: usr.Branch.Description,
        CreatedBy: usr.DisplayName,
        SelectedWhs: 'Select Warehouse',
        SourceWhs: 0,
        header: {
            RefNo: '',
            TransDate: $filter('date')(new Date(), 'MM/dd/yyyy'),
            Branch: usr.Branch.BranchID,
            Quantity: 0,
            Total: 0,
            Comments: '',
            CreatedBy: usr.UID
        },
        rows: []
    }
    
    BrnFact.getActive(1,function(brn) {$scope.branches = brn; $scope.brnLoader = false;});
    Inventory.getActiveWhs(1,function(whs) {$scope.WhsList = whs; $scope.itemLoader = false;});
    
    $scope.resetBranch = function(hdr){
        hdr.Branch = 0;
        $scope.Reset();
        $scope.ShowBranchSelect = false;
    }
    
    $scope.GetBranch = function(selected) {
        $scope.register.header.Branch = parseInt(selected.originalObject.BranchID);
        $scope.register.BranchName = selected.originalObject.Description;
        $scope.ShowBranchSelect = true;
    }
    
    $scope.SelectWhs = function(WhsID) {
        var selected = [];
        selected = $filter('filter')($scope.WhsList, {WhsCode: WhsID}, true);
        
        $scope.Reset();
        $scope.register.SourceWhs = parseInt(WhsID);
        $scope.register.SelectedWhs = (WhsID && selected.length) ? selected[0].WhsName : 'Select Warehouse';
    }  
    
    $scope.Reset = function() {
        $scope.register.rows = [];
        items = []; imei = [];
        $scope.register.header.Quantity = 0;
        $scope.register.header.Total = 0;
    }
    
    //Search Products
    var items = [];
    var imei = [];
    $scope.GetProduct = function(hdr) {
        if($scope.SearchProduct == undefined || $scope.SearchProduct.length == 0) {
            $('#GetProduct').parent().parent().parent().addClass('has-error');
            return false; }
        
        if(hdr.Branch == 0 || hdr.Branch == -1) {
            spinner.notif('Please select source branch!', 500);
            $scope.ShowBranchSelect = false;
            return false; }
        
        if($scope.register.SourceWhs == 0) {
            spinner.notif('Please select Warehouse Source!', 500);
            return false; }
        
        
        if(imei.indexOf($scope.SearchProduct.toLowerCase())>=0) {
            spinner.notif('Serial already exists in the row! please select another item.', 500);
            return false; }
        
        if(items.indexOf($scope.SearchProduct.toLowerCase())>=0) {
            spinner.notif('Product already exists in the row! please select another product', 500);
            return false; }
        
        var data = {
            'Branch': parseInt(hdr.Branch),
            'Warehouse': parseInt($scope.register.SourceWhs),
            'Search': $scope.SearchProduct
        }
        
        
        $scope.itemLoader = true;
        curl.post('/Inventories/SearchInventory', data, function(rsp) {
            $scope.SearchProduct = '';
            
            $scope.itemLoader = false;
            if(!rsp.status) {
                spinner.notif(rsp.message, 1000);
                return false;
            }else{
                var data = rsp.result;
                $scope.register.header.Quantity += 1;
                $scope.register.header.Total += parseFloat(data.StdCost);
                
                if(data.IsSerialized == 1) {
                    imei.push(data.Serial.toLowerCase());
                }else{ items.push(data.BarCode.toLowerCase()); }
                
                var item = {
                    PID: parseInt(data.Product),
                    BarCode: data.BarCode,
                    ProductDesc: data.ProductDesc,
                    SKU: data.SKU,
                    StdCost: parseFloat(data.StdCost),
                    InStocks: parseInt(data.Available),
                    Quantity: 1,
                    Warehouse: data.Warehouse,
                    InputVat: (parseInt(tbxCnf.IsPurchaseTaxable)==1) ? parseInt(tbxCnf.InputTax) : 0,
                    Total: parseFloat(data.StdCost),
                    IsSerialized: parseInt(data.IsSerialized),
                    InvSerID: data.InvSerID,
                    Serials: data.Serial
                };
                
                $scope.register.rows.push(item);
            }
        });
    }
    
    $scope.removeItem = function(index, data) {
        $scope.register.rows.splice(index,1);
        var itm = items.indexOf(data);
        var srl = imei.indexOf(data);
        
        if(itm=>0) { items.splice(itm,1); }
        if(srl=>0) { imei.splice(srl,1); }

        $scope.updateValue();
    }
    
    $scope.Filler = function(WhsID) {
        var selected = [];
        selected = $filter('filter')($scope.WhsList, {WhsCode: WhsID}, true);
        return (WhsID && selected.length) ? selected[0].WhsName : 'Select Warehouse';
    }
    
    $scope.updateValue = function() {
        $scope.register.header.Total = 0;
        $scope.register.header.Quantity = 0;
        
        $timeout(function() {
            angular.forEach($scope.register.rows, function(index) {
                $scope.register.header.Quantity += index.Quantity;
                $scope.register.header.Total += index.Total;
            });
        },100);
    }
    
    $scope.checkInventory = function(data, row) {    
        var data = parseInt(data);
        var InStocks = row.InStocks;
        
        if(data > InStocks) {
            return 'Quantity exceeds Available Quantity'   
        }
    }
    
    $scope.SubmitRegister = function(hdr,rows) {
        var TransID = transact.TransID(hdr.Branch);
        $scope.register.header.TransID = TransID;
        $scope.register.header.TransDate = $filter('date')(Date.parse(hdr.TransDate), 'yyyy-MM-dd');
        
        var currentdate = $filter('date')(new Date(), 'yyyy-MM-dd');
        
        if(rows.length == 0) {
            return spinner.notif('Please select a product to pullout',1000);}
        
        
        if(hdr.RefNo.length == 0) {
            return spinner.notif('Please enter a Reference Number.',1000);}
        
        
        if(hdr.Branch == 0) {
            $scope.ShowBranchSelect = false;
            return spinner.notif('Please select Branch',1000);}
        
        spinner.show();
        curl.post('/transactions/SubmitPullOut', $scope.register, function(rsp) {
            console.log(rsp);
            spinner.hide();
            spinner.notif(rsp.message, 1000, rsp.status);
            if(rsp.status) {
                $location.path('/stocks/pullout/receipt/' + TransID);
            }
        });
    }
    
    console.log("Pull-out module has been initialized!");
}

function pulloutReceiptCtrl($scope, $stateParams, curl, Auth, $state,
                            spinner, $filter, transact, Inventory, BrnFact) {
    Auth.config(function(rsp) {
        $scope.config = rsp;
    });
    
    var usr = Auth.currentUser();
    BrnFact.getActive(1,function(brn) {$scope.branches = brn;});
    Inventory.getWarehouse(function(whs) {$scope.WhsList = whs;});
    
    $scope.Filler = function(id, type) {
        var selected = [];
        if(type==1) {
            selected = $filter('filter')($scope.WhsList, {WhsCode: id}, true);
        }else{
            selected = $filter('filter')($scope.branches, {BranchID: id}, true);
        }
        return (type==1) ? selected[0].WhsName : selected[0].Description;
    }
    
    spinner.show();
    curl.get('/transactions/PulloutReceipt/' + $stateParams.TransID, function(rsp) {
        spinner.hide();
        $scope.register = rsp;
    });
    
    var params = (usr.Roles!=4) ? 'Status in (1,2,3) and TransDate="' + $filter('date')(new Date(), 'yyyy-MM-dd') + '"' : 'Status in (1,2,3) and Branch =' +usr.Branch.BranchID;
    $scope.PulloutStatus = function(TransID, status) {
        spinner.show();
        transact.ChangePulloutStatus(TransID, status, usr.UID, params, usr, function(r) {
            spinner.hide();
            if(r.status) {
                console.log(r);
                spinner.notif(r.message, 1500, r.status);
                $state.reload();
            }else{
                spinner.notif(r.message, 1500);
            }
        });
    }
}

function pulloutHistoryCtrl($scope, transact, Auth, spinner, curl,
                        Inventory, filterFilter, $filter, BrnFact) {
    console.log('Initializing Transfer History Module');
    
    $scope.WhsList = [];
    $scope.branches = [];
    $scope.pList = [];
    $scope.currentPage = 1;
    $scope.pageSize = 10; // items per page
    
    
    
    var usr = Auth.currentUser();
    
    $scope.advance = {
        AllBranch: (usr.Roles!=4) ? true:false,
        Status: -1,
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
    
    var params = (usr.Roles!=4) ? 'Status in (1,2,3) and TransDate="' + $filter('date')(new Date(), 'yyyy-MM-dd') + '"' : 'Status in (1,2,3) and Branch =' +usr.Branch.BranchID;
    transact.history(params, 'view_pullout', function(rsp) {
        $scope.pList = rsp;
//        transact.history('TransferType=0 and Status=2 and InvTo =' + usr.Branch.BranchID, 'view_transfer', function(li) {
//            if(li.length) {
//                angular.extend($scope.pList, li); }
            $scope.totalItems = $scope.pList.length;
            $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
//        });
    });
    
    Inventory.getWarehouse(function(whs) {
        $scope.WhsList = whs;
        BrnFact.getActive(1,function(brn) {
            $scope.branches = brn;
        });
    });
    
    $scope.filter = function(id) {
        spinner.show();
        var params = (usr.Roles!=4) ? 'RefNo like "%'+id+'%"' : 'RefNo like "%'+id + '%" and Branch =' + usr.Branch.BranchID;
        transact.history(params, 'view_pullout', function(rsp) {
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
    
    $scope.Filler = function(id, type) {
        var selected = [];
        if(type==1) {
            selected = $filter('filter')($scope.WhsList, {WhsCode: id}, true);
        }else{
            selected = $filter('filter')($scope.branches, {BranchID: id}, true);
        } 
        
        if(type==1) {
            return (id && selected.length) ? selected[0].WhsName : 'Select Warehouse';
        }else{
            return (id && selected.length) ? selected[0].Description : 'Select Branch';
        }
    }
    
    $scope.AdvanceFilter = function(f) {
        $scope.pList = [];
        
        var DateFrom = $filter('date')(new Date(f.DateFrom), 'yyyy-MM-dd');
        var DateTo = $filter('date')(new Date(f.DateTo), 'yyyy-MM-dd');
        var branch = (f.AllBranch) ? '':' and Branch =' + ((usr.Roles !=4) ? parseInt(f.Branch) :parseInt(usr.Branch.BranchID));
        var status = (f.Status==-1) ? '' : ' and Status =' + parseInt(f.Status);
        
        var params = 'TransDate <= "' + DateTo + '" and TransDate >= "' + DateFrom + '"' + status + branch;
        
        spinner.show();
        transact.history(params, 'view_pullout', function(rsp) {
            $scope.pList=rsp;
//            transact.history('TransferType=0 and Status=2 and InvTo =' + usr.Branch.BranchID, 'view_transfer', function(li) {
                spinner.hide();
                $scope.collapse = true;
//                spinner.notif(rsp.message, 1500, rsp.status);

//                if(li.length) {
//                    angular.extend($scope.pList, li); }
              
                if($scope.pList.length==0) {
                    spinner.notif('No Record Found!', 1000);
                }

                $scope.totalItems = $scope.pList.length;
                $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
//            });
        });
    }
    
    $scope.PulloutStatus = function(TransID, status) {
        spinner.show();
        transact.ChangePulloutStatus(TransID, status, usr.UID, params, usr, function(r) {
            spinner.hide();
            if(r.status) {
                spinner.notif(r.message, 1500, r.status);
                $scope.pList = r.myList;
                
                $scope.totalItems = $scope.pList.length;
                $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);    
            }else{
                spinner.notif(r.message, 1500);
            }
        });
    }
    
    $scope.exportFields = {
        TransDate: 'Date',
        RefNo: 'Reference Number',
        BranchCode: 'Store Code',
        Description: 'Store Name',
        CategoryDesc: 'Store Category',
        GroupDesc: 'Store Group',
        TypeDesc: 'Store Type',
        ChannelDesc: 'Store Channel',
        CityDesc: 'Store City',
        Quantity: 'Quantity',
        Total: 'Total',
        Comments: 'Comments',
        DisplayName: 'Cashier',
        ApprovedBy: 'Approved By',
        ConfirmedBy: 'Confirmed By'
    }
    
    console.log('Transfer History Module has been initialized');
}

app.controller('pulloutCtrl', pulloutCtrl);
app.controller('pulloutReceiptCtrl', pulloutReceiptCtrl);
app.controller('pulloutHistoryCtrl', pulloutHistoryCtrl);

$(document).ready(function() {
    $('.podate').datepicker();
    $('#PoBranch, #PoSupplier').select2();
});