<?php

namespace PurpleCommerce\GetVarientDetails\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    /** @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory */
    Protected $_productCollection;
    Protected $productModel;
    protected $_date;
    protected $context;
    Protected $stockInterface;
    private $productRepository;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $_productCollection,
        \Magento\Catalog\Model\Product $productModel,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockInterface
    ) {
        parent::__construct($context);
        $this->_date =  $date;
        $this->_productCollection = $_productCollection;
        $this->productModel = $productModel;
        $this->productRepository = $productRepository;
        $this->stockInterface = $stockInterface;
    }

    public function execute(){
        // echo "inside";die;
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/cron.log');
		$logger = new \Zend\Log\Logger();
		$logger->addWriter($writer);
		$logger->info('cron executed at-'.$this->_date->date()->format('Y-m-d H:i:s'));
        $productCollection= $this->_productCollection->create();
        $productCollection->addAttributeToSelect('*');
        foreach ($productCollection as $product){
            // echo "parent->".$product->getId();
            $productTypeInstance = $product->getTypeInstance();
            if ($product->getTypeId() == \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE){
                $usedProducts = $productTypeInstance->getUsedProducts($product);
                $value=$this->getVarientAttributeValue($usedProducts);
                $this->updateProductAttribute($product->getId(),$value);
            }

        } 
        echo "cron completed at-".$this->_date->date()->format('Y-m-d H:i:s');
    }

    public function updateProductAttribute($productId,$value)
    {
        $attributeCode = "active_varient";
        $product = $this->productRepository->getById($productId);
        $product->setData($attributeCode, $value);
        $this->productRepository->save($product);
    }

    public function getVarientAttributeValue($pCollection){
        $count=0;
        foreach($pCollection as $pid){
            if($pid->getData('size')){
                $productStockObj=$this->stockInterface->getStockItem($pid->getId());
                if(round($productStockObj->getData('qty'))>0) {
                    $count++;
                }
            }
        }
        $count;
        // die;
        return $count;
    }
}