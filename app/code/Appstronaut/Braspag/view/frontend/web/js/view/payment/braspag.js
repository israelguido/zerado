define([
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (Component, rendererList) {
        'use strict';

        rendererList.push(
            {
                type: 'appstronaut_braspag',
                component: 'Appstronaut_Braspag/js/view/payment/method-renderer/braspag'
            },
            {
                type: 'boleto',
                component: 'Appstronaut_Braspag/js/view/payment/method-renderer/boleto-method'
            }
        );

        /** Add view logic here if needed */
        return Component.extend({});
    });
