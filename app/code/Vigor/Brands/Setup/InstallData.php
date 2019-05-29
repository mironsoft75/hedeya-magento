<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\Brands\Setup;

use \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use \Magento\Catalog\Model\Category;


class InstallData implements \Magento\Framework\Setup\InstallDataInterface
{
    protected $eavSetupFactory;

    public function __construct(\Magento\Eav\Setup\EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install( \Magento\Framework\Setup\ModuleDataSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context ) {
        $setup->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $defaultAttribute = [
            'required'  => false,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'brand-category',
        ];
        $attributes = [
            'show_in_page' => [
                'type' => 'int',
                'label' => 'Show in All Brands Page',
                'input' => 'boolean',
                'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            ],
            'show_in_home' => [
                'type' => 'int',
                'label' => 'Show in Homepage',
                'input' => 'boolean',
                'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            ],
            'logo' => [
                'type' => 'varchar',
                'label' => 'Brand Logo',
                'input' => 'image',
                'backend' => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
            ]
        ];
        foreach ($attributes as $code => $attribute) {
            $eavSetup->removeAttribute(Category::ENTITY, "brand_{$code}");
            $eavSetup->addAttribute(
                Category::ENTITY,
                "brand_{$code}",
                array_merge($defaultAttribute, $attribute)
            );
        }

        $setup->endSetup();
    }
}