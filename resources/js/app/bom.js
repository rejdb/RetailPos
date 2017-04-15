'use strict';

function bomCtrl($scope, spinner, Inventory, 
                  filterFilter, ItemFact, $filter) {
    console.log('Initializing Bill of Material Module!');
    
    $scope.BoMs = [];
    $scope.itemList = [];
    $scope.whsList = [];
    
    $scope.pageSize = 10;
    $scope.currentPage = 1;
    
    $scope.material = { 
        bom: {},
        Products: []
    }
    
    /*** $watch search to update pagination ***/
	$scope.$watch('find', function (newVal, oldVal) {
		$scope.filtered = filterFilter($scope.BoMs, newVal);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);    
    
    $scope.$watch('pageSize', function () {
		$scope.filtered = filterFilter($scope.BoMs, $scope.find);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);
    /*** End of Pagination watcher ***/
    
    ItemFact.activeProducts(1, function(rsp) { $scope.itemList = rsp; });
    Inventory.getWarehouse(function(rsp) { $scope.whsList = rsp; });
    Inventory.getBoM(function(rsp) { 
        $scope.BoMs = rsp; 
        $scope.totalItems = $scope.BoMs.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
    });
    
    //Fill Checkbox x-editable
    $scope.Filler = function (status) {
        var selected = [];
        selected = $filter('filter')($scope.itemList, {
                    PID: status }, true);
        return (status && selected.length) ? selected[0].ProductDesc : 'Select Item';
    };
    
    //Fill Checkbox x-editable
    $scope.FillerWhs = function (status) {
        var selected = []; 
        selected = $filter('filter')($scope.whsList, {
                    WhsCode: status }, true);
        return (status && selected.length) ? selected[0].WhsName : 'Select Item';
    };
    
    // update BoM Fields
    $scope.changeVal = function(id, field, data, type=false) {
        Inventory.updateBoM(id, field, data, function(rsp) {
            console.log(rsp);
        }, type);
    }
    
    // update BoM Fields item
    $scope.changeValItem = function(id, field, data, type=false) {
        Inventory.updateBoMItem(id, field, data, function(rsp) {
            console.log(rsp);
        }, type);
    }
    
    // add Product to BoM
    $scope.addListItems = function() {
        $scope.inserted = {
            PID: '1',
            WhsCode: '1'
        };
        $scope.material.Products.push($scope.inserted);
    };
    
    // remove product in BoM
    $scope.removeListItem = function(index) {
        $scope.material.bom.Products.splice(index, 1);
    }
    
    // remove product in List of BoM
    $scope.removeBoMListItem = function(index) {
        console.log(index);
    }
    
    /* Add new BoM to Database */
    $scope.addNewBoM = function() {
        if($scope.material.Products.length == 0) {
            spinner.alert({status:false,message:'Please select bundled product'});
            return false;
        }
        
        spinner.show();
        Inventory.addBoM($scope.material, function(rsp) {
            spinner.hide();
            spinner.alert(rsp);
            
            if(rsp.status) {
                Inventory.getBoM(function(rsp) { 
                    $scope.BoMs = rsp; 
                    
                    $scope.bomBomForm.$setPristine();
                    $scope.addBOM = true;
                    $scope.material.bom = {};
                    $scope.material.Products = [];
                    
                    $scope.currentPage = 1;
                    $scope.totalItems = $scope.BoMs.length;
                    $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
                });
            }
        });
        
    }
    
    
    console.log('BOM has been initialized successfully!');
}

app.controller('bomCtrl', bomCtrl);