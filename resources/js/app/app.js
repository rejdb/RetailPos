'use strict';

var app = angular.module('tbxWebApp', [
    'ui.bootstrap',
    'ui.router',
	'angular-loading-bar',
	'ngAnimate',
	'easypiechart',
    'jcs-autoValidate',
    'ngCookies',
    'uiSwitch',
    'xeditable',
    'ngPrint',
    'ngTagsInput',
    'ngJsonExportExcel',
    'angucomplete-ie8'
]);

app.config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
	cfpLoadingBarProvider.includeBar = true;
	cfpLoadingBarProvider.includeSpinner = true;
	cfpLoadingBarProvider.latencyThreshold = 100;
}]);

/**
 * Configure the Routes
 */

app.config(['$stateProvider', '$urlRouterProvider', '$locationProvider', 
            function($stateProvider, $urlRouterProvider, $locationProvider) {   
    $stateProvider
    .state('Root', {
        url: '/',
        templateUrl: '/home/dashboard',
        controller: 'mainCtrl',
        title: 'Home',
//        authenticate: true
        
    })
    .state('MyDashboard', {
        url: '/Dashboard',
        templateUrl: '/home/dashboard',
        controller: 'mainCtrl',  
        title: 'Dashboard',
        authenticate: true,
    })
    .state('MyPassword', {
        url: '/change/password',
        templateUrl: '/home/password',
        controller: 'mainCtrl',  
        title: 'Change Password',
        authenticate: true
    })
    .state('Purchasing', {
        url: '/purchase/order',
        templateUrl: '/home/purchase_order',
        controller: 'purchaseCtrl',  
        title: 'Purchase Order',
        authenticate: true,
        permissions: [1,5]
    })
    .state('Purchasing_receipt', {
        url: '/purchase/receipt/:TransID',
        templateUrl: '/home/purchase_receipt',
        controller: 'purchaseReceiptCtrl',  
        title: 'Purchase Receipts',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('Purchasing_history', {
        url: '/purchase/history',
        templateUrl: '/home/purchase_history',
        controller: 'purchaseHistoryCtrl',  
        title: 'Purchase History',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('Purchasing_received', {
        url: '/purchase/received/:transid',
        templateUrl: '/home/purchase_received',
        controller: 'purchaseReceivedCtrl',  
        title: 'Purchase Received',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('Purchasing_received_receipt', {
        url: '/purchase/received/receipt/:transid',
        templateUrl: '/home/purchase_received_receipt',
        controller: 'purchaseReceivedReceiptCtrl',  
        title: 'Purchase Received',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('SalesInvoices', {
        url: '/sales/invoice',
        templateUrl: '/home/sales_invoice',
        controller: 'salesCtrl',  
        title: 'Sales Invoice',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('SalesInvoicesReceipt', {
        url: '/sales/invoice/receipt/:TransID',
        templateUrl: '/home/sales_invoice_receipt',
        controller: 'salesReceiptCtrl',  
        title: 'Invoice Receipt',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('SalesInvoicesHistory', {
        url: '/sales/invoice/history',
        templateUrl: '/home/sales_invoice_history',
        controller: 'salesHistoryCtrl',  
        title: 'Sales Logs',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('SalesPostpaid', {
        url: '/sales/postpaid',
        templateUrl: '/home/sales_postpaid',
        controller: 'postpaidCtrl',  
        title: 'Postpaid',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('SalesReturn', {
        url: '/sales/return',
        templateUrl: '/home/sales_return',
        controller: 'returnCtrl',  
        title: 'Sales Return',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('SalesReturnReceipt', {
        url: '/sales/return/receipt/:TransID',
        templateUrl: '/home/sales_return_receipt',
        controller: 'returnReceiptCtrl',  
        title: 'Returned Receipt',
        authenticate: true,
        permissions: [1,2,4,6]
    })
    .state('SalesReturnHistory', {
        url: '/sales/return/history',
        templateUrl: '/home/sales_return_history',
        controller: 'returnHistoryCtrl',  
        title: 'Sales Return Logs',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('StocksReceiving', {
        url: '/stocks/receiving',
        templateUrl: '/home/stocks_receiving',
        controller: 'receivingCtrl',  
        title: 'Stocks Receiving',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('StocksReceiving_receipt', {
        url: '/stocks/receiving/receipt/:TransID',
        templateUrl: '/home/stocks_receiving_receipt',
        controller: 'receivingReceiptCtrl',  
        title: 'Receiving Receipts',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('StocksReceiving_history', {
        url: '/stocks/receiving/history',
        templateUrl: '/home/stocks_receiving_history',
        controller: 'receivingHistoryCtrl',  
        title: 'Receiving History',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('StocksTransfer', {
        url: '/stocks/transfer',
        templateUrl: '/home/stocks_transfer',
        controller: 'transferCtrl',  
        title: 'Stocks Transfer',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('StocksTransfer_receipt', {
        url: '/stocks/transfer/receipt/:TransID',
        templateUrl: '/home/stocks_transfer_receipt',
        controller: 'transferReceiptCtrl',  
        title: 'Transfer Receipts',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('StocksTransfer_history', {
        url: '/stocks/transfer/history',
        templateUrl: '/home/stocks_transfer_history',
        controller: 'transferHistoryCtrl',  
        title: 'Transfer History',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('StocksPullout', {
        url: '/stocks/pullout',
        templateUrl: '/home/stocks_pullout',
        controller: 'pulloutCtrl',  
        title: 'Stocks Pull-out',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('StocksPullout_receipt', {
        url: '/stocks/pullout/receipt/:TransID',
        templateUrl: '/home/stocks_pullout_receipt',
        controller: 'pulloutReceiptCtrl',  
        title: 'Pullout Receipts',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('StocksPullout_history', {
        url: '/stocks/pullout/history',
        templateUrl: '/home/stocks_pullout_history',
        controller: 'pulloutHistoryCtrl',  
        title: 'Pullout History',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('Cash_Register', {
        url: '/cash/register',
        templateUrl: '/home/cash_register',
        controller: 'cashHistoryCtrl',  
        title: 'Cash Register',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state('Cash_Card', {
        url: '/cash/card',
        templateUrl: '/home/cash_card',
        controller: 'cardHistoryCtrl',  
        title: 'Non Cash Payment',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    // Report Management
    .state('Reports_Sales_Summary', {
        url: '/reports/sales/summary',
        templateUrl: '/home/reports_sales_summary',
        controller: 'salesSummaryCtrl',  
        title: 'Sales Summary',
        authenticate: true,
    })
    .state('Reports_Sales_Detailed', {
        url: '/reports/sales/detailed',
        templateUrl: '/home/reports_sales_detailed',
        controller: 'salesDetailedCtrl',  
        title: 'Sales Detailed',
        authenticate: true,
    })
    .state('Reports_inventory_current', {
        url: '/reports/inventory/current',
        templateUrl: '/home/reports_inventory_current',
        controller: 'inventoryCtrl',  
        title: 'Current Inventory',
        authenticate: true,
    })
    .state('Reports_inventory_serials', {
        url: '/reports/inventory/serials',
        templateUrl: '/home/reports_inventory_serials',
        controller: 'inventorySerialCtrl',  
        title: 'Available Serial',
        authenticate: true,
    })
    .state('Reports_inventory_tracking', {
        url: '/reports/inventory/tracking',
        templateUrl: '/home/reports_inventory_tracking',
        controller: 'inventoryTrackingCtrl',  
        title: 'Available Serial',
        authenticate: true,
    })
    .state('Reports_inventory_movement', {
        url: '/reports/inventory/smr',
        templateUrl: '/home/reports_inventory_smr',
        controller: 'inventoryMovementCtrl',  
        title: 'SMR',
        authenticate: true,
    })
    // Content Management Module
    .state("GeneralConfig", {
        url: "/setup/store-config",
        templateUrl: "/home/store_setup",
        controller: "genSetup",
        title: "General Config",
        authenticate: true,
        permissions: ['1']
    })
    .state("CreateSuperuser", {
        url: "/setup/superusers",
        templateUrl: "/home/superuser",
        controller: "SuperAdmin",
        title: "Administrator",
        authenticate: true,
        permissions: ['1']
    })
    .state("Branches", {
        url: "/Branches",
        templateUrl: "/home/branches",
        controller: "branchCtrl",
        title: "Branch",
        authenticate: true,
        permissions: ['1']
    })
    .state("BranchList", {
        url: "/Branch/List",
        templateUrl: "/home/branchlist",
        controller: "brnListCtrl",
        title: "Branch List",
        authenticate: true,
        permissions: [1,2,5,6]
    })
    .state("EmployeeManager", {
        url: "/employee/manager",
        templateUrl: '/home/employee/manager',
        title: "Manager Setup",
        controller: 'managerCtrl',
        authenticate: true,
        permissions: ['1']
    })
    .state("EmployeeHo", {
        url: "/employee/head-office",
        templateUrl: '/home/employee/personnel',
        title: "Head Office User Setup",
        controller: 'personnelCtrl',
        authenticate: true,
        permissions: ['1']
    })
    .state("EmployeeFl", {
        url: "/employee/frontliner",
        templateUrl: '/home/employee/fl',
        title: "Frontliner Setup",
        controller: 'frontlinerCtrl',
        authenticate: true,
        permissions: ['1']
    })
    .state("Profile", {
        url: "/user/profile",
        templateUrl: "/home/profile",
        title: "Product Discount",
        controller: 'profileCtrl',
        authenticate: true
    })
    .state("Products", {
        url: "/inventory/products",
        templateUrl: "/home/product_lists",
        title: "Products",
        controller: 'productCtrl',
        authenticate: true,
        permissions: [1,2,5,6]
    })
    .state("Campaign", {
        url: "/inventory/product/campaign",
        templateUrl: "/home/product_campaign",
        title: "Product Campaign",
        controller: 'campaignCtrl',
        authenticate: true,
        permissions: [1,2,5,6]
    })
    .state("BOM", {
        url: "/inventory/billofmaterial",
        templateUrl: "/home/inventory_bom",
        title: "BOM",
        controller: 'bomCtrl',
        authenticate: true,
        permissions: [1,2,5,6]
    })
    .state("Supplier", {
        url: "/suppliers",
        templateUrl: "/home/suppliers",
        title: "Suppliers",
        controller: 'supplierCtrl',
        authenticate: true,
        permissions: [1,2,5,6]
    })
    .state("CRM", {
        url: "/customers",
        templateUrl: "/home/customers",
        title: "CRM",
        controller: 'customerCtrl',
        authenticate: true,
        permissions: [1,2,4,5,6]
    })
    .state("Login", {
        url: "/login",
        login: true
    });
    
    $urlRouterProvider.otherwise('/');
}]);

app.config(function($locationProvider) {
    $locationProvider.html5Mode(true);
//  $locationProvider.hashPrefix('');
})

app.run(['$location', '$rootScope', '$window', 'editableOptions', 'Auth',
         function($location, $rootScope, $window, editableOptions, Auth) {
    
    Auth.init();
    editableOptions.theme = 'bs3';
             
    $rootScope.$on('$stateChangeSuccess', function (event, toState, toParams, fromState, fromParams, error) {
        $rootScope.title = toState.title;
         $rootScope.loadSpinner = false;
        Auth.MainPage();
        document.body.scrollTop = document.documentElement.scrollTop = 0;
    });

    $rootScope.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams) {
        if(!Auth.checkPermissionForView(toState) || toState.login) {
            event.preventDefault();
            $window.location.href = "/login";
        }
        
        if(toState.reports) {
            $location.path(toState.url);
        }
    });
}]);