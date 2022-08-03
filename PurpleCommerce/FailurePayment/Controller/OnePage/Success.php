<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace PurpleCommerce\FailurePayment\Controller\Onepage;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;

/**
 * Onepage checkout success controller class
 */
class Success extends \Magento\Checkout\Controller\Onepage implements HttpGetActionInterface
{
    /**
     * Order success action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // echo "yes";die;
        
        // $_checkoutSession = $objectManager->create('\Magento\Checkout\Model\Session');
        // $_quoteFactory = $objectManager->create('\Magento\Quote\Model\QuoteFactory');
        
        if(isset($_GET['co'])){
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $orderId = substr($_GET['co'],0,-1);
            $orders = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($orderId);
            // $quote = $_quoteFactory->create()->loadByIdWithoutStore($orders->getQuoteId());
            $resultPage = $this->resultPageFactory->create();
            $this->_eventManager->dispatch(
                'checkout_onepage_controller_success_action',
                [
                    'order_ids' => [$orderId],
                    'order' => $orders
                ]
            );
        }else{
            $session = $this->getOnepage()->getCheckout();
            if (!$this->_objectManager->get(\Magento\Checkout\Model\Session\SuccessValidator::class)->isValid()) {
                return $this->resultRedirectFactory->create()->setPath('checkout/cart');
            }
            $session->clearQuote();
            //@todo: Refactor it to match CQRS
            $resultPage = $this->resultPageFactory->create();
            $this->_eventManager->dispatch(
                'checkout_onepage_controller_success_action',
                [
                    'order_ids' => [$session->getLastOrderId()],
                    'order' => $session->getLastRealOrder()
                ]
            );
            

        }
        
        // $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        // $logger = new \Zend\Log\Logger();
        // $logger->addWriter($writer);
        // $logger->info('LastSuccessQuoteId-'.$_checkoutSession->getLastSuccessQuoteId());
        // $logger->info('LastQuoteId-'.$_checkoutSession->getLastQuoteId());
        // $logger->info('LastOrderId-'.$_checkoutSession->getLastOrderId());
        
        
        return $resultPage;
    }
}
