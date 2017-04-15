'use strict';

function campaignCtrl($scope, ItemFact, BrnFact, $filter, 
                       filterFilter, $window) {
    console.log('Initializing Price Campaign Module!');
    
    $scope.campaignList = [];
    $scope.pageSize = 10;
    $scope.currentPage = 1;
    
    var CurrentDate = $filter('date')(new Date(), 'MM-dd-yyyy');
    
    $scope.campaign = {
        title: {
            DateFrom: $filter('date')(new Date(), 'MM-dd-yyyy'),
            DateTo: $filter('date')(new Date(), 'MM-dd-yyyy'),   
        },
        products: [],
        BranchID: []
    }
    
    // $watch search to update pagination
	$scope.$watch('find', function (newVal, oldVal) {
		$scope.filtered = filterFilter($scope.campaignList, newVal);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);    
    
    $scope.$watch('pageSize', function () {
		$scope.filtered = filterFilter($scope.campaignList, $scope.find);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);
    
    //get All Campaign
    ItemFact.getAllCampaign(function(rsp) { 
        $scope.campaignList = rsp; 
        $scope.totalItems = $scope.campaignList.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
    });
    
    $scope.showBranches = function(cmp) {
     var selected = [];
        angular.forEach($scope.brnList, function(s) {
            if (cmp.Stores.indexOf(s.BranchID) >= 0) {
                selected.push(s.Description);
            }
        });
     return selected.length ? selected : 'Not set';
    };
    
    $scope.showItemCode = function(itmID) {
        var selected = [];
        selected = $filter('filter')($scope.itemList, {
                    PID: itmID }, true);
        return (selected) ? selected[0].ProductDesc : 'Not Found';
    }
    
    //Get all active branches
    BrnFact.getActive(1, function(rsp) { $scope.brnList = rsp; });

    //Get all active products
    ItemFact.activeProducts(1, function(rsp) { $scope.itemList = rsp; });

    // add Product to campaign
    $scope.addListItems = function() {
        $scope.inserted = {
            PID: 0,
            SRP: 0
        };
        $scope.campaign.products.push($scope.inserted);
    };
    
    // remove product in campaign
    $scope.removeListItem = function(index) {
        console.log(index);
        $scope.campaign.products.splice(index, 1);
    }
    
    //Fill Checkbox x-editable
    $scope.Filler = function (status) {
        var selected = $filter('filter')($scope.itemList, {
                    PID: status }, true);
        return (status && selected.length) ? selected[0].ProductDesc : 'Select Item';
    };
    
    //Add new Campaign
    $scope.createCampaign = function() {
        var cmp = $scope.campaign;
        $scope.notify = false;
        
        if(cmp.title.CampaignName == undefined || cmp.title.CampaignName.length == 0) {
            $scope.notify = true;
            $scope.error = true; $scope.message = 'Please specify a name for this campaign!';
            return false;
        }
        
        if(new Date(cmp.title.DateFrom) < new Date(CurrentDate)) {
            $scope.notify = true;
            $scope.error = true; $scope.message = 'Date from should be equal of greater than the current date.';
            return false;
        }
        
        if(new Date(cmp.title.DateFrom) > new Date(cmp.title.DateTo)) {
            $scope.notify = true;
            $scope.error = true; $scope.message = 'Date from should be less than Date To!';
            return false;
        }
        
        if($scope.campaign.products.length == 0 || $scope.campaign.BranchID.length == 0) {
            $scope.notify = true;
            $scope.error = true; $scope.message = 'Please select a product and store for this campaign';
            return false;
        }
        
        ItemFact.addCampaign($scope.campaign, function(rsp) {
            console.log(rsp);
            
            if(rsp.success) {
                $scope.campaign = {
                    title: {
                        DateFrom: $filter('date')(new Date(), 'MM-dd-yyyy'),
                        DateTo: $filter('date')(new Date(), 'MM-dd-yyyy'),   
                    },
                    products: [],
                    BranchID: []
                };
                $scope.notify = true;
                $scope.error = false;
                $scope.message = rsp.message;
                $scope.toggle = false;
                
                ItemFact.getAllCampaign(function(rsp) { 
                    $scope.campaignList = rsp; 
                    $scope.totalItems = $scope.campaignList.length;
                    $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
                    $scope.currentPage = 1;
                });
            }
        });
        
    }
    
    //delete a Campaign
    $scope.deleteCampaign = function(CmpID) {
        var cnf = $window.confirm('Are you sure you want to deactivate this campaign?');
        if(cnf) {
            ItemFact.deleteCampaign(CmpID, function(rsp) {
                $scope.notify = true;
                $scope.error = rsp.success;
                $scope.message = rsp.message;
                
                ItemFact.getAllCampaign(function(rsp) { 
                    $scope.campaignList = rsp; 
                    $scope.totalItems = $scope.campaignList.length;
                    $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
                    $scope.currentPage = 1;
                });
            });
        }
    }
    
    console.log('Price Campaign Module has been successfully initialized!');
}


app.controller('campaignCtrl', campaignCtrl);

$(document).ready(function() {
    $('#CampaignDateFrom, #CampaignDateTo').datepicker({
	  format: 'mm-dd-yyyy'
	});
    
    $('.ProductDesc').select2();
    
    $('#multipleSelectBranch').select2({
        placeholder: 'Select a Store',
		allowClear: true
    });
    
    $('#multipleSelectItem').select2({
        placeholder: 'Select Products',
		allowClear: true
    });
});