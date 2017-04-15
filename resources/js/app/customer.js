'use strict';

function customerCtrl($scope, $filter, spinner, Customer, Auth, 
                      filterFilter, $timeout, curl, BrnFact) {
    console.log("Initializing Customer Module");
    if (!$('#page-wrapper').hasClass('nav-small')) {$('#page-wrapper').addClass('nav-small');}
    
    $scope.customers = [];
    $scope.pageSize = 10;
    $scope.currentPage = 1;
    var tabSelected = 1;
    var usr = Auth.currentUser();
    
    /*** $watch search to update pagination ***/
	$scope.$watch('find', function (newVal, oldVal) {
		$scope.filtered = filterFilter($scope.customers, newVal);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);    
    
    $scope.$watch('pageSize', function () {
		$scope.filtered = filterFilter($scope.customers, $scope.find);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);
    /*** End of Pagination watcher ***/
    
    /* Load all Customers */
    var params = (usr.Roles!=4) ? 'Branch!="-1"': 'Branch = "' + parseInt(usr.Branch.BranchID) + '"';
    curl.post('/customers/all', {params: params}, function(rsp) {
        $scope.customers = rsp;
        $scope.totalItems = $scope.customers.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
    });
    
    curl.get('/branches/links', function(rsp) {
        $scope.lnk = rsp;
    });
    BrnFact.getActive(1,function(rsp) {$scope.branches = rsp;});
    
    //Manage Modal Tabs Navigation
    $scope.onTabs = function(obj) {
        tabSelected = obj;
        $scope.tabSel = tabSelected;
    }
    
    $scope.Filler = function(id, type) {
        var selected = [];
        if(type=='CustCity') {
            selected = $filter('filter')($scope.lnk.cities, {
                    CityID: id }, true);
            return (id && selected.length) ? selected[0].City : 'Not Set';
        }else if(type=='CustProvince') {
            selected = $filter('filter')($scope.lnk.provinces, {
                    ProvinceID: id }, true);
            return (id && selected.length) ? selected[0].Province : 'Not Set';
        }else{
            selected = $filter('filter')($scope.branches, {
                    BranchID: id }, true);
            return (id && selected.length) ? selected[0].Description : 'Not Set';
        }
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
    
    /* Add New Customer */
    $scope.addNewCustomer = function() {
        console.log($scope.customer);
        $scope.saving = true;
        Customer.add($scope.customer, function(rsp) {
            $scope.response = rsp;
            $scope.saving = false;
            $scope.show_notif = true;
            $timeout(function() {$scope.show_notif = true;},1000);
            
            if(rsp.status) {
                $scope.customers.push(rsp.data);
                $scope.currentPage = 1;
                $scope.totalItems = $scope.customers.length;
                $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);

                $scope.formAddCust.$setPristine();
                $scope.customer = {};
                $scope.onTabs(1);
            }
        });
    }
    
    /* Update Supplier Field */
    $scope.updateField = function(id, field, data, type=false) {
        Customer.updateField(id, field, data, function(rsp) {
            console.log(rsp);
        }, type);
    }
    
    $scope.exportFields = {
        CardNo: 'Card No.',
        CustFirstName: 'First Name',
        CustLastName: 'Last Name',
        CustEmail: 'Email',
        ContactNo: 'Contact No',
        Address: 'Street',
        Cust_City: 'City',
        Cust_Provice: 'Provice',
        BranchDesc: 'Deployed Branch',
        CustCredits: 'Current Credits',
        CustPoints: 'Current Points',
        CreateDate: 'Creation Date',
        UpdateDate: 'Activation Date',
        IsActive: 'Active',
    };
    console.log("Customer Module has been initialized successfully!");
}

app.controller('customerCtrl', customerCtrl)

$(document).ready(function() {
    $('.select').select2({
        width: "100%"
    });
//    $('#myCustomers').modal('show');
//        placeholder: "Select a state",
//    });
//    $('#CustCity,#CustProvince').select2();
});