<?php

declare(strict_types=1);

namespace MageSystems\BuyPart\Plugin;

use Magento\Framework\App\RequestInterface;
use Magento\Quote\Model\ResourceModel\Quote\Item\Collection as QuoteItemsCollection;

class ChangeQuoteItemCollection
{
    protected RequestInterface $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function afterSetQuote(QuoteItemsCollection $subject,  QuoteItemsCollection $quoteItemsCollection)
    {
        $selectedItems = $this->request->getParam('selected_items');
        if($selectedItems) {
            $quoteItemsCollection->addFieldToFilter('item_id', ['nin' => join(',', $selectedItems)]);
        }

        return $quoteItemsCollection;
    }
}
