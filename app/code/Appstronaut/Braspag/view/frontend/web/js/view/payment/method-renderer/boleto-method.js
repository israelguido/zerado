define([
    'Magento_Checkout/js/view/payment/default',
    'Magento_Checkout/js/model/quote'
], function (Component, quote) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Appstronaut_Braspag/payment/boleto'
        },

        /** Returns is method available */
        isAvailable: function () {
            return quote.totals()['grand_total'] <= 0;
        }
    });
});
