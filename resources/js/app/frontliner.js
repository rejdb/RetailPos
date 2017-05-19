'use strict';

function frontlinerCtrl($scope, curl, filterFilter, 
                         $timeout, $state, $filter, UserFact, $window) {
    console.log('Initializing Frontliner Module!');
    
    $scope.users = [];
    $scope.branches = [];
    $scope.currentPage = 1;
    $scope.pageSize = 10;
    var tabSelected = 1;
    
    // $watch search to update pagination
	$scope.$watch('find', function (newVal, oldVal) {
		$scope.filtered = filterFilter($scope.users, newVal);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);    
    
    $scope.$watch('pageSize', function () {
		$scope.filtered = filterFilter($scope.users, $scope.find);
		$scope.totalItems = $scope.filtered.length;
		$scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
		$scope.currentPage = 1;
	}, true);
    
    curl.get('/users/fl', function(rsp) {
        $scope.users = rsp.users;
        $scope.totalItems = $scope.users.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
    });
    
    curl.get('/branches/status/1', function(rsp) {$scope.branches = rsp;});
    
    //Update int data function
    $scope.updateIntFl = function(id, type, data) {
        var save = '{"UID":' + id + ',"type": {"' + type + '":' + data + '}}';
        curl.post('/setup/updateFl', save, function(rsp) {console.log(rsp);});
    }
    
    //Update string data function
    $scope.updateUser = function(id, field, data, type=false) {
        UserFact.update(id, field, data, function(rsp) {
            console.log(rsp);
        }, type);
    }
    
    //Reset Password
    $scope.changePwd = function(UID) {
        var cnf = $window.confirm('Are you sure you want to reset user password?');
        if(cnf) {
            UserFact.resetPwd(UID, function(rsp) {
                $window.alert(rsp.message);
            });    
        }
    }
    
    $scope.repeatFiller = function (status) {
        var selected = $filter('filter')($scope.branches, {
            BranchID: status
        }, true);
        return (status && selected.length) ? selected[0].Description : 'Not set';
    };
    
    $scope.onTabs = function(obj) {
        tabSelected = obj;
        $scope.tabSel = tabSelected;
    }
    
    $scope.onNav = function(obj) {
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
    
    //submit form to store record
    $scope.addFrontliner = function() {
        var DisplayName = $scope.user.FirstName + ' ' + $scope.user.LastName;
        angular.extend($scope.user, {Roles: 4,
                DisplayName: DisplayName});
        var data = {
            user: $scope.user
        }
        
        angular.extend(data, {fl: $scope.fl});
        
        curl.post('/setup/frontliner', data, function(rsp) {
            $scope.notify = true;
            $scope.response = rsp;
            
            if(rsp.success) {
                $('#myFrontLiner').modal('hide');
                $timeout(function() {
                    $state.reload();
                },1000);
            }
        });
    }
    
    console.log('Frontliner Module has been Initialized!');
}

app.controller('frontlinerCtrl', frontlinerCtrl);

$(document).ready(function() {
    $('.select').select2({
        width: "100%"
    });
});