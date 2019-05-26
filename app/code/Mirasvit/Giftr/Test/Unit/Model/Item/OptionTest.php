<?php
/**
 * Mirasvit
 *
 * This source file is subject to the Mirasvit Software License, which is available at https://mirasvit.com/license/.
 * Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
 * If you wish to customize this module for your needs.
 * Please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Mirasvit
 * @package   mirasvit/module-gift-registry
 * @version   1.2.10
 * @copyright Copyright (C) 2018 Mirasvit (https://mirasvit.com/)
 */



namespace Mirasvit\Giftr\Test\Unit\Model\Item;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManager;

/**
 * @covers \Mirasvit\Giftr\Model\Item\Option
 * @SuppressWarnings(PHPMD)
 */
class OptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Mirasvit\Giftr\Model\Item\Option|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $optionModel;

    /**
     * @var \Magento\Catalog\Model\ProductFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $productFactoryMock;

    /**
     * @var \Magento\Catalog\Model\Product|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $productMock;

    /**
     * @var \Magento\CatalogInventory\Model\Stock\ItemFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $stockItemFactoryMock;

    /**
     * @var \Magento\CatalogInventory\Model\Stock\Item|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $stockItemMock;

    /**
     * @var \Magento\Framework\Model\Context|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $contextMock;

    /**
     * @var \Magento\Framework\Registry|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registryMock;

    /**
     * @var \Magento\Framework\Model\ResourceModel\AbstractResource|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $resourceMock;

    /**
     * @var \Magento\Framework\Data\Collection\AbstractDb|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $resourceCollectionMock;

    /**
     * setup tests.
     */
    public function setUp()
    {
        $this->productFactoryMock = $this->getMock(
'\Magento\Catalog\Model\ProductFactory', ['create'], [], '', false
);
        $this->productMock = $this->getMock(
'\Magento\Catalog\Model\Product', ['load',
'save',
'delete', ], [], '', false
);
        $this->productFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->productMock));
        $this->stockItemFactoryMock = $this->getMock(
'\Magento\CatalogInventory\Model\Stock\ItemFactory', ['create'], [], '', false
);
        $this->stockItemMock = $this->getMock(
'\Magento\CatalogInventory\Model\Stock\Item', ['load',
'save',
'delete', ], [], '', false
);
        $this->stockItemFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->stockItemMock));
        $this->registryMock = $this->getMock(
'\Magento\Framework\Registry', [], [], '', false
);
        $this->resourceMock = $this->getMock(
'\Mirasvit\Giftr\Model\ResourceModel\Item\Option', [], [], '', false
);
        $this->resourceCollectionMock = $this->getMock(
'\Mirasvit\Giftr\Model\ResourceModel\Item\Option\Collection', [], [], '', false
);
        $this->objectManager = new ObjectManager($this);
        $this->contextMock = $this->objectManager->getObject(
            '\Magento\Framework\Model\Context',
            [
            ]
        );
        $this->optionModel = $this->objectManager->getObject(
            '\Mirasvit\Giftr\Model\Item\Option',
            [
                'productFactory' => $this->productFactoryMock,
                'stockItemFactory' => $this->stockItemFactoryMock,
                'context' => $this->contextMock,
                'registry' => $this->registryMock,
                'resource' => $this->resourceMock,
                'resourceCollection' => $this->resourceCollectionMock,
            ]
        );
    }

    /**
     * dummy test.
     */
    public function testDummy()
    {
        $this->assertEquals($this->optionModel, $this->optionModel);
    }
}
