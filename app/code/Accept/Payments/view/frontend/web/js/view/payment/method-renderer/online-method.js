define(
    [
        'Magento_Checkout/js/view/payment/default',
        'jquery',
        'Magento_Checkout/js/model/payment/additional-validators',
        'mage/url',
        'Magento_Checkout/js/action/place-order',
        'Magento_Checkout/js/model/full-screen-loader'
    ],
    function (
        Component,
        $,
        additionalValidators,
        url,
        placeOrderAction,
        fullScreenLoader
    ) {
        return Component.extend({
            defaults: {
                template: 'Accept_Payments/payment/online',
                success: false,
                iframe_url: null,
                owner: null,
                cards: null,
                detail: null
            },
            afterPlaceOrder: function (data, event) {
                var self = this;
                fullScreenLoader.startLoader();
                $.ajax({
                    type: 'POST',
                    url: url.build('accept/methods/onlinemethod'),
                    data: data,
                    success: function (response) {
                        fullScreenLoader.stopLoader();
                        if (response.success) {
                            console.log("afterPlaceOrder:success");
                            console.log(response)
                            self.renderPayment(response);
                        } else {
                            console.log("afterPlaceOrder:error");
                            console.log(response)
                            self.renderErrors(response);
                        }
                    },
                    error: function (response) {
                        console.log("afterPlaceOrder:error");
                        console.log(response)
                        fullScreenLoader.stopLoader();
                        self.renderErrors(response);
                    }
                });
            },
            placeOrder: function (data, event) {
                if (event) {
                    event.preventDefault();
                }

                if (additionalValidators.validate()) {
                    placeOrder = placeOrderAction(
                        this.getData(),
                        false,
                        this.messageContainer
                    );

                    $.when(placeOrder).done(this.afterPlaceOrder.bind(this));
                    return true;
                }

                return false;
            },
            renderPayment: function (data) {
                fullScreenLoader.stopLoader();
                $('body').css({
                    'overflow': 'hidden'
                });

                var html = '';
                var iframe_html = "<iframe height='700' src='"+data.iframe_url+"' id='online-iframe' onload=\"window['stopAcceptSpinner']()\"></iframe>";
                if(data.cards)
                {
                    html += '<h2>Welcome back '+data.owner+', Please select an option from below.</h2>';
                    html += '<ul>';
                    html += '<li class="online-card-option active" data-url="'+data.iframe_url+'"><b>Use a new card</b> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"> <path d="M0 0h24v24H0z" fill="none"/> <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/> </svg></li>';
                    $.each(data.cards,function(index, card){
                        html   += '<li class="online-card-option" data-url="'+card.url+'"><b>'+card.card_subtype+'</b>: '+card.masked_pan+'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"> <path d="M0 0h24v24H0z" fill="none"/> <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/> </svg></li>';
                    });
                    html += '</ul>';
                    html += "<script>\
                            jQuery(document).ready(function(){\
                                jQuery(document).on('click','.online-card-option',function(){\
                                    window['startAcceptSpinner']();\
                                    jQuery('.online-card-option').removeClass('active');\
                                    jQuery(this).addClass('active');\
                                    var iframe_url = jQuery(this).attr('data-url');\
                                    jQuery('#online-iframe').attr('src', iframe_url);\
                                });\
                            })\
                            </script>";
                    iframe_html = html + iframe_html;
                }

                scripts = "<script>function stopAcceptSpinner(){jQuery('#online-container .spinner').addClass('stop').removeClass('default');}function startAcceptSpinner(){jQuery('#online-container .spinner').addClass('default').removeClass('stop');}</script>";
                iframe_html = scripts + iframe_html;

                $('#online-container').show(250, function(){
                    $('#online-iframes-container').show().html(iframe_html);
                });
            },
            renderErrors: function (data) {
                fullScreenLoader.stopLoader();
                $('body').css({
                    'overflow': 'hidden'
                });

                $('#online-container').show(250, function(){
                    $('#online-errors').show(250, function(){
                        $('#online-errors .errors').show().html(data.detail);
                    });
                });
            },
            getData: function () {
                return {"method": this.item.method};
            },
        });
    }
);
