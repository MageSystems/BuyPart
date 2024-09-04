define(['jquery', 'Magento_Checkout/js/model/quote'], function($, quote){
    return function(config, element){
        $.ajaxSetup({
            beforeSend: function(jqXHR, settings) {
                if(allowUrls(settings) && settings.type === 'POST'){
                    let params = getQuoteItemsIds();
                    let separator = getSeparator(settings.url);

                    settings.url = settings.url + separator + params;
                }
            }
        });

        $(element).on('change', function(){
            quote.shippingAddress(quote.shippingAddress());
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

        function allowUrls(settings)
        {
            return  settings.url.indexOf('carts/mine/totals-information') !== -1 ||
                    settings.url.indexOf('guest-carts') !== -1;
        }
    };
});
