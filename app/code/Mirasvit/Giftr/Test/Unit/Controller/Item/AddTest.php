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



namespace Mirasvit\Giftr\Test\Unit\Controller\Item;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManager;

/**
 * @covers \Mirasvit\Giftr\Controller\Item\Add
 * @SuppressWarnings(PHPMD)
 */
class AddTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Mirasvit\Giftr\Controller\Item\Add|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $itemController;

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
     * @var \Mirasvit\Giftr\Model\ItemFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $itemFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\Item|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $itemMock;

    /**
     * @var \Magento\Checkout\Model\Session|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $sessionMock;

    /**
     * @var \Magento\Checkout\Model\Cart|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $cartMock;

    /**
     * @var \Magento\Catalog\Helper\Product\View|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $catalogProductViewMock;

    /**
     * @var \Magento\Catalog\Helper\Product|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $catalogProductMock;

    /**
     * @var \Magento\Checkout\Helper\Cart|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $checkoutCartMock;

    /**
     * @var \Magento\Customer\Model\Url|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerUrlMock;

    /**
     * @var \Magento\Wishlist\Helper\Data|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $wishlistDataMock;

    /**
     * @var \Mirasvit\Giftr\Helper\Data|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $giftrDataMock;

    /**
     * @var \Psr\Log\LoggerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $loggerMock;

    /**
     * @var \Magento\Framework\Event\ManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $eventManagerMock;

    /**
     * @var \Magento\Framework\Registry|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registryMock;

    /**
     * @var \Magento\Customer\Model\Session|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerSessionMock;

    /**
     * @var \Magento\Framework\Json\Helper\Data|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $jsonEncoderMock;

    /**
     * @var \Magento\Framework\App\Action\Context|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $contextMock;

    /**
     * @var \Magento\Framework\View\Result\PageFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $resultFactoryMock;

    /**
     * @var \Magento\Backend\Model\View\Result\Page|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $resultPageMock;

    /**
     * @var \Magento\Framework\App\Response\RedirectInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $redirectMock;

    /**
     * @var \Magento\Framework\App\RequestInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestMock;

    /**
     * @var \Magento\Framework\Message\ManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $messageManagerMock;

    /**
     * setup tests.
     */
    public function setUp()
    {
        $this->registryFactoryMock = $this->getMock(
'\Mirasvit\Giftr\Model\RegistryFactory', ['create'], [], '', false
);
        $this->registryMock = $this->getMock(
'\Mirasvit\Giftr\Model\Registry', ['load',
'save',
'delete', ], [], '', false
);
        $this->registryFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->registryMock));
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
        $this->itemFactoryMock = $this->getMock(
'\Mirasvit\Giftr\Model\ItemFactory', ['create'], [], '', false
);
        $this->itemMock = $this->getMock(
'\Mirasvit\Giftr\Model\Item', ['load',
'save',
'delete', ], [], '', false
);
        $this->itemFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->itemMock));
        $this->sessionMock = $this->getMock(
'\Magento\Checkout\Model\Session', [], [], '', false
);
        $this->cartMock = $this->getMock(
'\Magento\Checkout\Model\Cart', [], [], '', false
);
        $this->catalogProductViewMock = $this->getMock(
'\Magento\Catalog\Helper\Product\View', [], [], '', false
);
        $this->catalogProductMock = $this->getMock(
'\Magento\Catalog\Helper\Product', [], [], '', false
);
        $this->checkoutCartMock = $this->getMock(
'\Magento\Checkout\Helper\Cart', [], [], '', false
);
        $this->customerUrlMock = $this->getMock(
'\Magento\Customer\Model\Url', [], [], '', false
);
        $this->wishlistDataMock = $this->getMock(
'\Magento\Wishlist\Helper\Data', [], [], '', false
);
        $this->giftrDataMock = $this->getMock(
'\Mirasvit\Giftr\Helper\Data', [], [], '', false
);
        $this->loggerMock = $this->getMockForAbstractClass(
'\Psr\Log\LoggerInterface', [], '', false, true, true, []
);
        $this->eventManagerMock = $this->getMockForAbstractClass(
'\Magento\Framework\Event\ManagerInterface', [], '', false, true, true, []
);
        $this->registryMock = $this->getMock(
'\Magento\Framework\Registry', [], [], '', false
);
        $this->customerSessionMock = $this->getMock(
'\Magento\Customer\Model\Session', [], [], '', false
);
        $this->jsonEncoderMock = $this->getMock(
'\Magento\Framework\Json\Helper\Data', [], [], '', false
);
        $this->requestMock = $this->getMockForAbstractClass(
'Magento\Framework\App\RequestInterface', [], '', false, true, true, []);
        $this->resultFactoryMock = $this->getMock(
'Magento\Framework\Controller\ResultFactory', ['create'], [], '', false
);
        $this->resultPageMock = $this->getMock('Magento\Backend\Model\View\Result\Page', [], [], '', false);
        $this->resultFactoryMock->expects($this->any())
           ->method('create')
           ->willReturn($this->resultPageMock);

        $this->redirectMock = $this->getMockForAbstractClass(
'Magento\Framework\App\Response\RedirectInterface', [], '', false, true, true, []
);
        $this->messageManagerMock = $this->getMockForAbstractClass(
'Magento\Framework\Message\ManagerInterface', [], '', false, true, true, []
);
        $this->objectManager = new ObjectManager($this);
        $this->contextMock = $this->getMock('\Magento\Backend\App\Action\Context', [], [], '', false);
        $this->contextMock->expects($this->any())->method('getRequest')->willReturn($this->requestMock);
        $this->contextMock->expects($this->any())->method('getObjectManager')->willReturn($this->objectManager);
        $this->contextMock->expects($this->any())->method('getResultFactory')->willReturn($this->resultFactoryMock);
        $this->contextMock->expects($this->any())->method('getRedirect')->willReturn($this->redirectMock);
        $this->contextMock->expects($this->any())->method('getMessageManager')->willReturn($this->messageManagerMock);
        $this->itemController = $this->objectManager->getObject(
            '\Mirasvit\Giftr\Controller\Item\Add',
            [
                'registryFactory' => $this->registryFactoryMock,
                'productFactory' => $this->productFactoryMock,
                'itemFactory' => $this->itemFactoryMock,
                'session' => $this->sessionMock,
                'cart' => $this->cartMock,
                'catalogProductView' => $this->catalogProductViewMock,
                'catalogProduct' => $this->catalogProductMock,
                'checkoutCart' => $this->checkoutCartMock,
                'customerUrl' => $this->customerUrlMock,
                'wishlistData' => $this->wishlistDataMock,
                'giftrData' => $this->giftrDataMock,
                'logger' => $this->loggerMock,
                'eventManager' => $this->eventManagerMock,
                'registry' => $this->registryMock,
                'customerSession' => $this->customerSessionMock,
                'jsonEncoder' => $this->jsonEncoderMock,
                'context' => $this->contextMock,
            ]
        );
    }

    /**
     * dummy test.
     */
    public function testDummy()
    {
        $this->assertEquals($this->itemController, $this->itemController);
    }
}
