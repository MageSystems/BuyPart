define(['jquery', 'Magento_Checkout/js/action/get-totals'], function($, getTotalsAction){
    return function(config, element){
        $(element).on('change', function(){
            let deferred = $.Deferred();
            getTotalsAction([], deferred);
        });
    };
});
