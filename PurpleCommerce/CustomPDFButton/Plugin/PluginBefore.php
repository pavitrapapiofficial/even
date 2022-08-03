<?php

namespace PurpleCommerce\CustomPDFButton\Plugin;
 
class PluginBefore
{
    public function beforePushButtons(
    	\Magento\Backend\Block\Widget\Button\Toolbar\Interceptor $subject,
        \Magento\Framework\View\Element\AbstractBlock $context,
        \Magento\Backend\Block\Widget\Button\ButtonList $buttonList
    ) {

		$this->_request = $context->getRequest();
		// echo "thisthis->".$this->_request->getFullActionName();
    	if($this->_request->getFullActionName() == 'sales_order_invoice_view'){
			//$url = $subject->getUrl('purplecommerce_custompdfbutton/index/import');
	          $buttonList->add(
	            'pcButton',
	            ['label' => __('GST Invoice'), 'onclick' => 'setLocation(\'{$url}\')', 'class' => 'pdf','sort_order'=>80],
	            -1
	        );
      	}

	} 
	

}