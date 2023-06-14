define(['jquery', 'Magento_Checkout/js/action/get-totals'], function($, getTotalsAction){
    return function(config, element){
        $.ajaxSetup({
            beforeSend: function(jqXHR, settings) {
                if(settings.url.indexOf('carts/mine/totals') !== -1 && settings.type === 'GET'){
                    let params = getQuoteItemsIds();
                    let separator = getSeparator(settings.url);

                    settings.url = settings.url + separator + params;
                }
            }
        });

        $(element).on('change', function(){
            let deferred = $.Deferred();
            getTotalsAction([], deferred);
        });

        function getQuoteItemsIds()
        {
            let selectedItemsIds = new URLSearchParams();
            $('input:checkbox.ms-selected-items:not(:checked)').each(function(index, element){
                selectedItemsIds.append(element.name, element.value)
            });

            return selectedItemsIds.toString();
        }

        function getSeparator(url)
        {
            let separator = '?';
            if(url.indexOf('?') !== -1){
                separator = '&';
            }

            return separator;
        }
    };
});
