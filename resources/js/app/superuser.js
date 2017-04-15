'use strict';
var wizard;

function SuperAdmin($scope, $state, $timeout, $window, 
                     UserFact, filterFilter, spinner) {
    console.log('Initializing Superuser module');
    spinner.on();
    
    $scope.user = {Roles: 1};
    $scope.users = [];
    $scope.currentPage = 1;
    $scope.pageSize = 10;
    
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

    UserFact.getUsers(1, function(rsp) {
        spinner.off();
        $scope.users = rsp.users;
        $scope.totalItems = $scope.users.length;
        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
    });
    
    $scope.updateUser = function(id, field, data, type=false) {
        UserFact.update(id, field, data, function(rsp) {
            console.log(rsp);
        }, type);
    }
    
    $scope.resetPwd = function(uid) {
        var cnf = $window.confirm('Are you sure you want to reset user password?');
        if(cnf) {
            spinner.on();
            UserFact.resetPwd(uid, function(rsp) {
                spinner.off();
                spinner.alert({
                    status:true,
                    message:rsp.message});
            });    
        }
    }
    
    //Add Super User
    $scope.saveSuperuser = function() {     
        $scope.user.DisplayName = $scope.user.FirstName + ' ' + $scope.user.LastName;
        $('#mySuperUser').modal('hide');
        
        $timeout(function() {
            spinner.on();
            UserFact.addUser("/setup/superuser", $scope.user, function(rsp) {
                if(!rsp.error) {
                    UserFact.getUsers(1, function(rsp) {
                        spinner.off();
                        $scope.user = {};

                        $scope.users = rsp.users;
                        $scope.currentPage = 1;
                        $scope.totalItems = $scope.users.length;
                        $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
                    });
                }else{
                    spinner.off();
                    spinner.alert({
                        status: false,
                        message: rsp.message
                    });
                    $timeout(function() {
                        spinner.alert_off();
                        $('#mySuperUser').modal('show');
                    }, 500);
                }
            });
        },200);
    }
    
    //Deactivate superuser
    $scope.deleteUser = function(uid) {
        var confirm = $window.confirm("Are you sure do you want to deactivate this user?");
        
        if(confirm) {
            spinner.on();
            UserFact.deActivate(uid, function(rsp) {
                UserFact.getUsers(1, function(rsp) {
                    spinner.off();
                    $scope.users = rsp.users;
                    $scope.currentPage = 1;
                    $scope.totalItems = $scope.users.length;
                    $scope.noOfPages = Math.ceil($scope.totalItems / $scope.pageSize);
                });
            });
        }
    }
    
}

app.controller('SuperAdmin', SuperAdmin);