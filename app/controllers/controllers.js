/* 
 * controllers.js
 * Defines controllers for app
 */

'use strict';

app.controller('mainCtrl', function($scope, titleService) {
    $scope.titleService = titleService;
});

app.controller('homeCtrl', function($scope, titleService, acctService) {
    titleService.setTitle('Home - BillSplit');
});

app.controller('newAcctCtrl', function($scope, titleService, acctService) {
    titleService.setTitle('New account - BillSplit');
    $scope.formData = {acctType: 'user'};
    
    $scope.create = function(formData) {
        acctService.create(formData, $scope);
    };
    /*
    $scope.createMerchant = function(acct) {
        acctService.createMerchant(acct, $scope);
    };*/
});

app.controller('loginCtrl', function($scope, titleService, acctService) {
    titleService.setTitle('Login - BillSplit');
    
    $scope.msgtxt = '';
    $scope.formData = {acctType: 'user'};
    $scope.login = function(formData) {
        acctService.login(formData, $scope);
    };
    /*$scope.loginUser = function(formData) {
        acctService.loginUser(formData, $scope);
    };
    $scope.loginMerch = function(formData) {
        acctService.loginMerch(formData, $scope);
    };*/
});

app.controller('userCtrl', function($scope, $interval, titleService, acctService, paymentService) {
    $scope.username = acctService.username();
    titleService.setTitle($scope.username + ' - BillSplit');
    $scope.payment_ID = -1;
    $scope.payment_amount = -1;
    $scope.paid_total = 0;
    $scope.payment_started = false;
    
    $scope.payments = {};
    
    $scope.startPayment = function(payment) {
        paymentService.startPayment(payment, $scope);
    };

    $scope.getPaidTotal = function(payment_ID) {
        paymentService.getPaidTotal(payment_ID, $scope);
    }
    
    /*$scope.getPayments = function() {
        paymentService.getPayments($scope);
    }*/
    
    // needs way to call getPaidTotal on interval, currently broken
    //var checkPaid = $interval(paymentService.getPaidTotal($scope.payment_ID, $scope), 1000);
});
