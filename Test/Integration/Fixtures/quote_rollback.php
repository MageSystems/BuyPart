<?php
/**
 * @package BuyLater
 * @author   artsem.miklashevich@gmail.com
 */
declare(strict_types=1);


$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();
Resolver::getInstance()->requireDataFixture('MageSystems/BuyPart/Test/Integration/Fixtures/product_rollback.php');
