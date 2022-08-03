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
                type: 'subscription',
                component: 'PurpleCommerce_Subscription/js/view/payment/method-renderer/subscription'
            }
        );
        return Component.extend({});
    }
);