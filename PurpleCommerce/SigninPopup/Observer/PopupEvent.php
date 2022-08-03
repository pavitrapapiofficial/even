<?php
    namespace PurpleCommerce\SigninPopup\Observer;

    use Magento\Framework\Event\ObserverInterface;
    use Magento\Framework\App\RequestInterface;

    class PopupEvent implements ObserverInterface
    {
        public function execute(\Magento\Framework\Event\Observer $observer) {
            $item = $observer->getEvent()->getData('quote_item');           
            $item = ( $item->getParentItem() ? $item->getParentItem() : $item );
            $qty= $item->getQty() * 2; //set your quantity here
            $item->setQty($qty);
            $item->getProduct()->setIsSuperMode(true);
        }

    }