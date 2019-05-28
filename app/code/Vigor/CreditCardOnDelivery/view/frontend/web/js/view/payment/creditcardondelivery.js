define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'creditcardondelivery',
                component: 'Vigor_CreditCardOnDelivery/js/view/payment/method-renderer/creditcardondelivery-method'
            }
        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);