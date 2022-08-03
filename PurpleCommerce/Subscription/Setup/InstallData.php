<?php

namespace PurpleCommerce\Subscription\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
	protected $_postFactory;

	public function __construct(\PurpleCommerce\Subscription\Model\PostFactory $postFactory)
	{
		$this->_postFactory = $postFactory;
	}

	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$data = [
            
			'Parent_Order_Number'         => "000000017",
			'SKU' => "malt1234",
			'Count'      => "1/6",
			'Status'         => "Pending",
            'Order_Number'       => "000000001",
            'Token_Subscription' => "",
            'Subcription_Order_Date'=> "12/08/2020"
		];
		$post = $this->_postFactory->create();
		$post->addData($data)->save();
	}
}