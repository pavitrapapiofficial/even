<?php

namespace PurpleCommerce\PriceFilter\Plugin\Catalog\Model;

class Config
{
    public function afterGetAttributeUsedForSortByArray(
        \Magento\Catalog\Model\Config $catalogConfig,
        $options
    ) {
        
        $options['positionpc'] = __('Sort By');
        $options['latestpc'] = __('Whats New');
        $options['low_to_highpc'] = __('Price - Low To High');
        $options['high_to_lowpc'] = __('Price - High To Low');
        
        return $options;

    }

}