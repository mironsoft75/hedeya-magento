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

/**
 * @covers \Mirasvit\Giftr\Helper\Block
 * @SuppressWarnings(PHPMD)
 */
class BlockTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Mirasvit\Giftr\Helper\Block|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $blockHelper;

    /**
     * @var \Mirasvit\Giftr\Model\RegistryFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registryFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\Registry|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registryMock;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Priority\CollectionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $priorityCollectionFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Priority\Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $priorityCollectionMock;

    /**
     * @var \Mirasvit\Giftr\Helper\Data|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $giftrDataMock;

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
     * @var \Magento\Customer\Model\CustomerFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerFactoryMock;

    /**
     * @var \Magento\Customer\Model\Customer|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerMock;

    /**
     * @var \Magento\Customer\Model\Session|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerSessionMock;

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
        $this->priorityCollectionFactoryMock = $this->getMock(
'\Mirasvit\Giftr\Model\ResourceModel\Priority\CollectionFactory', ['create'], [], '', false
);
        $this->priorityCollectionMock = $this->getMock(
'\Mirasvit\Giftr\Model\ResourceModel\Priority\Collection', ['load',
'save',
'delete',
'addFieldToFilter',
'setOrder',
'getFirstItem',
'getLastItem', ], [], '', false
);
        $this->priorityCollectionFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->priorityCollectionMock));
        $this->giftrDataMock = $this->getMock(
'\Mirasvit\Giftr\Helper\Data', [], [], '', false
);
        $this->assetRepoMock = $this->getMock(
'\Magento\Framework\View\Asset\Repository', [], [], '', false
);
        $this->localeDateMock = $this->getMockForAbstractClass(
'\Magento\Framework\Stdlib\DateTime\TimezoneInterface', [], '', false, true, true, []
);
        $this->customerFactoryMock = $this->getMock(
'\Magento\Customer\Model\CustomerFactory', ['create'], [], '', false
);
        $this->customerMock = $this->getMock(
'\Magento\Customer\Model\Customer', ['load',
'save',
'delete', ], [], '', false
);
        $this->customerFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->customerMock));
        $this->customerSessionMock = $this->getMock(
'\Magento\Customer\Model\Session', [], [], '', false
);
        $this->objectManager = new ObjectManager($this);
        $this->contextMock = $this->objectManager->getObject(
            '\Magento\Framework\App\Helper\Context',
            [
            ]
        );
        $this->blockHelper = $this->objectManager->getObject(
            '\Mirasvit\Giftr\Helper\Block',
            [
                'registryFactory' => $this->registryFactoryMock,
                'priorityCollectionFactory' => $this->priorityCollectionFactoryMock,
                'giftrData' => $this->giftrDataMock,
                'context' => $this->contextMock,
                'assetRepo' => $this->assetRepoMock,
                'localeDate' => $this->localeDateMock,
                'customerFactory' => $this->customerFactoryMock,
                'customerSession' => $this->customerSessionMock,
            ]
        );
    }

    /**
     * dummy test.
     */
    public function testDummy()
    {
        $this->assertEquals($this->blockHelper, $this->blockHelper);
    }
}
