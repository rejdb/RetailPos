function transferCtrl($scope, curl, transact, Auth, spinner, ItemFact, Inventory, BrnFact,
                       $filter, $timeout, $location) {
    console.log("Initializing Transfer Module!");
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
        DestiBranch: usr.Branch.Description,
        DestiAddress: usr.Branch.Address || '',
        SelectedWhs: 'Good Stocks',
        SelectDestiWhs: 'Select Warehouse',
        SourceWhs: 1,
        header: {
            TransferNo: '',
            TransDate: $filter('date')(new Date(), 'MM/dd/yyyy'),
            Branch: usr.Branch.BranchID,
            InvFrom: 1,
            InvTo: 0,
            Quantity: 0,
            Total: 0,
            TransferType: 1,
            Comments: '',
            CreatedBy: usr.UID
        },
        rows: []
    }
    
    
    $scope.TransferOption = function(TransferType) {
        $scope.register.header.TransferType = TransferType;
        $scope.register.header.InvFrom = 0;
        $scope.register.header.InvTo = 0;
        $scope.Reset();
        if(TransferType==1) {
            $scope.ShowWarehouse = false;
            $scope.ShowDestiBranch = false;
            $scope.ShowDestiBranchSelect = false;
            $scope.register.header.InvFrom = $scope.register.SourceWhs;
        }else{
            $scope.ShowWarehouse = true;
            $scope.ShowDestiBranch = true;
            $scope.register.header.InvFrom = $scope.register.header.Branch;
            $scope.register.header.InvTo = 0;
        }
    }
    
    Inventory.getActiveWhs(1,function(whs) {$scope.WhsList = whs; $scope.itemLoader = false;});
    BrnFact.getActive(1,function(brn) {$scope.branches = brn; $scope.brnLoader = false;});
    
    $scope.resetBranch = function(hdr){
        hdr.Branch = 0;
        $scope.Reset();
        $scope.ShowBranchSelect = false;
    }
    
    $scope.GetBranch = function(selected) {
        $scope.register.header.Branch = parseInt(selected.originalObject.BranchID);
        $scope.register.BranchName = selected.originalObject.Description;
        $scope.ShowBranchSelect = true;
        
        if($scope.register.header.TransferType == 0) {
            $scope.register.header.InvFrom = parseInt(selected.originalObject.BranchID);
        }
    }
    
    $scope.resetDestiBranch = function(hdr){
        hdr.InvTo = 0;
        $scope.ShowDestiBranchSelect = false;
    }
    
    $scope.GetBranchDesti = function(selected) {
        $scope.register.header.InvTo = parseInt(selected.originalObject.BranchID);
        $scope.register.DestiBranch = selected.originalObject.Description;
        $scope.register.DestiAddress = selected.originalObject.Address;
        $scope.ShowDestiBranchSelect = true;
    }
    
    $scope.SelectWhs = function(WhsID) {
        var selected = [];
        selected = $filter('filter')($scope.WhsList, {WhsCode: WhsID}, true);
        
        $scope.Reset();
        $scope.register.SourceWhs = parseInt(WhsID);
        $scope.register.SelectedWhs = (WhsID && selected.length) ? selected[0].WhsName : 'Select Warehouse';
        
        if($scope.register.header.TransferType==1) {
            $scope.register.header.InvFrom = parseInt(WhsID);
        }
    }
    
    $scope.GetWarehouse = function(WhsID) {
        var selected = [];
        selected = $filter('filter')($scope.WhsList, {WhsCode: WhsID}, true);
        
        $scope.register.SelectDestiWhs = (WhsID && selected.length) ? selected[0].WhsName : 'Select Warehouse';
        $scope.register.header.InvTo = parseInt(WhsID);
    }
    
    $scope.Reset = function() {
        $scope.register.rows = [];
        items = []; imei = [];
        $scope.register.SelectDestiWhs = 'Select Warehouse'
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
        
        if(hdr.InvFrom == 0) {
            spinner.notif('Please select Inventory Source!', 1000);
            return false; }
        
        if(hdr.InvTo == 0) {
            spinner.notif('Please select Inventory Destination!', 1000);
            return false; }
        
        if(hdr.InvFrom == hdr.InvTo) {
            spinner.notif('Inventory Source and Destination should not be the same!', 1500);
            return false; }
        
        if(imei.indexOf($scope.SearchProduct.toLowerCase())>=0) {
            spinner.notif('Serial already exists in the row! please select another item.', 1000);
            return false; }
        
        if(items.indexOf($scope.SearchProduct.toLowerCase())>=0) {
            spinner.notif('Product already exists in the row! please select another product', 1000);
            return false; }
        
        var data = {
            'Type': parseInt(hdr.TransferType),
            'Branch': parseInt(hdr.Branch),
            'Warehouse': (hdr.TransferType == 1) ? parseInt(hdr.InvFrom) : parseInt($scope.register.SourceWhs),
            'Search': $scope.SearchProduct
        }
        
        
        $scope.itemLoader = true;
        curl.post('/Inventories/SearchInventory', data, function(rsp) {
            $scope.SearchProduct = '';
            $scope.itemLoader = false;
            
            if(!rsp.status) {
                spinner.notif(rsp.message, 1500);
                return false;
            }else{
                var data = rsp.result;
                $scope.register.header.Quantity += 1;
                $scope.register.header.Total += parseFloat(data.StdCost);
                
                if(data.IsSerialized == 1) {
                    imei.push(data.Serial.toLowerCase());
                }else{ items.push(data.BarCode.toLowerCase()); }
                
                console.log(imei);
                console.log(items);
                console.log(items.indexOf($scope.SearchProduct));
                
                
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
            return spinner.notif('Please select a product to transfer',1000);}
        
        
        if(hdr.TransferNo.length == 0) {
            return spinner.notif('Please enter a Transfer Number.',1000);}
        
        
        if(hdr.Branch == 0) {
            $scope.ShowBranchSelect = false;
            return spinner.notif('Please select Branch',1000);}
        
        spinner.show();
        curl.post('/transactions/SubmitTransfer', $scope.register, function(rsp) {
            console.log(rsp);
            spinner.hide();
            spinner.notif(rsp.message, 1000, rsp.status);
            if(rsp.status) {
                $location.path('/stocks/transfer/receipt/' + TransID);
            }
        });
    }
    
    console.log("Transfer module has been initialized!");
}

function transferReceiptCtrl($scope, $stateParams, curl, Auth, $state,
                            spinner, $filter, transact, Inventory, BrnFact) {
    Auth.config(function(rsp) {
        $scope.config = rsp;
    });
    
    var usr = Auth.currentUser();
    Inventory.getWarehouse(function(whs) {$scope.WhsList = whs;});
    BrnFact.getActive(1,function(brn) {$scope.branches = brn;});
    
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
    curl.get('/transactions/TransferReceipt/' + $stateParams.TransID, function(rsp) {
        $scope.register = rsp;
        spinner.hide();
    });
    
    var params = (usr.Roles!=4) ? 'Status in (1,2,3) and TransDate="' + $filter('date')(new Date(), 'yyyy-MM-dd') + '"' : 'Status in (1,2,3) and Branch =' +usr.Branch.BranchID;
    $scope.TransferStatus = function(TransID, status, store) {
        spinner.show();
        transact.ChangeTransferStatus(TransID, status, store, usr.UID, params, usr, function(r) {
            spinner.hide();
            if(r.status) {
                spinner.notif(r.message, 1500, r.status);
                $state.reload();
            }else{
                spinner.notif(r.message, 1500);
            }
        });
    }
}

function transferHistoryCtrl($scope, transact, Auth, spinner, curl,
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
    
    spinner.show();
    var params = (usr.Roles!=4) ? 'Status in (1,2,3) and TransDate="' + $filter('date')(new Date(), 'yyyy-MM-dd') + '"' : 'Status in (1,2,3) and Branch =' +usr.Branch.BranchID;
    transact.history(params, 'view_transfer', function(rsp) {
        $scope.pList = rsp; spinner.hide();
        transact.history('TransferType=0 and Status=2 and InvTo =' + usr.Branch.BranchID, 'view_transfer', function(li) {
            if(li.length) {
                angular.extend($scope.pList, li); }
            $scope.totalItems = $scope.pList.length;
            $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
        });
    });
    
    Inventory.getWarehouse(function(whs) {
        $scope.WhsList = whs;
        BrnFact.getActive(1,function(brn) {
            $scope.branches = brn;
        });
    });
    
    $scope.filter = function(id) {
        spinner.show();
        var params = (usr.Roles!=4) ? 'TransferNo like "%'+id+'%"' : 'TransferNo like "%'+id + '%" and Branch =' + usr.Branch.BranchID;
        transact.history(params, 'view_transfer', function(rsp) {
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
        transact.history(params, 'view_transfer', function(rsp) {
            $scope.pList=rsp;
            transact.history('TransferType=0 and Status=2 and InvTo =' + usr.Branch.BranchID, 'view_transfer', function(li) {
                spinner.hide();
                $scope.collapse = true;
                spinner.notif(rsp.message, 1500, r.status);

                if(li.length) {
                    angular.extend($scope.pList, li); }
                
                if($scope.pList.length==0) {
                    spinner.notif('No Record Found!', 1000);
                }

                $scope.totalItems = $scope.pList.length;
                $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
            });
        });
    }
    
    $scope.TransferStatus = function(TransID, status, store) {
        spinner.show();
        transact.ChangeTransferStatus(TransID, status, store, usr.UID, params, usr, function(r) {
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
        TransferNo: 'Reference Number',
        BranchCode: 'Store Code',
        Description: 'Store Name',
        CategoryDesc: 'Store Category',
        GroupDesc: 'Store Group',
        TypeDesc: 'Store Type',
        ChannelDesc: 'Store Channel',
        CityDesc: 'Store City',
        TransType: 'Transfer Type',
        TransferFrom: 'Transfer From',
        TransferTo: 'Transfer To',
        Quantity: 'Quantity',
        Total: 'Total',
        Comments: 'Comments',
        DisplayName: 'Cashier',
        ApprovedBy: 'Approved By',
        ReceivedBy: 'Received By'
    }
    
    console.log('Transfer History Module has been initialized');
}

app.controller('transferCtrl', transferCtrl);
app.controller('transferReceiptCtrl', transferReceiptCtrl);
app.controller('transferHistoryCtrl', transferHistoryCtrl);

$(document).ready(function() {
    $('.podate').datepicker();
    $('#PoBranch, #PoSupplier').select2();
});