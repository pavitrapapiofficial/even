<?php 
namespace PurpleCommerce\CategoryFilter\Plugin\Catalog\Model;
 
class Config {

    /**
     * Retrieve Attributes Used for Sort by as array
     * key = code, value = name
     *
     * @return array
     */
	public function afterGetAttributeUsedForSortByArray(
		\Magento\Catalog\Model\Config $subject,
		$options
	){
		$options['product_id'] = __('New');
		return $options;	
	}

	
}
