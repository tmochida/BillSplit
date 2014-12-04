'use strict';

app.factory('acctService', function($http, $location, sessionService) {

    return {
        username: function() {
            return sessionService.get('username');
        },
        email: function() {
            return sessionService.get('email');
        },
        wallet_addr: function() {
            return sessionService.get('wallet_addr');
        },
        login:function(user, scope) {
            var $promise = $http.post('ops/auth/login.php', user);
            $promise.then(function(response) {
                var data = response.data;   // get returned JSON content
                if(data.success) {
                    console.log("Login success!");
                    scope.msgtxt = "Login success!";
                    sessionService.set('username', data.username);
                    sessionService.set('email', data.email);
                    sessionService.set('wallet_addr', data.wallet_addr);
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
            var $promise = $http.post('ops/merchant/login.php', user);
            $promise.then(function(response) {
                var data = response.data;   // get returned JSON content
                if(data.success) {
                    console.log("Login success!");
                    scope.msgtxt = "Login success!";
                    sessionService.set('username', data.username);
                    sessionService.set('email', data.email);
                    sessionService.set('wallet_addr', data.wallet_addr);
                    sessionService.set('uid', data.uid);
                    $location.path('/merchant/home');
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
            sessionService.destroy('wallet_addr');
            $location.path('/login');
        },
        isLogged:function() {
            var $promise = $http.post('ops/auth/verify.php');
            return $promise;
        },
        createUser:function(acct,scope) {
            var $promise = $http.post('ops/account/new.php', acct);
            $promise.then(function(response) {
                var data = response.data;   // get returned JSON content
                if(data.success) {
                    console.log("New individual account success");
                    $location.path('/login');
                }
                else {
                    console.log("New individual account error");
                    $location.path('/home');
                }
            });
        },
        createMerchant:function(acct, scope) {
            var $promise = $http.post('ops/merchant/new.php', acct);
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