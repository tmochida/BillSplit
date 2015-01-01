//login service.
//CURRENTLY DEPRECATED, SHOULD USE ACCTSERVICE!!!

'use strict';

app.factory('loginService', function($http, $location, sessionService) {

    return {
        getUserName: function() {
            return sessionService.get('username');
        },
        login:function(account, scope) {
            console.loge(account);
            console.loge(account.acctType);

            var $promise = $http.post('api/auth/login.php', account);
            $promise.then(function(response) {
                var data = response.data;   // get returned JSON content
                if(data.success) {
                    console.log("Login success!");
                    scope.msgtxt = "Login success!";
                    console.log(data);
                    sessionService.set('username', data.username);
                    sessionService.set('uid', data.uid);
                    $location.path('/home');
                }
                else {
                    console.log("Login error");
                    scope.msgtxt = "Login fail!";
                    $location.path('login');
                }
            });
        },
        loginMerch:function(user, scope) {
            var $promise = $http.post('api/merchant/login.php', user);
            $promise.then(function(response) {
                var data = response.data;   // get returned JSON content
                if(data.success) {
                    console.log("Login success!");
                    scope.msgtxt = "Login success!";
                    sessionService.set('username', data.username);
                    sessionService.set('uid', data.uid);
                    $location.path('/home');
                }
                else {
                    console.log("Login error");
                    scope.msgtxt = "Login fail!";
                    $location.path('login');
                }
            });
        },
        logout:function() {
            sessionService.destroy('username');
            sessionService.destroy('uid');
            $location.path('/login');
        },
        isLogged:function() {
            var $promise = $http.post('api/auth/verify.php');
            return $promise;
        }
    }
});
