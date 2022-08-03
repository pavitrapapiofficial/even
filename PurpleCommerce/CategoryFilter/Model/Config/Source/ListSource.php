<?php
namespace PurpleCommerce\CategoryFilter\Model\Config\Source;

class ListSource extends \Magento\Catalog\Model\Config\Source\ListSort
{
    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->_getCatalogConfig()->getAttributeUsedForSortByArray() as $code => $label) {
            $options[] = ['label' => __($label), 'value' => $code];
        }
        return $options;
    }
}