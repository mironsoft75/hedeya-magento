<?php
/**
 * Created By Ahmed El-Araby at 15/04/19 20:49.
 */

/**
 * Created by PhpStorm.
 * User: Ahmed El-Araby
 * Date: 15/04/2019
 * Time: 20:49
 */

namespace Vigor\ERPIntegrator\Setup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Config;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Sales\Model\Order;
use Vigor\ERPIntegrator\Api\Data\ERPProductInterface;

class InstallData implements InstallDataInterface{

    private $_eavSetupFactory;
    private $_eavConfig;
    private $_customerSetupFactory;
    private $_attributeSetFactory;
    private $_salesSetupFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        Config $eavConfig,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        \Magento\Sales\Setup\SalesSetupFactory $salesSetupFactory
    ){
        $this->_eavSetupFactory = $eavSetupFactory;
        $this->_eavConfig       = $eavConfig;
        $this->_customerSetupFactory = $customerSetupFactory;
        $this->_attributeSetFactory = $attributeSetFactory;
        $this->_salesSetupFactory = $salesSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context){

        $installer = $setup;

        $installer->startSetup();
        $salesSetup = $this->_salesSetupFactory->create(['resourceName' => 'sales_setup', 'setup' => $installer]);

        $salesSetup->addAttribute(Order::ENTITY, 'erp_id', [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'length'=> 255,
            'visible' => false,
            'nullable' => true
        ]);

        $salesSetup->addAttribute('shipment', 'erp_order_id', [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'length'=> 255,
            'visible' => false,
            'nullable' => true
        ]);

        $salesSetup->addAttribute('shipment', 'erp_payment_id', [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            'length'=> 255,
            'visible' => false,
            'nullable' => true
        ]);

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_grid'),
            'erp_id',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' =>'ERP ID'
            ]
        );

        /*Customer Module Setup*/
        $customerSetup = $this->_customerSetupFactory->create(['setup' => $setup]);
        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        /*Get Default Attribute Set*/
        $attributeSet = $this->_attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $setup->startSetup();

        /*Attribute Params*/
        $attributeParams=[
            'type'                  => 'varchar',
            'label'                 => 'ERP ID',
            'input'                 => 'text',
            'required'              => false,
            'unique'                => false,
            'visible'               => true,
            'user_defined'          => true,
            'position'              => 100,
            'system'                => false,
            'is_used_in_grid'       => true,
            'is_visible_in_grid'    => true,
            'is_filterable_in_grid' => true,
            'is_searchable_in_grid' => true
        ];

        $customerSetup->addAttribute(Customer::ENTITY, 'erp_id', $attributeParams);
        $attribute = $customerSetup->getEavConfig()
            ->getAttribute(Customer::ENTITY, 'erp_id')
            ->addData(
                [
                    'attribute_set_id' => $attributeSetId,
                    'attribute_group_id' => $attributeGroupId,
                    'used_in_forms'=> [
                        'adminhtml_customer',
                    ]
                ]
            );
        $attribute->save();

        $eavSetup = $this->_eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            ERPProductInterface::ERP_ID_ATTRIBUTE,
            [
                'type' => 'text',
                'backend' => '',
                'frontend' => '',
                'label' => 'ERP ID',
                'input' => 'text',
                'class' => '',
                'source' => '',
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => false,
                'default' => '',
                'searchable' => false,
                'filterable' => false,
                'comparable' => false,
                'visible_on_front' => false,
                'used_in_product_listing' => true,
                'unique' => false,
                'apply_to' => ''
            ]
        );

        $setup->endSetup();
        $installer->endSetup();
    }
}