define(
    [
        'Prince_Paymentfee/js/view/checkout/summary/fee'
    ],
    function (Component) {
        'use strict';

        return Component.extend({

            isDisplayed: function () {
                var isEnable = window.checkoutConfig.show_hide_paymentfee;
                if(isEnable) {
                    return true;
                }
                return false;
            },

            getDescription: function () {
                var description = window.checkoutConfig.fee_description;
                if(description) {
                    return description;
                }
                return false;
            }
        });
    }
);