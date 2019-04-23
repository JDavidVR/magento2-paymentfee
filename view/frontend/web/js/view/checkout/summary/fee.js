define(
    [
        'Magento_Checkout/js/view/summary/abstract-total',
        'Magento_Checkout/js/model/quote',
        'Magento_Catalog/js/price-utils',
        'Magento_Checkout/js/model/totals'
    ],
    function (Component, quote, priceUtils, totals) {
        "use strict";
        return Component.extend({
            defaults: {
                isFullTaxSummaryDisplayed: window.checkoutConfig.isFullTaxSummaryDisplayed || false,
                template: 'Prince_Paymentfee/checkout/summary/fee'
            },
            totals: quote.getTotals(),
            isTaxDisplayedInGrandTotal: window.checkoutConfig.includeTaxInGrandTotal || false,

            isDisplayed: function() {
                return this.isFullMode();
            },

            getValue: function() {
                var price = 0;
                if (this.totals()) {
                    price = totals.getSegment('payment_fee').value;
                }
                return this.getFormattedPrice(price);
            },

            getBaseValue: function() {
                var price = 0;
                if (this.totals()) {
                    price = this.totals().base_payment_fee;
                }
                return priceUtils.formatPrice(price, quote.getBasePriceFormat());
            },

            hideZeroPaymentFee: function () {
                var showPaymentFee = window.checkoutConfig.show_zero_fee;
                var price = 0;
                if (this.totals()) {
                    price = totals.getSegment('payment_fee').value;
                    if(!showPaymentFee && price == 0 ) {
                        return false;
                    }
                }
                return true;
            }
        });
    }
);