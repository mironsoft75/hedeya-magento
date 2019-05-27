define(
    [
        'Magento_Checkout/js/view/payment/default'
    ],
    function (Component) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Vigor_CreditCardOnDelivery/payment/creditcardondelivery'
            },

            /** Returns send check to info */
            getMailingAddress: function() {
                return window.checkoutConfig.payment.creditcardondelivery.mailingAddress;
            },


        });
    }
);