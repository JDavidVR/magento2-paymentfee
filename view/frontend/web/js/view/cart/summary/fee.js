/*global define*/
define(
    [
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/totals'
    ],
    function (Component, quote, totals) {
        "use strict";
        return Component.extend({
            defaults: {
                template: 'Prince_Paymentfee/cart/summary/fee'
            },
            totals: quote.getTotals(),
            isDisplayed: function() {
                return this.getPureValue() != 0;
            },
            getPaymentFee: function() {
                if (!this.totals()) {
                    return null;
                }
                return totals.getSegment('payment_fee').value;
            },
            getPureValue: function() {
                var price = 0;
                if (this.totals() && totals.getSegment('payment_fee')) {
                    price = parseFloat(totals.getSegment('payment_fee').value);
                }
                return price;
            },
            getValue: function() {
                return this.getFormattedPrice(this.getPureValue());
            }
        });
    }
);