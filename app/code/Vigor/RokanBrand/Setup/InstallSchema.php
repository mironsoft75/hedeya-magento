<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\RokanBrand\Setup;

use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface {
    /**
     *
     *
     * @param \Magento\Framework\Setup\SchemaSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface $context
     *
     * @return void
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install( \Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context ) {
        $installer = $setup;
        $installer->startSetup();

        $installer->getConnection()
                  ->addColumn($installer->getTable('rokanthemes_brand'), 'category_id', [
                      'type'     => Table::TYPE_INTEGER,
                      'nullable' => true,
                      'unsigned' => true,
                      'default'  => 0,
                      'comment'  => 'Category ID',
                  ]);

        $installer->endSetup();
    }
}
