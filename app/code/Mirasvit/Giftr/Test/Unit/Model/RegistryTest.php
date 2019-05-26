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
use Mirasvit\Giftr\Model\Config as Config;

/**
 * @covers \Mirasvit\Giftr\Model\Registry
 * @SuppressWarnings(PHPMD)
 */
class RegistryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Mirasvit\Giftr\Model\Registry|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registryModel;

    /**
     * @var \Mirasvit\Giftr\Model\TypeFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $typeFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\Type|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $typeMock;

    /**
     * @var \Magento\Store\Model\WebsiteFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $websiteFactoryMock;

    /**
     * @var \Magento\Store\Model\Website|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $websiteMock;

    /**
     * @var \Magento\Customer\Model\CustomerFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerFactoryMock;

    /**
     * @var \Magento\Customer\Model\Customer|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerMock;

    /**
     * @var \Magento\Customer\Model\AddressFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $addressFactoryMock;

    /**
     * @var \Magento\Customer\Model\Address|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $addressMock;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Field\CollectionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $fieldCollectionFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Field\Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $fieldCollectionMock;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Item\CollectionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $itemCollectionFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Item\Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $itemCollectionMock;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Purchase\CollectionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $purchaseCollectionFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Purchase\Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $purchaseCollectionMock;

    /**
     * @var \Mirasvit\Giftr\Model\Config|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $configMock;

    /**
     * @var \Mirasvit\Giftr\Helper\Storeview|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $giftrStoreviewMock;

    /**
     * @var \Mirasvit\Core\Helper\Image|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $coreImageMock;

    /**
     * @var \Mirasvit\Giftr\Helper\Data|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $giftrDataMock;

    /**
     * @var \Magento\Framework\UrlInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $urlManagerMock;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $storeManagerMock;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $localeDateMock;

    /**
     * @var \Magento\Customer\Model\Session|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerSessionMock;

    /**
     * @var \Magento\Framework\Image\Factory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $imageFactoryMock;

    /**
     * @var \Magento\Framework\Image\|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $imageMock;

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
        $this->typeFactoryMock = $this->getMock(
            '\Mirasvit\Giftr\Model\TypeFactory',
            ['create'],
            [],
            '',
            false
        );
        $this->typeMock = $this->getMock(
            '\Mirasvit\Giftr\Model\Type',
            ['load',
            'save',
            'delete', ],
            [],
            '',
            false
        );
        $this->typeFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->typeMock));
        $this->websiteFactoryMock = $this->getMock(
            '\Magento\Store\Model\WebsiteFactory',
            ['create'],
            [],
            '',
            false
        );
        $this->websiteMock = $this->getMock(
            '\Magento\Store\Model\Website',
            ['load',
            'save',
            'delete', ],
            [],
            '',
            false
        );
        $this->websiteFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->websiteMock));
        $this->customerFactoryMock = $this->getMock(
            '\Magento\Customer\Model\CustomerFactory',
            ['create'],
            [],
            '',
            false
        );
        $this->customerMock = $this->getMock(
            '\Magento\Customer\Model\Customer',
            ['load',
            'save',
            'delete', ],
            [],
            '',
            false
        );
        $this->customerFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->customerMock));
        $this->addressFactoryMock = $this->getMock(
            '\Magento\Customer\Model\AddressFactory',
            ['create'],
            [],
            '',
            false
        );
        $this->addressMock = $this->getMock(
            '\Magento\Customer\Model\Address',
            ['load',
            'save',
            'delete', ],
            [],
            '',
            false
        );
        $this->addressFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->addressMock));
        $this->fieldCollectionFactoryMock = $this->getMock(
            '\Mirasvit\Giftr\Model\ResourceModel\Field\CollectionFactory',
            ['create'],
            [],
            '',
            false
        );
        $this->fieldCollectionMock = $this->getMock(
            '\Mirasvit\Giftr\Model\ResourceModel\Field\Collection',
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
        $this->fieldCollectionFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->fieldCollectionMock));
        $this->itemCollectionFactoryMock = $this->getMock(
            '\Mirasvit\Giftr\Model\ResourceModel\Item\CollectionFactory',
            ['create'],
            [],
            '',
            false
        );
        $this->itemCollectionMock = $this->getMock(
            '\Mirasvit\Giftr\Model\ResourceModel\Item\Collection',
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
        $this->itemCollectionFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->itemCollectionMock));
        $this->purchaseCollectionFactoryMock = $this->getMock(
            '\Mirasvit\Giftr\Model\ResourceModel\Purchase\CollectionFactory',
            ['create'],
            [],
            '',
            false
        );
        $this->purchaseCollectionMock = $this->getMock(
            '\Mirasvit\Giftr\Model\ResourceModel\Purchase\Collection',
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
        $this->purchaseCollectionFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->purchaseCollectionMock));
        $this->configMock = $this->getMock(
            '\Mirasvit\Giftr\Model\Config',
            [],
            [],
            '',
            false
        );
        $this->giftrStoreviewMock = $this->getMock(
            '\Mirasvit\Giftr\Helper\Storeview',
            [],
            [],
            '',
            false
        );
        $this->coreImageMock = $this->getMock(
            '\Mirasvit\Core\Helper\Image',
            [],
            [],
            '',
            false
        );
        $this->giftrDataMock = $this->getMock(
            '\Mirasvit\Giftr\Helper\Data',
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
        $this->localeDateMock = $this->getMockForAbstractClass(
            '\Magento\Framework\Stdlib\DateTime\TimezoneInterface',
            [],
            '',
            false,
            true,
            true,
            []
        );
        $this->customerSessionMock = $this->getMock(
            '\Magento\Customer\Model\Session',
            [],
            [],
            '',
            false
        );
        $this->imageFactoryMock = $this->getMock(
            '\Magento\Framework\Image\Factory',
            ['create'],
            [],
            '',
            false
        );
        $this->imageMock = $this->getMock(
            '\Magento\Framework\Image',
            ['load',
            'save',
            'delete', ],
            [],
            '',
            false
        );
        $this->imageFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->imageMock));
        $this->registryMock = $this->getMock(
            '\Magento\Framework\Registry',
            [],
            [],
            '',
            false
        );
        $this->resourceMock = $this->getMock(
            '\Mirasvit\Giftr\Model\ResourceModel\Registry',
            [],
            [],
            '',
            false
        );
        $this->resourceCollectionMock = $this->getMock(
            '\Mirasvit\Giftr\Model\ResourceModel\Registry\Collection',
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
        $this->registryModel = $this->objectManager->getObject(
            '\Mirasvit\Giftr\Model\Registry',
            [
                'typeFactory' => $this->typeFactoryMock,
                'websiteFactory' => $this->websiteFactoryMock,
                'customerFactory' => $this->customerFactoryMock,
                'addressFactory' => $this->addressFactoryMock,
                'fieldCollectionFactory' => $this->fieldCollectionFactoryMock,
                'itemCollectionFactory' => $this->itemCollectionFactoryMock,
                'purchaseCollectionFactory' => $this->purchaseCollectionFactoryMock,
                'config' => $this->configMock,
                'giftrStoreview' => $this->giftrStoreviewMock,
                'coreImage' => $this->coreImageMock,
                'giftrData' => $this->giftrDataMock,
                'urlManager' => $this->urlManagerMock,
                'storeManager' => $this->storeManagerMock,
                'localeDate' => $this->localeDateMock,
                'customerSession' => $this->customerSessionMock,
                'imageFactory' => $this->imageFactoryMock,
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
        $this->assertEquals($this->registryModel, $this->registryModel);
    }
}
