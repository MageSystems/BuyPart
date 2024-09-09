<?php
/**
 * @package BuyLater
 * @author   artsem.miklashevich@gmail.com
 */
declare(strict_types=1);

use Magento\Store\Model\StoreManagerInterface;
use Magento\TestFramework\Workaround\Override\Fixture\Resolver;



$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

$storeManager = $objectManager->get(StoreManagerInterface::class);

list($addressData)  = Resolver::getInstance()->requireDataFixture('Magento/Customer/Fixtures/address_data.php');

list($product, $product2) = Resolver::getInstance()->requireDataFixture('MageSystems/BuyPart/Test/Integration/Fixtures/product.php');
$quote = $objectManager->create(\Magento\Quote\Model\Quote::class);

$billingAddress = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
    \Magento\Quote\Model\Quote\Address::class,
    ['data' => $addressData]
);

$shippingAddress = clone $billingAddress;
$shippingAddress->setId(null)->setAddressType('shipping');

$store = $storeManager->getStore();

$quote->setCustomerIsGuest(true)
    ->setStoreId($store->getId())
    ->setReservedOrderId('guest_quote_magentosystem')
    ->setBillingAddress($billingAddress)
    ->setShippingAddress($shippingAddress)
    ->addProduct($product)
    ->addProduct($product2);
$quote->getPayment()->setMethod('checkmo');
$quote->setIsMultiShipping('1');
$quote->collectTotals();

$quoteRepository = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()
    ->get(\Magento\Quote\Api\CartRepositoryInterface::class);
$quoteRepository->save($quote);

$quoteIdMask = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()
    ->create(\Magento\Quote\Model\QuoteIdMaskFactory::class)
    ->create();
$quoteIdMask->setQuoteId($quote->getId());
$quoteIdMask->setDataChanges(true);
$quoteIdMask->save();
