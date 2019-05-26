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



namespace Mirasvit\Giftr\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManager;

/**
 * @covers \Mirasvit\Giftr\Model\Item
 * @SuppressWarnings(PHPMD)
 */
class ItemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Mirasvit\Giftr\Model\Item|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $itemModel;

    /**
     * @var \Mirasvit\Giftr\Model\RegistryFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registryFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\Registry|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registryFIXMEMock;

    /**
     * @var \Magento\Catalog\Model\ProductFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $productFactoryMock;

    /**
     * @var \Magento\Catalog\Model\Product|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $productMock;

    /**
     * @var \Mirasvit\Giftr\Model\PriorityFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $priorityFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\Priority|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $priorityMock;

    /**
     * @var \Mirasvit\Giftr\Model\ConfigFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $configFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\Config|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $configMock;

    /**
     * @var \Mirasvit\Giftr\Model\Item\OptionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $itemOptionFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\Item\Option|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $itemOptionMock;

    /**
     * @var \Magento\CatalogInventory\Model\Stock\ItemFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $stockItemFactoryMock;

    /**
     * @var \Magento\CatalogInventory\Model\Stock\Item|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $stockItemMock;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Item\Option\CollectionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $itemOptionCollectionFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Item\Option\Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $itemOptionCollectionMock;

    /**
     * @var \Mirasvit\Core\Helper\Image|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $coreImageMock;

    /**
     * @var \Mirasvit\Giftr\Helper\Mail|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $giftrMailMock;

    /**
     * @var \Magento\Backend\Block\Widget\Context|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $widgetContextMock;

    /**
     * @var \Magento\Framework\UrlInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $urlManagerMock;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $storeManagerMock;

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
        $this->registryFactoryMock = $this->getMock(
            '\Mirasvit\Giftr\Model\RegistryFactory',
            ['create'],
            [],
            '',
            false
        );
        $this->registryMock = $this->getMock(
            '\Mirasvit\Giftr\Model\Registry',
            ['load',
            'save',
            'delete', ],
            [],
            '',
            false
        );
        $this->registryFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->registryMock));
        $this->productFactoryMock = $this->getMock(
            '\Magento\Catalog\Model\ProductFactory',
            ['create'],
            [],
            '',
            false
        );
        $this->productMock = $this->getMock(
            '\Magento\Catalog\Model\Product',
            ['load',
            'save',
            'delete', ],
            [],
            '',
            false
        );
        $this->productFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->productMock));
        $this->priorityFactoryMock = $this->getMock(
            '\Mirasvit\Giftr\Model\PriorityFactory',
            ['create'],
            [],
            '',
            false
        );
        $this->priorityMock = $this->getMock(
            '\Mirasvit\Giftr\Model\Priority',
            ['load',
            'save',
            'delete', ],
            [],
            '',
            false
        );
        $this->priorityFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->priorityMock));
        $this->configFactoryMock = $this->getMock(
            '\Mirasvit\Giftr\Model\ConfigFactory',
            ['create'],
            [],
            '',
            false
        );
        $this->configMock = $this->getMock(
            '\Mirasvit\Giftr\Model\Config',
            ['load',
            'save',
            'delete', ],
            [],
            '',
            false
        );
        $this->configFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->configMock));
        $this->itemOptionFactoryMock = $this->getMock(
            '\Mirasvit\Giftr\Model\Item\OptionFactory',
            ['create'],
            [],
            '',
            false
        );
        $this->itemOptionMock = $this->getMock(
            '\Mirasvit\Giftr\Model\Item\Option',
            ['load',
            'save',
            'delete', ],
            [],
            '',
            false
        );
        $this->itemOptionFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->itemOptionMock));
        $this->stockItemFactoryMock = $this->getMock(
            '\Magento\CatalogInventory\Model\Stock\ItemFactory',
            ['create'],
            [],
            '',
            false
        );
        $this->stockItemMock = $this->getMock(
            '\Magento\CatalogInventory\Model\Stock\Item',
            ['load',
            'save',
            'delete', ],
            [],
            '',
            false
        );
        $this->stockItemFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->stockItemMock));
        $this->itemOptionCollectionFactoryMock = $this->getMock(
            '\Mirasvit\Giftr\Model\ResourceModel\Item\Option\CollectionFactory',
            ['create'],
            [],
            '',
            false
        );
        $this->itemOptionCollectionMock = $this->getMock(
            '\Mirasvit\Giftr\Model\ResourceModel\Item\Option\Collection',
            ['load',
            'save',
            'delete',
            'addFieldToFilter',
            'setOrder',
            'getFirstItem',
            'getLastItem', ],
            [],
            '',
            false
        );
        $this->itemOptionCollectionFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->itemOptionCollectionMock));
        $this->coreImageMock = $this->getMock(
            '\Mirasvit\Core\Helper\Image',
            [],
            [],
            '',
            false
        );
        $this->giftrMailMock = $this->getMock(
            '\Mirasvit\Giftr\Helper\Mail',
            [],
            [],
            '',
            false
        );
        $this->widgetContextMock = $this->getMock(
            '\Magento\Backend\Block\Widget\Context',
            [],
            [],
            '',
            false
        );
        $this->urlManagerMock = $this->getMockForAbstractClass(
            '\Magento\Framework\UrlInterface',
            [],
            '',
            false,
            true,
            true,
            []
        );
        $this->storeManagerMock = $this->getMockForAbstractClass(
            '\Magento\Store\Model\StoreManagerInterface',
            [],
            '',
            false,
            true,
            true,
            []
        );
        $this->registryMock = $this->getMock(
            '\Magento\Framework\Registry',
            [],
            [],
            '',
            false
        );
        $this->resourceMock = $this->getMock(
            '\Mirasvit\Giftr\Model\ResourceModel\Item',
            [],
            [],
            '',
            false
        );
        $this->resourceCollectionMock = $this->getMock(
            '\Mirasvit\Giftr\Model\ResourceModel\Item\Collection',
            [],
            [],
            '',
            false
        );
        $this->objectManager = new ObjectManager($this);
        $this->contextMock = $this->objectManager->getObject(
            '\Magento\Framework\Model\Context',
            [
            ]
        );
        $this->itemModel = $this->objectManager->getObject(
            '\Mirasvit\Giftr\Model\Item',
            [
                'registryFactory' => $this->registryFactoryMock,
                'productFactory' => $this->productFactoryMock,
                'priorityFactory' => $this->priorityFactoryMock,
                'configFactory' => $this->configFactoryMock,
                'itemOptionFactory' => $this->itemOptionFactoryMock,
                'stockItemFactory' => $this->stockItemFactoryMock,
                'itemOptionCollectionFactory' => $this->itemOptionCollectionFactoryMock,
                'coreImage' => $this->coreImageMock,
                'giftrMail' => $this->giftrMailMock,
                'widgetContext' => $this->widgetContextMock,
                'urlManager' => $this->urlManagerMock,
                'storeManager' => $this->storeManagerMock,
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
        $this->assertEquals($this->itemModel, $this->itemModel);
    }
}
