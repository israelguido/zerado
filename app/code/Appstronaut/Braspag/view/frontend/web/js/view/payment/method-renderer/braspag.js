define([
        'jquery',
        'Magento_Payment/js/view/payment/cc-form'
    ],
    function ($, Component) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Appstronaut_Braspag/payment/braspag'
            },

            context: function() {
                return this;
            },

            getCode: function() {
                return 'appstronaut_braspag';
            },

            isActive: function() {
                return true;
            }
        });
    }
);
