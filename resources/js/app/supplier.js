'use strict';

function supplierCtrl($scope, $filter, spinner, Supplier, 
                       filterFilter, $timeout) {
    console.log("Initializing Supplier Module");
    
    $scope.suppliers = [];
    $scope.pageSize = 10;
    $scope.currentPage = 1;
    var tabSelected = 1;
    
    /*** $watch search to update pagination ***/
	$scope.$watch('find', function (newVal, oldVal) {
		$scope.filtered = filterFilter($scope.suppliers, newVal);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);    
    
    $scope.$watch('pageSize', function () {
		$scope.filtered = filterFilter($scope.suppliers, $scope.find);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);
    /*** End of Pagination watcher ***/
    
    /* Load all Suppliers */
    Supplier.all(function(rsp) {
        $scope.suppliers = rsp;
        $scope.totalItems = $scope.suppliers.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
    });
    
    //Manage Modal Tabs Navigation
    $scope.onTabs = function(obj) {
        tabSelected = obj;
        $scope.tabSel = tabSelected;
    }
    
    $scope.onNav = function(obj) {
        $scope.show_notif = false;
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
    
    /* Add New Supplier */
    $scope.addNewSupplier = function() {
        console.log($scope.supplier);
        $scope.saving = true;
        Supplier.add($scope.supplier, function(rsp) {
            $scope.response = rsp;
            $scope.saving = false;
            $scope.show_notif = true;
            
            if(rsp.status) {
                $scope.suppliers.push(rsp.data);
                $scope.currentPage = 1;
                $scope.totalItems = $scope.suppliers.length;
                $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);

                $scope.formAddSupp.$setPristine();
                $scope.supplier = {};
                $scope.onTabs(1);
            }
        });
    }
    
    /* Update Supplier Field */
    $scope.updateField = function(id, field, data, type=false) {
        Supplier.updateField(id, field, data, function(rsp) {
            console.log(rsp);
        }, type);
    }
    
    $scope.exportFields = {
        CoyName: 'Company Name',
        ContactPerson: 'Contact Person',
        ContactNo: 'Contact No',
        Email: 'Email',
        ShipTo: 'Ship To Address',
        BillTo: 'Bill To Address',
        CreateDate: 'Creation Date',
        UpdateDate: 'Last Update Date',
        IsActive: 'Active',
    };
    
    console.log("Supplier Module has been initialized successfully!");
}

app.controller('supplierCtrl', supplierCtrl)

$(document).ready(function() {
//    $('#mySupplier').modal('show');
});