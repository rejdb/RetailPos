'use strict';

function profileCtrl($scope, curl, Auth) {
    var user = Auth.currentUser();
    console.log(user);
    
    $scope.profile = {
        name: user.DisplayName,
        avatar: user.Avatar,
        roles: user.Roles,
        createdate: Date.parse(user.CreateDate)
    }
};

app.controller('profileCtrl', profileCtrl);