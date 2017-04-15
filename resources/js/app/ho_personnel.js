'use strict'

function personnelCtrl($scope, curl, UserFact, filterFilter, 
                      $state, $timeout, $window) {
    console.log("Initializing HO Personnel Module");
    
    $scope.user = {Roles: 2};
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
    
    UserFact.getUsers(-1, function(rsp) {
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
            UserFact.resetPwd(uid, function(rsp) {
                $window.alert(rsp.message);
            });    
        }
    }
    
    //Add Store Manager
    $scope.addHOPersonnel = function() {     
        $scope.user.DisplayName = $scope.user.FirstName + ' ' + $scope.user.LastName;
        
        UserFact.addUser("/setup/superuser", $scope.user, function(rsp) {
            if(!rsp.error) {
                $('#myPersonnel').modal('hide');
                $timeout(function() {
                    $state.reload();
                },200);
            }else{
                $scope.error = true;
                $scope.err_msg = rsp.message;

            }
        });
    }
    
    
    console.log("HO personnel module has been successfully initialized!");
}

app.controller('personnelCtrl', personnelCtrl);