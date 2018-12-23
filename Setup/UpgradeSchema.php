<?php
namespace Magenman\CallToOrder\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class UpgradeSchema
 * @package Magenman\CallToOrder\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        if (version_compare($context->getVersion(), '2.0.1')    <   0) {
            $installer  =   $setup;
            $installer->startSetup();
            //Install	new	database	table
            $table  =   $installer->getConnection()->newTable(
                $installer->getTable('magenman_call_to_order_manager')
            )->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                'identity'  =>  true,
                'unsigned'  =>  true,
                'nullable'  =>  false,
                'primary'   =>  true
                ],
                'Call Order Id'
            )->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                64,
                ['nullable'     =>  false],
                'Name'
            )->addColumn(
                'phone',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                64,
                ['nullable'     =>  true],
                'Phone'
            )->addColumn(
                'email',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable'     =>  false],
                'Email	address'
            )->addColumn(
                'product_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                255,
                ['nullable'     =>  false],
                'Product Id'
            )->addColumn(
                'product_name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable'     =>  false],
                'Product Name'
            )->addColumn(
                'note',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [],
                'Note'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                6,
                [
                'nullable'  =>  true,
                'default'   =>  '1',
                ],
                'Status'
            )->addColumn(
                'register',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [
                'nullable'  =>  true,
                'default'   =>  \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
                ],
                'Call Back Registration Time'
            )->addColumn(
                'time_to_call',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [],
                'Preferred Time To Call'
            )->addColumn(
                'action',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                [
                'nullable'  =>  false,
                'default'   =>  'selected',
                ],
                'Action'
            )->addColumn(
                'store',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                64,
                [
                    'nullable'  =>  true,
                    'default'   =>  '1'],
                'Stores'
            )->addColumn(
                'template',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                64,
                ['nullable'     =>  true,],
                'Template'
            );
            $installer->getConnection()->createTable($table);
            $installer->endSetup();
        }
    }
}
