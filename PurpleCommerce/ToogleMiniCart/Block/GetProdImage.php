<?php


namespace PurpleCommerce\ToogleMiniCart\Block;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Catalog\Block\Product\AbstractProduct;

class GetProdImage extends \Magento\Framework\View\Element\Template
{
    protected $_productRepositoryFactory;

    public function __construct(
    \Magento\Catalog\Api\ProductRepositoryInterfaceFactory $productRepositoryFactory
    ) {            
        $this->_productRepositoryFactory = $productRepositoryFactory;
    }

    public function checkit(){
        echo "working fine bro";
    }

    public function getprodimg($id){
        $product = $this->_productRepositoryFactory->create()
                    ->getById($id);
        $product->getData('image');
        $product->getData('thumbnail');
        /* Using Direct Object Manager */ 
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storeManager = $objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        $mediaUrl =$storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl.'catalog/product'.$product->getData('small_image');
    }

}