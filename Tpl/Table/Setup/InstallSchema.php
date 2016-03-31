<?php

namespace {:namespace}\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();
        /**
         * Create table '{:table_name}'
         */
        $table = $installer->getConnection()
        ->newTable($installer->getTable('{:table_name}'))
        {:LOOP_COLS->addColumn(
                '{:column_name}',
                \Magento\Framework\DB\Ddl\Table::{:column_dbtype},
                {:column_length},
                [{:column_constraints}],
                '{:column_name}'
        )LOOP_COLS}
         ->setComment('{:table_name}');
         $installer->getConnection()->createTable($table);

        $setup->endSetup();
    }
}