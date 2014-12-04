/* 
 * controllers.js
 * Defines controllers for app
 */

'use strict';

app.controller('mainCtrl', function($scope, titleService) {
    $scope.titleService = titleService;
});

app.controller('loginCtrl', function($scope, titleService, acctService) {
    titleService.setTitle('Login - BillSplit');
    $scope.msgtxt = '';
    $scope.login = function(user) {
        acctService.login(user, $scope);
    };
});

app.controller('loginMerchCtrl', function($scope, titleService, acctService) {
    titleService.setTitle('Login Merchant - BillSplit');
    $scope.msgtxt = '';
    $scope.login = function(user) {
        acctService.loginMerch(user, $scope);
    };
});

app.controller('homeCtrl', function($scope, titleService, acctService) {
    titleService.setTitle('Home - BillSplit');
    //$scope.username = acctService.username();
    $scope.logout=function() {
        acctService.logout();
    };
});

app.controller('newAcctCtrl', function($scope, titleService, acctService) {
    titleService.setTitle('New account - BillSplit');
    $scope.createUser = function(acct) {
        acctService.createUser(acct, $scope);
    };
    $scope.createMerchant = function(acct) {
        acctService.createMerchant(acct, $scope);
    };
});

app.controller('userCtrl', function($scope, $interval, titleService, acctService, paymentService) {
    $scope.username = acctService.username();
    $scope.payment_ID = -1;
    $scope.payment_amount = -1;
    $scope.paid_total = 0;
    $scope.payment_started = false;
    
    $scope.payments = {};
    
    titleService.setTitle($scope.username + ' - BillSplit');
    $scope.startPayment = function(payment) {
        paymentService.startPayment(payment, $scope);
    };
    $scope.getPaidTotal = function(payment_ID) {
        console.log("payment id button: " + payment_ID);
        paymentService.getPaidTotal(payment_ID, $scope);
        //paymentService.getPaidTotal(15, $scope); //set to 15 right now b/c thats what i made the payment with
    }
    
    $scope.getPayments = function() {
        paymentService.getPayments($scope);
    }
    //var checkPaid = $interval(paymentService.getPaidTotal($scope.payment_ID, $scope), 1000);
});