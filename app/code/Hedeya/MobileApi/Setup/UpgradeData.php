<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Setup;

use \Magento\Framework\Setup\ModuleDataSetupInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use \Magento\Catalog\Model\Category;

class UpgradeData implements \Magento\Framework\Setup\UpgradeDataInterface
{
    private $eavSetupFactory;
    private $eavConfig;

    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Eav\Model\Config $eavConfig
    ){
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        if (version_compare($context->getVersion(), '0.0.2') < 0) {
            $defaultAttribute = [
                'required'  => false,
                'global' => ScopedAttributeInterface::SCOPE_STORE,
                'group' => 'mapi-category',
            ];
            $attributes = [
                'is_home' => [
                    'type' => 'int',
                    'label' => 'List In Home',
                    'input' => 'boolean',
                    'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                ],
                'category_order' => [
                    'type' => 'int',
                    'label' => 'Category Image Order',
                    'default'  => '0',
                ],
                'category_image' => [
                    'type' => 'varchar',
                    'label' => 'Category Image',
                    'input' => 'image',
                    'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                ],
                'category_image_type' => [
                    'type' => 'varchar',
                    'label' => 'Category Image Type',
                    'input' => 'select',
                    'source' => 'Hedeya\MobileApi\Model\Category\Attribute\Source\ImageType',
                ],
                'category_icon' => [
                    'type' => 'varchar',
                    'label' => 'Category Icon',
                    'input' => 'image',
                    'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
                ],
            ];
            foreach ($attributes as $code => $attribute) {
                $eavSetup->removeAttribute(Category::ENTITY, "mapi_{$code}");
                $eavSetup->addAttribute(
                    Category::ENTITY,
                    "mapi_{$code}",
                    array_merge($defaultAttribute, $attribute)
                );
            }
        }

        if (version_compare($context->getVersion(), '0.0.3') < 0) {

        }

        if (version_compare($context->getVersion(), '0.1.0') < 0) {

        } // if version_compare


        $setup->endSetup();
    }


}
