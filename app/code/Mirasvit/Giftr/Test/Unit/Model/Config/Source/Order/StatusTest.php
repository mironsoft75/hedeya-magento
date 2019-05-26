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



namespace Mirasvit\Giftr\Test\Unit\Model\Config\Source\Order;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager as ObjectManager;

/**
 * @covers \Mirasvit\Giftr\Model\Config\Source\Order\Status
 * @SuppressWarnings(PHPMD)
 */
class StatusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Mirasvit\Giftr\Model\Config\Source\Order\Status|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $statusModel;

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $orderStatusCollectionFactoryMock;

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Status\Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $orderStatusCollectionMock;

    /**
     * @var \Magento\Framework\Model\Context|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $contextMock;

    /**
     * setup tests.
     */
    public function setUp()
    {
        $this->orderStatusCollectionFactoryMock = $this->getMock(
'\Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory', ['create'], [], '', false
);
        $this->orderStatusCollectionMock = $this->getMock(
'\Magento\Sales\Model\ResourceModel\Order\Status\Collection', ['load',
'save',
'delete',
'addFieldToFilter',
'setOrder',
'getFirstItem',
'getLastItem', ], [], '', false
);
        $this->orderStatusCollectionFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->orderStatusCollectionMock));
        $this->objectManager = new ObjectManager($this);
        $this->contextMock = $this->objectManager->getObject(
            '\Magento\Framework\Model\Context',
            [
            ]
        );
        $this->statusModel = $this->objectManager->getObject(
            '\Mirasvit\Giftr\Model\Config\Source\Order\Status',
            [
                'orderStatusCollectionFactory' => $this->orderStatusCollectionFactoryMock,
                'context' => $this->contextMock,
            ]
        );
    }

    /**
     * dummy test.
     */
    public function testDummy()
    {
        $this->assertEquals($this->statusModel, $this->statusModel);
    }
}
