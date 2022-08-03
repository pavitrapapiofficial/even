<?php

namespace PurpleCommerce\Subscription\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

	public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
	{
		$installer = $setup;
		$installer->startSetup();
		if (!$installer->tableExists('purplecommerce_subscriptions')) {
			$table = $installer->getConnection()->newTable(
				$installer->getTable('purplecommerce_subscriptions')
			)
				->addColumn(
					'Entity_Id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'identity' => true,
						'nullable' => false,
						'primary'  => true,
						'unsigned' => true,
					],
					'Entity Id'
				)
				->addColumn(
					'Parent_Order_Number',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					['nullable => false'],
					'Parent Order Number'
				)
				->addColumn(
					'SKU',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[],
					'SKU'
				)
				->addColumn(
					'Count',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					'64k',
					[],
					'Count'
				)
				->addColumn(
					'Status',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[],
					'Status'
				)
				->addColumn(
					'Order_Number',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					1,
					[],
					'Order Number'
				)
				->addColumn(
					'Token_Subscription',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[],
					'Token Subscription'
				)
				->addColumn(
					'Subcription_Order_Date',
					\Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
					null,
					['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
					'Subcription Order Date'
				)
				->setComment('Subscriptions Table');
			$installer->getConnection()->createTable($table);

			$installer->getConnection()->addIndex(
				$installer->getTable('purplecommerce_subscriptions'),
				$setup->getIdxName(
					$installer->getTable('purplecommerce_subscriptions'),
					['Parent_Order_Number', 'SKU', 'Count', 'Status', 'Token_Subscription','Subcription_Order_Date'],
					\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
				),
				['Parent_Order_Number', 'SKU', 'Count', 'Status', 'Token_Subscription','Subcription_Order_Date'],
				\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
			);
		}
		$installer->endSetup();
	}
}