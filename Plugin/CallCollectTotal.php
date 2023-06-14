<?php

declare(strict_types=1);

namespace MageSystems\BuyPart\Plugin;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\Cart\CartTotalRepository;
use Magento\Quote\Model\Quote;

class CallCollectTotal
{
    protected CartRepositoryInterface $quoteRepository;

    public function __construct(CartRepositoryInterface $quoteRepository)
    {
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * Run collectTotal to re-calculate price when a customer enable/disable checkbox on product page
     *
     * @param CartTotalRepository $cartTotalRepository
     * @param $cartId
     * @return array
     * @throws NoSuchEntityException
     */
    public function beforeGet(CartTotalRepository $cartTotalRepository, $cartId)
    {
        /** @var Quote $quote */
        $quote = $this->quoteRepository->getActive($cartId);
        if (!$quote->isVirtual()){
            $quote->collectTotals();
        }

        return [$cartId];
    }
}
