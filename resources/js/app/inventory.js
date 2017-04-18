function inventoryCtrl ($scope, curl, transact, Auth, spinner, ItemFact, Inventory, BrnFact,
                       $filter, $timeout, $location, filterFilter) {
    console.log('Initializing Inventory Report Module');
    if (!$('#page-wrapper').hasClass('nav-small')) {$('#page-wrapper').addClass('nav-small');}
    
    $scope.WhsList = [];
    $scope.branches = [];
    $scope.pList = [];
    $scope.currentPage = 1;
    $scope.pageSize = 10; // items per page
    
    
    
    var usr = Auth.currentUser();
    
    $scope.advance = {
        AllBranch: (usr.Roles!=4) ? true:false,
        Branch: usr.Branch.BranchID,
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
    var params = (usr.Roles!=4) ? 'Available!=0' : 'Available!=0 and Branch =' +usr.Branch.BranchID;
    transact.history(params, 'view_inventory', function(rsp) {
        $scope.pList = rsp;
        spinner.hide();
        
        $scope.totalItems = $scope.pList.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
    });
    
    $scope.exportFields = {
        IsActive: 'Store Status',
        BranchCode: 'Store Code',
        Description: 'Store Name',
        CategoryDesc: 'Store Category',
        GroupDesc: 'Store Group',
        TypeDesc: 'Store Type',
        ChannelDesc: 'Store Channel',
        CityDesc: 'Store City',
        BarCode: 'Item Code',
        ProductDesc: 'Product Description',
        ItemTypeDesc: 'Item Type',
        SKU: 'Model',
        BrandDesc: 'Brand',
        FamilyDesc: 'NS Brand',
        ItemCategoryDesc: 'Item Category',
        CycleDesc: 'Life Cycle',
        WhsName: 'Warehouse',
        InStocks: 'In Stocks',
        Committed: 'Committed',
        Available: 'Available',
    }
    
    if(usr.Roles!=4) {
        angular.extend($scope.exportFields, {
            StdCost: 'Unit Cost',
            CurrentPrice: 'Unit Price',
            CostVatInc: 'Unit Cost (VatInc)',
            PriceVatInc: 'Unit Price (VatInc)',
            TotalCostVatInc: 'Gross Cost Total',
            TotalPriceVatInc: 'Gross Price Total'
        });
    }else{
        angular.extend($scope.exportFields, {
            CurrentPrice: 'Unit Price',
            PriceVatInc: 'Unit Price (VatInc)',
            TotalPriceVatInc: 'Gross Price Total'
        });
    }
    
    Inventory.getWarehouse(function(whs) {
        $scope.WhsList = whs;
        BrnFact.getActive(1,function(brn) {
            $scope.branches = brn;
        });
    });
    
    $scope.AdvanceFilter = function(f) {
        $scope.pList = [];
        
        var branch = (f.AllBranch) ? '':' and Branch =' + ((usr.Roles !=4) ? parseInt(f.Branch) :parseInt(usr.Branch.BranchID));
        
        var params = 'Available!=0' + branch;
        
        spinner.show();
        transact.history(params, 'view_inventory', function(rsp) {
            $scope.pList=rsp;
            spinner.hide();
            $scope.collapse = true;
            
            if($scope.pList.length==0) {
                spinner.notif('No Record Found!', 1000);
            }

            $scope.totalItems = $scope.pList.length;
            $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
        });
    }
    
    console.log('Inventory Report Module has been initialized');
}

function inventorySerialCtrl ($scope, curl, transact, Auth, spinner, ItemFact, Inventory, BrnFact,
                       $filter, $timeout, $location, filterFilter) {
    console.log('Initializing Inventory Serial Module');
    if (!$('#page-wrapper').hasClass('nav-small')) {$('#page-wrapper').addClass('nav-small');}
    
    $scope.WhsList = [];
    $scope.branches = [];
    $scope.pList = [];
    $scope.currentPage = 1;
    $scope.pageSize = 10; // items per page
    
    var usr = Auth.currentUser();
    
    $scope.advance = {
        AllBranch: (usr.Roles!=4) ? true:false,
        Branch: usr.Branch.BranchID,
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
    
    $scope.exportFields = {
        IsActive: 'Store Status',
        BranchCode: 'Store Code',
        Description: 'Store Name',
        CategoryDesc: 'Store Category',
        GroupDesc: 'Store Group',
        TypeDesc: 'Store Type',
        ChannelDesc: 'Store Channel',
        CityDesc: 'Store City',
        BarCode: 'Item Code',
        ProductDesc: 'Product Description',
        ItemTypeDesc: 'Item Type',
        SKU: 'Model',
        BrandDesc: 'Brand',
        FamilyDesc: 'NS Brand',
        ItemCategoryDesc: 'Item Category',
        CycleDesc: 'Life Cycle',
        WhsName: 'Warehouse',
        Serial: 'Serial',
        InDate: 'In Date',
        Ageing: 'Ageing'
    }
    
    
    spinner.show();
    var params = (usr.Roles!=4) ? 'IsSold!=1' : 'IsSold!=1 and Branch =' +usr.Branch.BranchID;
    transact.history(params, 'view_inventory_serials', function(rsp) {
        $scope.pList = rsp;
        spinner.hide();
        $scope.totalItems = $scope.pList.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
    });
    
    Inventory.getWarehouse(function(whs) {$scope.WhsList = whs;});
    BrnFact.getActive(1,function(brn) {$scope.branches = brn;});
    
    $scope.AdvanceFilter = function(f) {
        $scope.pList = [];
        
        var branch = (f.AllBranch) ? '':' and Branch =' + ((usr.Roles !=4) ? parseInt(f.Branch) :parseInt(usr.Branch.BranchID));
        
        var params = 'IsSold!=1' + branch;
        
        spinner.show();
        transact.history(params, 'view_inventory_serials', function(rsp) {
            $scope.pList=rsp;
            spinner.hide();
            $scope.collapse = true;

            if($scope.pList.length==0) {
                spinner.notif('No Record Found!', 1000);
            }

            $scope.totalItems = $scope.pList.length;
            $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
        });
    }
    
    console.log('Inventory Serial Module has been initialized');
}

function inventoryTrackingCtrl ($scope, curl, transact, Auth, spinner, ItemFact, Inventory, BrnFact,
                       $filter, $timeout, $location, filterFilter) {
    console.log('Initializing Tracking Serial Module');
    if (!$('#page-wrapper').hasClass('nav-small')) {$('#page-wrapper').addClass('nav-small');}
    
    $scope.WhsList = [];
    $scope.branches = [];
    $scope.pList = [];
    $scope.currentPage = 1;
    $scope.pageSize = 10; // items per page
    
    
    
    var usr = Auth.currentUser();
    
    $scope.advance = {
        AllBranch: (usr.Roles!=4) ? true:false,
        Branch: usr.Branch.BranchID,
        Type: true
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
    
    $scope.exportFields = {
        IsActive: 'Store Status',
        BranchCode: 'Store Code',
        Description: 'Store Name',
        CategoryDesc: 'Store Category',
        GroupDesc: 'Store Group',
        TypeDesc: 'Store Type',
        ChannelDesc: 'Store Channel',
        CityDesc: 'Store City',
        BarCode: 'Item Code',
        ProductDesc: 'Product Description',
        ItemTypeDesc: 'Item Type',
        BrandDesc: 'Brand',
        FamilyDesc: 'NS Brand',
        ItemCategoryDesc: 'Item Category',
        CycleDesc: 'Life Cycle',
        WhsName: 'Warehouse',
        Serial: 'Serial',
        InDate: 'In Date'
    }
    
    $scope.Available = 0;
    var GetTotal = function() {
        $scope.Available = 0;
        angular.forEach($scope.pList, function(i) {
            $scope.Available += parseInt(i.SumInOut);
        });
    }
    
    BrnFact.getActive(1,function(brn) {$scope.branches = brn;});
    Inventory.getWarehouse(function(whs) {$scope.WhsList = whs;});
    
    $scope.Enter = function(f, e) {
        var code = (e.which) ? e.which : e.keyCode;
        if(code==13) {
            $scope.AdvanceFilter(f);
        }
    }
    
    $scope.AdvanceFilter = function(f) {
        $scope.pList = [];
        
        if(f.Type) {
            var params = 'Serial="' + f.find + '"';
        }else{
            if(usr.Roles!=4 && $scope.advance.Branch==0) { return spinner.notif('Please Select Branch to Search!');}
            var branch = (f.AllBranch) ? '':' and Branch =' + ((usr.Roles !=4) ? parseInt(f.Branch) :parseInt(usr.Branch.BranchID));
            var params = 'BarCode="' + f.find + '"' + branch;
        }

        spinner.show();
        transact.history(params, 'view_smr', function(rsp) {
            $scope.pList=rsp;
            spinner.hide();
            $scope.collapse = true;

            if($scope.pList.length==0) {
                spinner.notif('No Record Found!', 1000);
            }

            GetTotal();
            $scope.totalItems = $scope.pList.length;
            $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
            $scope.currentPage = 1;
        });
    }
    
    console.log('Inventory Tracking Module has been initialized');
}

function inventoryMovementCtrl ($scope, curl, transact, Auth, spinner, ItemFact, Inventory, BrnFact,
                       $filter, $timeout, $location, filterFilter) {
    console.log('Initializing Inventory Movement Report Module');
    if (!$('#page-wrapper').hasClass('nav-small')) {$('#page-wrapper').addClass('nav-small');}
    
    $scope.WhsList = [];
    $scope.branches = [];
    $scope.pList = [];
    $scope.currentPage = 1;
    $scope.pageSize = 10; // items per page
    
    var usr = Auth.currentUser(); 
    $scope.advance = {
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
    
    $scope.exportFields = {
        BranchCode: 'Store Code',
        BranchDesc: 'Store Name',
        CategoryDesc: 'Store Category',
        GroupDesc: 'Store Group',
        TypeDesc: 'Store Type',
        ChannelDesc: 'Store Channel',
        CityDesc: 'Store City',
        BarCode: 'Item Code',
        ProductDesc: 'Product Description',
        ItemTypeDesc: 'Item Type',
        SKU: 'Model',
        BrandDesc: 'Brand',
        FamilyDesc: 'NS Brand',
        ItemCategory: 'Item Category',
        CycleDesc: 'Life Cycle',
        WhsName: 'Warehouse',
        Beginning: 'Beginning',
        GRPO: 'Purchase Received',
        TransferIn: 'Transfer In',
        TransferOut: 'Transfer Out',
        Sales: 'Sales',
        Postpaid: 'Postpaid',
        SalesReturn: 'Return',
        Pullout: 'Pullout',
        Ending: 'Ending',
    }
    
    Inventory.getWarehouse(function(whs) {$scope.WhsList = whs;});
    
    $scope.AdvanceFilter = function(f) {
        $scope.pList = [];
        
        var params = {
            DateFrom: $filter('date')(new Date(f.DateFrom), 'yyyy-MM-dd'),
            DateTo: $filter('date')(new Date(f.DateTo), 'yyyy-MM-dd')
        }
        
        spinner.show();
        curl.post('/inventories/smr', params, function(r) {
            spinner.hide();
            $scope.collapse = true;
            
            $scope.pList=r;
            $scope.totalItems = $scope.pList.length;
            $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
        });
    }
    
    console.log('Inventory Movement Report Module has been initialized');
}

app.controller('inventoryCtrl', inventoryCtrl);
app.controller('inventorySerialCtrl', inventorySerialCtrl);
app.controller('inventoryTrackingCtrl', inventoryTrackingCtrl);
app.controller('inventoryMovementCtrl', inventoryMovementCtrl);

$(document).ready(function() {
    $('.podate').datepicker();
    $('.select').select2({width:"100%"});
});