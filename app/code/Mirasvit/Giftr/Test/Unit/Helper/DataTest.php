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



namespace Mirasvit\Giftr\Test\Unit\Helper;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManager;
use Mirasvit\Giftr\Model\Config as Config;

/**
 * @covers \Mirasvit\Giftr\Helper\Data
 * @SuppressWarnings(PHPMD)
 */
class DataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Mirasvit\Giftr\Helper\Data|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $dataHelper;

    /**
     * @var \Magento\Customer\Model\CustomerFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerFactoryMock;

    /**
     * @var \Magento\Customer\Model\Customer|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerMock;

    /**
     * @var \Mirasvit\Giftr\Model\RegistryFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registryFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\Registry|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registryMock;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Item\CollectionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $itemCollectionFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Item\Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $itemCollectionMock;

    /**
     * @var \Magento\Store\Model\ResourceModel\Website\CollectionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $websiteCollectionFactoryMock;

    /**
     * @var \Magento\Store\Model\ResourceModel\Website\Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $websiteCollectionMock;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerCollectionFactoryMock;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Customer\Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerCollectionMock;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Purchase\CollectionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $purchaseCollectionFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Purchase\Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $purchaseCollectionMock;

    /**
     * @var \Magento\Checkout\Model\Session|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $sessionMock;

    /**
     * @var \Mirasvit\Giftr\Model\Config|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $configMock;

    /**
     * @var \Magento\Checkout\Model\Cart|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $cartMock;

    /**
     * @var \Magento\Framework\App\ResourceConnection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $resourceMock;

    /**
     * @var \Magento\Checkout\Helper\Cart|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $checkoutCartMock;

    /**
     * @var \Magento\Framework\App\Helper\Context|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $contextMock;

    /**
     * @var \Magento\Framework\View\Asset\Repository|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $assetRepoMock;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $localeDateMock;

    /**
     * @var \Magento\Customer\Model\Session|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerSessionMock;

    /**
     * setup tests.
     */
    public function setUp()
    {
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
        $this->websiteCollectionFactoryMock = $this->getMock(
            '\Magento\Store\Model\ResourceModel\Website\CollectionFactory',
            ['create'],
            [],
            '',
            false
        );
        $this->websiteCollectionMock = $this->getMock(
            '\Magento\Store\Model\ResourceModel\Website\Collection',
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
        $this->websiteCollectionFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->websiteCollectionMock));
        $this->customerCollectionFactoryMock = $this->getMock(
            '\Magento\Customer\Model\ResourceModel\Customer\CollectionFactory',
            ['create'],
            [],
            '',
            false
        );
        $this->customerCollectionMock = $this->getMock(
            '\Magento\Customer\Model\ResourceModel\Customer\Collection',
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
        $this->customerCollectionFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->customerCollectionMock));
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
        $this->sessionMock = $this->getMock(
            '\Magento\Checkout\Model\Session',
            [],
            [],
            '',
            false
        );
        $this->configMock = $this->getMock(
            '\Mirasvit\Giftr\Model\Config',
            [],
            [],
            '',
            false
        );
        $this->cartMock = $this->getMock(
            '\Magento\Checkout\Model\Cart',
            [],
            [],
            '',
            false
        );
        $this->resourceMock = $this->getMock(
            '\Magento\Framework\App\ResourceConnection',
            [],
            [],
            '',
            false
        );
        $this->checkoutCartMock = $this->getMock(
            '\Magento\Checkout\Helper\Cart',
            [],
            [],
            '',
            false
        );
        $this->assetRepoMock = $this->getMock(
            '\Magento\Framework\View\Asset\Repository',
            [],
            [],
            '',
            false
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
        $this->objectManager = new ObjectManager($this);
        $this->contextMock = $this->objectManager->getObject(
            '\Magento\Framework\App\Helper\Context',
            [
            ]
        );
        $this->dataHelper = $this->objectManager->getObject(
            '\Mirasvit\Giftr\Helper\Data',
            [
                'customerFactory' => $this->customerFactoryMock,
                'registryFactory' => $this->registryFactoryMock,
                'itemCollectionFactory' => $this->itemCollectionFactoryMock,
                'websiteCollectionFactory' => $this->websiteCollectionFactoryMock,
                'customerCollectionFactory' => $this->customerCollectionFactoryMock,
                'purchaseCollectionFactory' => $this->purchaseCollectionFactoryMock,
                'session' => $this->sessionMock,
                'config' => $this->configMock,
                'cart' => $this->cartMock,
                'resource' => $this->resourceMock,
                'checkoutCart' => $this->checkoutCartMock,
                'context' => $this->contextMock,
                'assetRepo' => $this->assetRepoMock,
                'localeDate' => $this->localeDateMock,
                'customerSession' => $this->customerSessionMock,
            ]
        );
    }

    /**
     * dummy test.
     */
    public function testDummy()
    {
        $this->assertEquals($this->dataHelper, $this->dataHelper);
    }
}
