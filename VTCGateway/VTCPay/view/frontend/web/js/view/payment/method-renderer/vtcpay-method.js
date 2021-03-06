define(
    [
        'ko',
        'jquery',
        'uiComponent',
        'Magento_Checkout/js/action/place-order',
        'Magento_Checkout/js/action/select-payment-method',
        'Magento_Checkout/js/model/quote',
        'Magento_Customer/js/model/customer',
        'Magento_Checkout/js/model/payment-service',
        'Magento_Checkout/js/checkout-data',
        'Magento_Checkout/js/model/checkout-data-resolver',
        'uiRegistry',
        'Magento_Checkout/js/model/payment/additional-validators',
        'Magento_Ui/js/model/messages',
        'uiLayout',
        'Magento_Checkout/js/action/redirect-on-success'
    ],
    function (
        ko,
        $,
        Component,
        placeOrderAction,
        selectPaymentMethodAction,
        quote,
        customer,
        paymentService,
        checkoutData,
        checkoutDataResolver,
        registry,
        additionalValidators,
        Messages,
        layout,
        redirectOnSuccessAction
    ) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'VTCGateway_VTCPay/payment/vtcpay'
            },
            redirectAfterPlaceOrder: false,
            isPlaceOrderActionAllowed: ko.observable(quote.billingAddress() != null),

            
            afterPlaceOrder: function () {
               

            },

          
            initialize: function () {
                var billingAddressCode,
                    billingAddressData,
                    defaultAddressData;

                this._super().initChildren();
                quote.billingAddress.subscribe(function (address) {
                    this.isPlaceOrderActionAllowed(address !== null);
                }, this);
                checkoutDataResolver.resolveBillingAddress();

                billingAddressCode = 'billingAddress' + this.getCode();
                registry.async('checkoutProvider')(function (checkoutProvider) {
                    defaultAddressData = checkoutProvider.get(billingAddressCode);

                    if (defaultAddressData === undefined) {                       
                        return;
                    }
                    billingAddressData = checkoutData.getBillingAddressFromData();

                    if (billingAddressData) {
                        checkoutProvider.set(
                            billingAddressCode,
                            $.extend(true, {}, defaultAddressData, billingAddressData)
                        );
                    }
                    checkoutProvider.on(billingAddressCode, function (providerBillingAddressData) {
                        checkoutData.setBillingAddressFromData(providerBillingAddressData);
                    }, billingAddressCode);
                });

                return this;
            },

            
            initChildren: function () {
                this.messageContainer = new Messages();
                this.createMessagesComponent();

                return this;
            },

            createMessagesComponent: function () {

                var messagesComponent = {
                    parent: this.name,
                    name: this.name + '.messages',
                    displayArea: 'messages',
                    component: 'Magento_Ui/js/view/messages',
                    config: {
                        messageContainer: this.messageContainer
                    }
                };

                layout([messagesComponent]);

                return this;
            },

            placeOrder: function (data, event) {


                var self = this;

                if (event) {
                    event.preventDefault();
                }

                if (this.validate() && additionalValidators.validate()) {
                    this.isPlaceOrderActionAllowed(false);


                    this.getPlaceOrderDeferredObject()
                        .fail(function () {
                                self.isPlaceOrderActionAllowed(true);
                            }).done(function (orderID) {
                                $.ajax({
                                    url:'/vtcgatewayvtcpay/Order/checkout?order_id='+orderID
                                }).done(function (url) {
                                    window.location.replace(url);
                                }).fail(function (err) {
                                    redirectOnSuccessAction.execute();
                                    console.log(err);
                                });

                            self.afterPlaceOrder();

                            if (self.redirectAfterPlaceOrder) {
                                redirectOnSuccessAction.execute();
                            }
                        }
                    );
                    return true;
                }

                return false;
            },

            getPlaceOrderDeferredObject: function () {
                return $.when(
                    placeOrderAction(this.getData(), this.messageContainer)
                );
            },

            selectPaymentMethod: function () {
                selectPaymentMethodAction(this.getData());
                checkoutData.setSelectedPaymentMethod(this.item.method);

                return true;
            },

            isChecked: ko.computed(function () {
                return quote.paymentMethod() ? quote.paymentMethod().method : null;
            }),

            isRadioButtonVisible: ko.computed(function () {
                return paymentService.getAvailablePaymentMethods().length !== 1;
            }),

            getData: function () {
                return {
                    'method': this.item.method,
                    'po_number': null,
                    'additional_data': null
                };
            },

            getTitle: function () {
                return this.item.title;
            },

            getCode: function () {
                return this.item.method;
            },

            validate: function () {
                return true;
            },

            getBillingAddressFormName: function () {
                return 'billing-address-form-' + this.item.method;
            },

            disposeSubscriptions: function () {
                var billingAddressCode = 'billingAddress' + this.getCode();

                registry.async('checkoutProvider')(function (checkoutProvider) {
                    checkoutProvider.off(billingAddressCode);
                });
            }
        });
    }
);
