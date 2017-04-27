'use strict';

function branchCtrl($scope, curl) {
    
    $('#BrnCity,#BrnManager').select2();
    $scope.notify = false;
    $scope.branch = {
        Type: 1,
        Category: 1,
        IsTaxInclude: true,
        IsBackdateAllowed: false,
        SalesTax: 12,
        DefaultReturnPolicy: 7
    }
    
    curl.get('/branches/links', function(rsp) {
        $scope.lnk = rsp;
    });
    
    $scope.addStore = function() {
        curl.post('/branches/addBranch', $scope.branch, function(rsp) {

            $scope.notify = true;
            $scope.success = rsp.success;
            $scope.err_msg = rsp.message;
            
            $scope.branch = {};
            $scope.myForm.$setPristine();
        });
    }
    
}

function brnListCtrl($scope, curl, $state, $timeout, spinner
                      , $filter, filterFilter, BrnFact) {
    if (!$('#page-wrapper').hasClass('nav-small')) {$('#page-wrapper').addClass('nav-small');}
    var ForUpdateBranchID;
    $scope.targets = [];
    $scope.branches = [];
    $scope.currentPage = 1;
    $scope.pageSize = 10; // items per page

    spinner.show();
    BrnFact.getReferences(function(rsp) { $scope.lnk = rsp; });    
    BrnFact.getBranches(function(rsp) {
        $scope.branches = rsp;
        spinner.hide();
        $scope.totalItems = $scope.branches.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
    });

    
    // $watch search to update pagination
	$scope.$watch('find', function (newVal, oldVal) {
        console.log(newVal);
		$scope.filtered = filterFilter($scope.branches, newVal);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);
    
    $scope.$watch('pageSize', function () {
		$scope.filtered = filterFilter($scope.branches, $scope.find);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);
    
    // Open Target Modal
    $scope.setTarget = function(obj) {
        ForUpdateBranchID = parseInt(obj.BranchID);
        $scope.targets = [];
        $scope.branch = {
            Description: obj.Description,
            Address: obj.Address
        }
        
        BrnFact.getTarget(ForUpdateBranchID, function(rsp) {
            $scope.targets = rsp;
            $('#setTarget').modal('show');
        });
        
    }
    
    // add Target
    $scope.addTarget = function() {
        $scope.inserted = {
            Month: $filter('date')(new Date(), 'yyyy-MM'),
            Target: 100000
        };
        $scope.targets.push($scope.inserted);
    };
    
    // remove Target
    $scope.removeTarget = function(index) {
        console.log(index);
        $scope.targets.splice(index, 1);
    }
    
    // save Target
    $scope.saveTarget = function(data) {
        //$scope.user not updated yet
        BrnFact.addTarget(angular.extend(data, {
            BranchID: ForUpdateBranchID}));
    };    

    // Open Edit Branch Modal
    $scope.showModal = function(obj) {
        ForUpdateBranchID = parseInt(obj.BranchID);
        $scope.branch = {
            Description: obj.Description,
            Address: obj.Address,
            BranchEmail: obj.BranchEmail,
            Type: parseInt(obj.Type),
            Channel: parseInt(obj.Channel),
            Groups: parseInt(obj.Groups),
            Category: parseInt(obj.Category),
            City: parseInt(obj.City),
            Manager: parseInt(obj.Manager),
            Avatar: obj.Avatar,
            Expiry: obj.Expiry,
            BranchSize: parseInt(obj.BranchSize)
        }
        
        $('#editBranchData').modal('show');
    }
    
    var indx;
    $scope.showSeries = function(s) {
//        var s = $scope.branches[index];
        indx = s; console.log(s);
        ForUpdateBranchID = parseInt(s.BranchID);
        $scope.series = {
            Start: parseInt(s.Start),
            End: parseInt(s.End),
            Current: parseInt(s.Current)
        };
        $scope.SetBranch = s.Description;
        $('#setSeries').modal('show');
    }
    
    // Update Branch Modal Button
    $scope.updateBranch = function() {
        var data = {
            BranchID: ForUpdateBranchID,
            type: $scope.branch
        }
        
        curl.post('/branches/setVal', data, function(rsp) {
            console.log(rsp);
            $('#editBranchData').modal('hide');
            $timeout(function() {
                $state.reload();
            },200);
        });
    }
    
    $scope.updateSeries = function() {
        if(($scope.series.Start <= $scope.series.Current) && ($scope.series.Current < $scope.series.End)) {
            var data = {
                Branch: ForUpdateBranchID,
                type: $scope.series
            };
            
            curl.post('/branches/updateSeries', data, function(r) {
                indx.Start = $scope.series.Start;
                indx.Current = $scope.series.Current;
                indx.End = $scope.series.End;
                
                console.log(r);
                
                $scope.show_notif = true;
                $scope.response = r;
                $timeout(function() {$scope.show_notif = false;},1500);
            });
        }else{
            $scope.show_notif = true;
            $scope.response = {status:false, message:'Overlaping Series, please check.'}
            $timeout(function() {$scope.show_notif = false;},1000);
            return false;
        }
    }

    // Update Name, Address and Branch Code Function
    $scope.changeNameCode = function(code, type, state) {
        var data = '{"BranchID":' + code + ',"type": {"' + type + '":"' + state + '"}}';
        
        curl.post('/branches/setVal', data, function(rsp) {
            console.log(rsp);
        });
    }
    
    // Update Type, Channel, Group and Category Function
    // Update Branch Modal Info
    $scope.changeVal = function(id, field, data, type=false) {  
        BrnFact.updateField(id, field, data, function(rsp) {
            console.log(rsp);
        }, type);
    }
    
    $scope.exportFields = {
        BranchCode: 'Branch Code',
        Description: 'Name',
        BranchEmail: 'Email',
        CategoryDesc: 'Category',
        ChannelDesc: 'Sales Channel',
        CityDesc: 'City',
        GroupDesc: 'Store Group',
        TypeDesc: 'Type',
        BranchSize: 'Size (sqm)',
        Expiry: 'Contract Expiration',
        SalesTax: 'Sales Tax',
        AreaManager: 'Area Manager',
        DefaultReturnPolicy: 'Allowable Return Days',
        IsBackdateAllowed: 'Allow Backdating',
        IsActive: 'Active',
        CreateDate: 'Create Date',
    }
}

app.controller('branchCtrl', branchCtrl);
app.controller('brnListCtrl', brnListCtrl);

$(document).ready(function() {
    $('.select').select2({width:"100%"});
});
