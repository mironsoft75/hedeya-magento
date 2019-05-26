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



namespace Mirasvit\Giftr\Test\Unit\Controller\Registry;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManager;

/**
 * @covers \Mirasvit\Giftr\Controller\Registry\Index
 * @SuppressWarnings(PHPMD)
 */
class IndexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Mirasvit\Giftr\Controller\Registry\Index|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registryController;

    /**
     * @var \Mirasvit\Giftr\Model\RegistryFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registryFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\Registry|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registryFIXMEMock;

    /**
     * @var \Magento\Customer\Model\AddressFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $addressFactoryMock;

    /**
     * @var \Magento\Customer\Model\Address|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $addressMock;

    /**
     * @var \Magento\Customer\Model\FormFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $formFactoryMock;

    /**
     * @var \Magento\Customer\Model\Form|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $formMock;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Type\CollectionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $typeCollectionFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Type\Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $typeCollectionMock;

    /**
     * @var \Magento\Customer\Model\Url|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerUrlMock;

    /**
     * @var \Magento\Framework\Registry|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registryMock;

    /**
     * @var \Magento\Customer\Model\Session|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerSessionMock;

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
        $this->addressFactoryMock = $this->getMock(
'\Magento\Customer\Model\AddressFactory', ['create'], [], '', false
);
        $this->addressMock = $this->getMock(
'\Magento\Customer\Model\Address', ['load',
'save',
'delete', ], [], '', false
);
        $this->addressFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->addressMock));
        $this->formFactoryMock = $this->getMock(
'\Magento\Customer\Model\FormFactory', ['create'], [], '', false
);
        $this->formMock = $this->getMock(
'\Magento\Customer\Model\Form', ['load',
'save',
'delete', ], [], '', false
);
        $this->formFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->formMock));
        $this->typeCollectionFactoryMock = $this->getMock(
'\Mirasvit\Giftr\Model\ResourceModel\Type\CollectionFactory', ['create'], [], '', false
);
        $this->typeCollectionMock = $this->getMock(
'\Mirasvit\Giftr\Model\ResourceModel\Type\Collection', ['load',
'save',
'delete',
'addFieldToFilter',
'setOrder',
'getFirstItem',
'getLastItem', ], [], '', false
);
        $this->typeCollectionFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->typeCollectionMock));
        $this->customerUrlMock = $this->getMock(
'\Magento\Customer\Model\Url', [], [], '', false
);
        $this->registryMock = $this->getMock(
'\Magento\Framework\Registry', [], [], '', false
);
        $this->customerSessionMock = $this->getMock(
'\Magento\Customer\Model\Session', [], [], '', false
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
        $this->registryController = $this->objectManager->getObject(
            '\Mirasvit\Giftr\Controller\Registry\Index',
            [
                'registryFactory' => $this->registryFactoryMock,
                'addressFactory' => $this->addressFactoryMock,
                'formFactory' => $this->formFactoryMock,
                'typeCollectionFactory' => $this->typeCollectionFactoryMock,
                'customerUrl' => $this->customerUrlMock,
                'registry' => $this->registryMock,
                'customerSession' => $this->customerSessionMock,
                'context' => $this->contextMock,
            ]
        );
    }

    /**
     * dummy test.
     */
    public function testDummy()
    {
        $this->assertEquals($this->registryController, $this->registryController);
    }
}
