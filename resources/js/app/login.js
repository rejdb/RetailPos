'use strict';

var login = angular.module('loginApp', [
    'ui.bootstrap',
    'ui.router',
	'angular-loading-bar',
	'ngAnimate',
	'easypiechart',
    'jcs-autoValidate',
    'ngCookies'
]);

login.constant('api', {
    Url: '/api',
    Token: '3acf5c7b740d6e2538f3a7b88cf069b3'
});

login.service('spinner', ['$rootScope', function($rootScope) {
    this.on = function() { $rootScope.loadSpinner = true; }
    this.off = function() { $rootScope.loadSpinner = false; }
    this.show = function() { $rootScope.loadSpinner = true; }
    this.hide = function() { $rootScope.loadSpinner = false; }
    this.alert = function(alert_me) { 
        $rootScope.notify = true;
        $rootScope.successfully = alert_me.status;
        $rootScope.alert_message = alert_me.message;
    } 
    this.alert_off = function() { $rootScope.notify = false; }
}]);
login.service('curl', ['$http', 'api', function($http, api) {
    this.get = function(url, callback) {
        $http({
            url: api.Url + url,
            method: 'GET',
            headers: { 'x-api-key' : api.Token }
        }).then(function(response){
            callback(response.data);
        }, function(error) {
            console.log(error);
        });
    }

    this.post = function(url, postData, callback) {
        $http({
            url: api.Url + url,
            method: 'POST',
            data: postData,
            headers: { 'x-api-key' : api.Token }
        }).then(function(response){
            callback(response.data);
        }, function(error) {
            console.log(error);
        });
    }
}]);
login.service('cookie', ['$cookieStore', function($cookieStore) {
    this.get = function(cookie_name) {
        return $cookieStore.get(cookie_name);}
    
    this.put = function(cookie_name, cookie_value) {
        $cookieStore.put(cookie_name, cookie_value); }
    
    this.remove = function(cookie_name) {
        $cookieStore.remove(cookie_name);}
}]);
login.factory('Auth', ['curl','cookie', '$rootScope', 
    function(curl,cookie, $rootScope) {
    var auth = {};
    
    auth.login = function(username, password, callback) {
        curl.post('/users/login', {
            Email: username,
            Password: password
        }, function(rsp) {
            if(rsp.success) {
                cookie.put('profile', rsp.user);}
            callback(rsp);
        });
    }
    
    auth.logout = function() {
        cookie.remove('profile')
        $rootScope.userProfile = '';
    };
    
    return auth;
}]);

login.controller('loginCtrl', function($scope, spinner, Auth, $window, $rootScope) {
    console.log('Initializing Login Module');
    
    Auth.logout();
    
    $scope.submitLogin = function() {
        var username = $scope.login.Email;
        var password = $scope.login.Password;
        
        spinner.show();
        Auth.login(username, password, function(rsp) {
            if(rsp.success) {
               console.log(rsp);
               if (rsp.user.Roles==4) {
                    $window.location.href = '/sales/invoice';
               }else{
                    $window.location.href = '/';
               }
            }else{
                spinner.hide();
                spinner.alert({
                   status: rsp.success,
                    message: rsp.message
                });
            }
        });
    }
    
    console.log('Login module has been initialized successfully!');
});

//login.controller('loginCtrl', ['$scope', '$window', '$http', 'api', '$cookieStore', 
//                               function($scope, $window, $http, api, $cookieStore) {
//    
//    $cookieStore.remove('userAuth');
//    $cookieStore.remove('tbxConfig');
//    
//    $scope.submitLogin = function() {
////        console.log($scope.login);
//        var btn = $('#SubmitBtn').button('loading');
//        
//        $http({
//            url: api.Url + '/users/login',
//            method: 'POST',
//            data: $scope.login,
//            headers: { 'x-api-key' : api.Token }
//        }).then(function(rsp){
//            btn.button('reset');
//            
//            if(rsp.data.success) {
//                console.log(rsp.data.user);
//                $window.location.href = '/'
//                $cookieStore.put('userAuth', JSON.stringify(rsp.data.user));
//            }else{
//                $scope.error = true;
//                $scope.err_msg = rsp.data.message;
//            }
//        }, function(error) {
//            console.log(error);
//        });
//        
//        
////        $window.location.href = '/'
//    }
//}]);