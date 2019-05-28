define(
    [
        'Magento_Checkout/js/view/payment/default'
    ],
    function (Component) {
        'use strict';
        console.log('asdasdassadsa2212312312d');

        return Component.extend({
            defaults: {
                template: 'Vigor_CreditCardOnDelivery/payment/creditcardondelivery'
            },

            /**
             * Returns payment method instructions.
             *
             * @return {*}
             */
            getInstructions: function () {
                return window.checkoutConfig.payment.instructions[this.item.method];
            }
        });
    }
);