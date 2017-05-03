'use strict';

function salesSummaryCtrl($scope, transact, Auth, spinner, curl,
                        Inventory, filterFilter, $filter, BrnFact) {
    console.log('Initializing Sales Report Summary Module');
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
    
    BrnFact.getActive(1,function(brn) { $scope.branches = brn; });
    
    $scope.AdvanceFilter = function(f) {
        $scope.pList = [];
        
        var DateFrom = $filter('date')(new Date(f.DateFrom), 'yyyy-MM-dd');
        var DateTo = $filter('date')(new Date(f.DateTo), 'yyyy-MM-dd');
        var branch = (f.AllBranch) ? '':' and Branch =' + ((usr.Roles !=4) ? parseInt(f.Branch) :parseInt(usr.Branch.BranchID));
        
        var params = 'TransDate <= "' + DateTo + '" and TransDate >= "' + DateFrom + '"' + branch;
        
        spinner.show();
        transact.history(params, 'report_sales_summary', function(rsp) {
            $scope.pList=rsp;
            console.log(rsp);
            spinner.hide();
            
            $scope.collapse = true;
            if($scope.pList.length==0) {
                spinner.notif('No Record Found!', 1000); }

            $scope.currentPage = 1;
            $scope.totalItems = $scope.pList.length;
            $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
        });
    }
    
    $scope.exportFields = {
        TransDate: 'Date',
        RefNo: 'Invoice Number',
        BranchCode: 'Store Code',
        Description: 'Store Name',
        CategoryDesc: 'Store Category',
        GroupDesc: 'Store Group',
        TypeDesc: 'Store Type',
        ChannelDesc: 'Store Channel',
        CityDesc: 'Store City',
        Quantity: 'Quantity',
        TotalBefSub: 'Total',
        TotalAfSub: 'Total after Installment',
        SalesTax: 'VAT',
        TotalAfVat: 'Total after VAT',
        Discount: 'Discount',
        NetTotal: 'Total Net of Discount',
        ShortOver: 'Short / Over',
        DisplayName: 'Cashier',
        Comments: 'Comments',
    }
    
    console.log('Sales Report Summary Module has been initialized');
}

function salesDetailedCtrl($scope, transact, Auth, spinner, curl, $timeout,
                        Inventory, filterFilter, $filter, BrnFact) {
    console.log('Initializing Sales Report Detailed Module');
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
    
//    var params = (usr.Roles!=4) ? 'TransDate="' + $filter('date')(new Date(), 'yyyy-MM-dd') + '"' : 'TransDate = "' + $filter('date')(new Date(), 'yyyy-MM-dd') + '" and Branch =' +usr.Branch.BranchID;
//    transact.history(params, 'report_sales_summary', function(rsp) {
//        $scope.pList = rsp;
//        console.log(rsp);
//        
//        $scope.totalItems = $scope.pList.length;
//        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
//    });
    
    BrnFact.getActive(1,function(brn) { $scope.branches = brn; });
    
    $scope.AdvanceFilter = function(f) {
        $scope.pList = [];
        
        var DateFrom = $filter('date')(new Date(f.DateFrom), 'yyyy-MM-dd');
        var DateTo = $filter('date')(new Date(f.DateTo), 'yyyy-MM-dd');
        var branch = (f.AllBranch) ? '':' and Branch =' + ((usr.Roles !=4) ? parseInt(f.Branch) :parseInt(usr.Branch.BranchID));
        
        var params = 'TransDate <= "' + DateTo + '" and TransDate >= "' + DateFrom + '"' + branch;
        
        spinner.show();
        transact.history(params, 'report_sales_detailed', function(rsp) {
            $scope.pList=rsp;
            spinner.hide();
            
            $scope.collapse = true;
            if($scope.pList.length==0) {
                spinner.notif('No Record Found!', 1000); }

//            $timeout(function() { $('#ExportCSV').click(); },100);
            
            $scope.currentPage = 1;
            $scope.totalItems = $scope.pList.length;
            $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
        });
    }
    
    $scope.exportFields = {
        Week: 'Week',
        Year: 'Year',
        Month: 'Month',
        Day: 'Day',
        TransDate: 'Date',
        RefNo: 'Invoice Number',
        BranchCode: 'Store Code',
        BranchDesc: 'Store Name',
        CategoryDesc: 'Store Category',
        GroupDesc: 'Store Group',
        TypeDesc: 'Store Type',
        ChannelDesc: 'Store Channel',
        CityDesc: 'Store City',
        BarCode: 'Item Code',
        ProductDesc: 'Item Name',
        ItemTypeDesc: 'Item Type',
        SKU: 'SKU',
        BrandDesc: 'Brand',
        FamilyDesc: 'NS Brand',
        ItemCategory: 'Category',
        CycleDesc: 'Life Cycle',
        Campaign: 'Pricelist / Campaign',
        WhsName: 'Warehouse',
        Quantity: 'Quantity'} 
    if(usr.Roles!=4) {angular.extend($scope.exportFields, {Cost: 'Cost',});}
    angular.extend($scope.exportFields, {
        Price: 'Price',
            Subsidy: 'Installment Fee',
            PriceAfSub: 'Price After Installment',
            OutputTax: 'Output Tax',
            TaxAmount: 'Sales Tax',
            PriceAfVat: 'Price After Vat',
            Discount: 'Discount (%)',
            DiscValue: 'Discount Value',
            Total: 'Total',
            TotalAfSub: 'Total After Installment',
            TotalAfVat: 'Total After Vat',
            TotalAfDiscount: 'Total After Discount',
            Cash_Payment: 'Cash Payment',
            NonCash_Payment: 'Non-Cash Payment',
            Credit_Payment: 'Credit Card',
            Home_Payment: 'Home Credit',
            PaymentType: 'Payment Type',
            Terms: 'Installment Terms',
            BankTerminal: 'Terminal',
            PaymentRefNumber: 'CC_Reference#',
            PaymentRefNumber_hc: 'HC_Reference#',
            Serial: 'Serial',
            PriceBand: 'Price Band',
            CustomerName: 'Customer Name',
            CustomerContactNo: 'Contact No.',
            CustomerEmail: 'Customer Email.',
            CustomerAddress: 'Customer Address',
            Cashier: 'Cashier',
            Module: 'Module'
    });
    
    console.log('Sales Report Detailed Module has been initialized');
}
app.controller('salesSummaryCtrl', salesSummaryCtrl);
app.controller('salesDetailedCtrl', salesDetailedCtrl);

$(document).ready(function() {
    $('.podate').datepicker();
    $('.select').select2();
});