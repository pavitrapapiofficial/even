<?php

namespace PurpleCommerce\GetVarientDetails\Block\Adminhtml\Category\Tab;

use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Framework\App\ObjectManager;
use Magento\Eav\Model\Config;

class Product extends \Magento\Catalog\Block\Adminhtml\Category\Tab\Product
{
    protected $visibility;

    public function __construct(\Magento\Backend\Block\Template\Context $context,
                                \Magento\Backend\Helper\Data $backendHelper,
                                \Magento\Catalog\Model\ProductFactory $productFactory,
                                \Magento\Framework\Registry $coreRegistry,
                                array $data = [],
                                Visibility $visibility = null,
                                Status $status = null,
                                Config $eavConfig)
    {
        $this->eavConfig = $eavConfig;
        $this->visibility = $visibility ?: ObjectManager::getInstance()->get(Visibility::class);
        parent::__construct($context, $backendHelper, $productFactory, $coreRegistry, $data, $visibility, $status);
    }

    /**
     * Set collection object
     *
     * @param \Magento\Framework\Data\Collection $collection
     * @return void
     */
    public function setCollection($collection)
    {
        $collection->addAttributeToSelect('active_varient');
        parent::setCollection($collection);
    }

    /**
     * @return $this
     */
    protected function _prepareColumns()
    {
        $attribute = $this->eavConfig->getAttribute('catalog_product', 'active_varient');
        if ($attribute) {
            $vals = $attribute->getSource()->getAllOptions();
            $arr = [];
            foreach ($vals as $option) {
                if ($option['label']) {
                    $arr[$option['value']] = $option['label'];
                }
            }
            parent::_prepareColumns();
            $this->addColumnAfter('active_varient', array(
                'header' => __('Active Varient'),
                'index' => 'active_varient',
                'type' => 'int'
            ), 'sku');

            $this->sortColumnsByOrder();
            return $this;
        }
    }
}