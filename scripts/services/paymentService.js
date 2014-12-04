'use strict';

app.factory('paymentService', function($http, $location, acctService) {
    var payment_ID = -1;
    var payment_amount = 5;
    var paid_total = 0;
    
    return {
        getPaymentID: function() {
            return payment_ID;
        },
        getPaymentAmount: function() {
            return payment_amount;
        },
        startPayment: function(payment, scope) {
            payment.amount *= 1.01; // apply fee
        
            var $promise = $http.post('ops/payment/new.php', payment);
            $promise.then(function(response) {
                var data = response.data;   // get returned JSON content
                if(data.success) {
                    console.log("New payment created");
                    payment_ID = data.payment_ID;
                    payment_amount = payment.amount;
                    
                    scope.payment_ID = payment_ID;
                    scope.payment_amount = payment_amount;
                    scope.payment_started = true;
                }
                else {
                    console.log("Error adding new payment");
                    console.log(data);
                }
            });
        },
        getPaidTotal: function(payment_ID, scope) {
            paid_total = 0; //reset paid total
            
            var paymentListUrl = 'https://api.ripple.com/v1/accounts/raMTQhyX2X9JkoGxZ8LBagrBLnTUSMvfgQ/payments?destination_account=raMTQhyX2X9JkoGxZ8LBagrBLnTUSMvfgQ';
            var rippleCall = $http.get(paymentListUrl);
            
            rippleCall.then(function(response) {
                var data = response.data;
                paid_total = 0;
                data.payments.forEach(function(payment) {
                    if (parseInt(payment.payment.destination_tag) == payment_ID) {
                        paid_total += parseFloat(payment.payment.destination_balance_changes[0].value);
                    }
                });
                scope.paid_total = paid_total;
            });
        },
        getPayments: function(scope) {
            var payments = $http.get('ops/merchantlistPayments.php');
            payments.then(function(response) {
                var data = response.data;
                scope.payments = data.payments;
            });
        }
    }
});