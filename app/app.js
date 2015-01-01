/* 
 * app.js
 * Declare module and configure routes
 */

// Declare app module
var app = angular.module('app', ['ngRoute']);

// Declare app routes
app.config(function($routeProvider) {
    $routeProvider
        // set up routes and controller
        .when('/home', {
            templateUrl:    'pages/home.html',
            controller:     'homeCtrl'
        })
        
        .when('/new', {
            templateUrl:    'pages/newAccount.html',
            controller:     'newAcctCtrl'
        })
        .when('/login', {
            templateUrl:    'pages/login.html',
            controller:     'loginCtrl'
        })
        
        .when('/user/home', {
            templateUrl:    'pages/user/home.html',
            controller:     'userCtrl'
        })
        .when('/user/payment', {
            templateUrl:    'pages/user/payment.html',
            controller:     'userCtrl'
        })

        .when('/merchant/new', {
            templateUrl:    'pages/merchant/newAccount.html',
            controller:     'newAcctCtrl'
        })
        .when('/merchant/home', {
            templateUrl:    'pages/merchant/home.html',
            controller:     'userCtrl'
        })
        .when('/wallet', {
            templateUrl:    'wallet.html',
        })

        .otherwise({
            redirectTo:   '/home'
        })
    // set HTML5 mode for clean URL, disbled for now.
    //$locationProvider.html5Mode(true);
});

app.run(function($rootScope, $location, acctService) {

    var needLogin = ['/user', '/merchant']; // routes that need login
    
    $rootScope.$on('$routeChangeStart', function() { // called on every route change
        // block unauthenticated access to protected routes
        needLogin.forEach(function(route) {
            if ($location.path().indexOf(route) == 0) {
                var loggedIn=acctService.isLogged();
                loggedIn.then(function(response){
                    var data = response.data;
                    if(!data.success) {
                        console.log("not logged in yet");
                        $location.path('/login');
                    }
                    else {
                        console.log("Already logged in");
                    }
                });
            }
        });
        /*if (needLogin.indexOf($location.path()) != -1) {
            // check if logged in
            var loggedIn=acctService.isLogged();
			loggedIn.then(function(response){
                var data = response.data;
				if(!data.success) {
                    console.log("not logged in yet");
                    $location.path('/login');
                }
                else {
                    console.log("Already logged in");
                }
			});
        }*/
    });
});
