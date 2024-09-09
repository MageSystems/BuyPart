<?php
/**
 * @package BuyLater
 * @author   artsem.miklashevich@gmail.com
 */
declare(strict_types=1);

namespace MageSystems\BuyPart\Test\Integration\Plugin;

use PHPUnit\Framework\TestCase;
use Magento\TestFramework\Fixture\DataFixture;


class ChangeQuoteItemCollectionTest extends TestCase
{

    #[DataFixture('../../../../app/code/MageSystems/BuyPart/Test/Integration/Fixtures/quote.php')]
    public function testChangeQuoteItemCollection()
    {
        $objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
        $quote = $objectManager->create(\Magento\Quote\Model\Quote::class);
        $quote->load('guest_quote_magentosystem', 'reserved_order_id');
        $quoteItems = $quote->getItemsCollection();
        $this->assertEquals(2, $quoteItems->count());
    }
}
