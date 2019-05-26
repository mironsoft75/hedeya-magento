<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\Branches\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

use \Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    const TABLE_NAME_BRANCH = "hedeya_branches_branch";

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        /**
         * Create table 'hedeya_branches_branch'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable(self::TABLE_NAME_BRANCH)
        )->addColumn(
            'branch_id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Branch Id'
        )->addColumn(
            'lat',
            Table::TYPE_DECIMAL,
            '10,8',
            ['nullable' => true, 'default' => '0'],
            'Branch Latitude'
        )->addColumn(
            'lng',
            Table::TYPE_DECIMAL,
            '11,8',
            ['nullable' => true, 'default' => '0'],
            'Branch Longitude'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            255,
            [],
            'Branch Name'
        )->addColumn(
            'description',
            Table::TYPE_TEXT,
            '64k',
            ['nullable' => true],
            'Branch Description'
        )->setComment(
            'Hedeya Branches Branch'
        );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
