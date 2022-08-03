<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace PurpleCommerce\FailurePayment\Controller\Onepage;

class Failure extends \Magento\Checkout\Controller\Onepage
{
    /**
     * @return \Magento\Framework\View\Result\Page|\Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $_checkoutSession = $objectManager->create('\Magento\Checkout\Model\Session');
        $_quoteFactory = $objectManager->create('\Magento\Quote\Model\QuoteFactory');
        
        $orderId = substr($_GET['co'],0,-1);
        $orders = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($orderId);
        $quote = $_quoteFactory->create()->loadByIdWithoutStore($orders->getQuoteId());
        
        if ($quote->getId()) {
            $quote->setIsActive(1)->setReservedOrderId(null)->save();
            $_checkoutSession->replaceQuote($quote);
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('checkout/cart');
            //$this->messageManager->addWarningMessage('Payment Failed.');
            return $resultRedirect;
        }
    }
}
