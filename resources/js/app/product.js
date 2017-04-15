'use strict';

function productCtrl($scope, curl, ItemFact, 
                      $filter, filterFilter, 
                      $window, $timeout) {
    console.log('Initializing product module');
    if (!$('#page-wrapper').hasClass('nav-small')) {$('#page-wrapper').addClass('nav-small');}
    
    $scope.items = [];
    $scope.lnk = [];
    $scope.toggle = false;
    $scope.currentPage = 1;
    $scope.pageSize = 1000;
    var tabSelected = 1;
    
    $scope.product = {
        Category: 1,
        IsSerialized: true
    }
    
    // $watch search to update pagination
	$scope.$watch('find', function (newVal, oldVal) {
		$scope.filtered = filterFilter($scope.items, newVal);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);    
    
    $scope.$watch('pageSize', function () {
		$scope.filtered = filterFilter($scope.items, $scope.find);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);
    
    //Load Table Reference
    ItemFact.tableReference(function(rsp) {$scope.lnk = rsp;});
    
    //Fill Checkbox x-editable
    $scope.Filler = function (type, status) {
        var selected = [];
        switch(type) {
            case 'brand':
                selected = $filter('filter')($scope.lnk.brands, {
                    BrandID: status }, true); break;
            case 'category':
                selected = $filter('filter')($scope.lnk.categories, {
                    P_CatID: status }, true); break;
            case 'cycles':
                selected = $filter('filter')($scope.lnk.cycles, {
                    P_CycleID: status }, true); break;
            case 'families':
                selected = $filter('filter')($scope.lnk.families, {
                    FamID: status }, true); break;
            case 'type':
                selected = $filter('filter')($scope.lnk.types, {
                    TypeID: status }, true); break;
            default:
                selected = $filter('filter')($scope.lnk.pricelists, {
                    PLID: status }, true); break;
        }
        return (status && selected.length) ? selected[0].Description : 'Not set';
    };
    
    
    //Load All products
    ItemFact.products(function(rsp) {
        $scope.items = rsp;
        $scope.totalItems = $scope.items.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
    });
    
    //Update Item data by field
    $scope.updateItem = function(id, field, data, type=false) {
        ItemFact.update(id, field, data, function(rsp) {
            console.log(rsp);
            if(field=='PriceList') {
                ItemFact.products(function(l_items) {
                    $scope.items = l_items; });
            }
        }, type);
    }
    
    //add new table reference data
    $scope.addItemReference = function(reference, data) {
        ItemFact.addReference(reference, data, function(rsp) {
            $window.alert(rsp.message);
            ItemFact.tableReference(function(rsp) {
                $scope.lnk = rsp;
            });
        });
    }
    
    //Update current SRP
    $scope.updateSRP = function(id, field, data) {
        ItemFact.updateCurrentSRP(id,field,data, function(rsp) {
            console.log(rsp.message);
        });
    }
    
    //Manage Modal Tabs Navigation
    $scope.onTabs = function(obj) {
        tabSelected = obj;
        $scope.tabSel = tabSelected;
    }
    
    $scope.onNav = function(obj) {
        $scope.notify = false;
        if(obj==='next') {
            $timeout(function() {
                tabSelected++;
                $('.wizard-card .nav-pills > .active').next('li').find('a').trigger('click'); 
            });
        }else {
            $timeout(function() {
                tabSelected--;
                $('.wizard-card .nav-pills > .active').prev('li').find('a').trigger('click');    
            });
        }
        
        $scope.tabSel = tabSelected;
    }
    
    //Add product to the database
    $scope.addNewProduct = function() {
        $scope.saving = true;
        var postData = {
            product: $scope.product,
            price: $scope.pricelist.Price
        }
        console.log(postData);
        ItemFact.addNewProductDB(postData, function(rsp) {
            console.log(rsp);
            $scope.notify = true;
            $scope.saving = false;
            $scope.response = rsp;
            
            if(rsp.success) {
                $scope.formAddItem.$setPristine();
                $scope.product = {}
                $scope.pricelist = {};
                ItemFact.products(function(rsp) {
                    $scope.items = rsp;
                    $scope.totalItems = $scope.items.length;
                    $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
                    $scope.currentPage = 1;
                    
//                    $scope.onTabs(1)
                    $scope.product = {
                        Category: 1,
                        IsSerialized: true
                    }
                    
//                      $scope.tabSel = 1;
                    $timeout(function() {
                        $('.wizard-card .nav-pills > .active').prev('li').find('a').trigger('click');    
                    });
                });
            }
        });
    }
    
    $scope.exportFields = {
        BarCode: 'Item Code',
        ProductDesc: 'Item Name',
        SKU: 'SKU',
        TypeDesc: 'Type',
        BrandDesc: 'Brand',
        FamilyDesc: 'NS Brand',
        CategoryDesc: 'Category',
        CycleDesc: 'Life Cycle',
        PriceListDesc: 'Default Pricelist',
        OrderLevel: 'Re-Order Level',
        StdCost: 'Cost',
        CurrentPrice: 'Price',
        Inventory: 'Total Inventory',
        CreateDate: 'Create Date',
        IsActive: 'Active',
    }
    
    
    console.log('Product Module has been successfully initialized!');
}

app.controller('productCtrl', productCtrl);