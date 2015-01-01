'use strict';

app.factory('acctService', function($http, $location, sessionService) {

    return {
        username: function() {
            return sessionService.get('username');
        },
        email: function() {
            return sessionService.get('email');
        },
        isLogged:function() {
            var $promise = $http.post('api/auth/verify.php');
            return $promise;
        },
        login:function(account, scope) {
            var $promise = $http.post('api/auth/login.php', account);
            $promise.then(function(response) {
                var data = response.data;   // get returned JSON content
                if(data.success) {
                    console.log("Login success!");
                    sessionService.set('uid', data.uid);
                    sessionService.set('username', data.username);
                    sessionService.set('acctType', data.acctType);
                    sessionService.set('email', data.email);
                    
                    if(data.acctType == 'user') {
                        $location.path('/user/home');
                    }
                    else if(data.acctType == 'merchant') {
                        $location.path('/merchant/home');
                    }
                }
                else {
                    console.log("Login error");
                    scope.msgtxt = "Login failed. Please try again";
                }
            });
        },
        logout:function() {
            sessionService.destroy('username');
            sessionService.destroy('uid');
            sessionService.destroy('email');
            $location.path('/login');
        },
        create:function(account,scope) {
            var $promise = $http.post('api/account/new.php', account);
            $promise.then(function(response) {
                var data = response.data;   // get returned JSON content
                if(data.success) {
                    console.log("New account created");
                    $location.path('/login');
                }
                else {
                    console.log("New account error");
                    $location.path('/home');
                }
            });
        },
        //not needed, should be removed.
        loginUser:function(user, scope) {
            var $promise = $http.post('api/auth/login.php', user);
            $promise.then(function(response) {
                var data = response.data;   // get returned JSON content
                if(data.success) {
                    console.log("Login success!");
                    sessionService.set('username', data.username);
                    sessionService.set('email', data.email);
                    sessionService.set('uid', data.uid);
                    $location.path('/user/home');
                }
                else {
                    console.log("Login error");
                    scope.msgtxt = "Login failed. Please try again";
                }
            });
        },
        loginMerch:function(user, scope) {
            var $promise = $http.post('api/merchant/login.php', user);
            $promise.then(function(response) {
                var data = response.data;   // get returned JSON content
                if(data.success) {
                    console.log("Login success!");
                    sessionService.set('username', data.username);
                    sessionService.set('email', data.email);
                    sessionService.set('uid', data.uid);
                    $location.path('/merchant/home');
                }
                else {
                    console.log("Login error");
                    scope.msgtxt = "Login failed. Please try again";
                }
            });
        },
        createMerchant:function(acct, scope) {
            var $promise = $http.post('api/merchant/new.php', acct);
            $promise.then(function(response) {
                var data = response.data;   // get returned JSON content
                if(data.success) {
                    console.log("New merchant account success");
                    $location.path('/login');
                }
                else {
                    console.log("New merchant account error");
                    $location.path('/home');
                }
            });
        }
    }
});
