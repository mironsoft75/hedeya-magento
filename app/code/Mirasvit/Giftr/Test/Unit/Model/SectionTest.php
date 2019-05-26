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
 * @covers \Mirasvit\Giftr\Model\Section
 * @SuppressWarnings(PHPMD)
 */
class SectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Mirasvit\Giftr\Model\Section|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $sectionModel;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Field\CollectionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $fieldCollectionFactoryMock;

    /**
     * @var \Mirasvit\Giftr\Model\ResourceModel\Field\Collection|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $fieldCollectionMock;

    /**
     * @var \Mirasvit\Giftr\Helper\Storeview|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $giftrStoreviewMock;

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
        $this->fieldCollectionFactoryMock = $this->getMock(
'\Mirasvit\Giftr\Model\ResourceModel\Field\CollectionFactory', ['create'], [], '', false
);
        $this->fieldCollectionMock = $this->getMock(
'\Mirasvit\Giftr\Model\ResourceModel\Field\Collection', ['load',
'save',
'delete',
'addFieldToFilter',
'setOrder',
'getFirstItem',
'getLastItem', ], [], '', false
);
        $this->fieldCollectionFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->fieldCollectionMock));
        $this->giftrStoreviewMock = $this->getMock(
'\Mirasvit\Giftr\Helper\Storeview', [], [], '', false
);
        $this->registryMock = $this->getMock(
'\Magento\Framework\Registry', [], [], '', false
);
        $this->resourceMock = $this->getMock(
'\Mirasvit\Giftr\Model\ResourceModel\Section', [], [], '', false
);
        $this->resourceCollectionMock = $this->getMock(
'\Mirasvit\Giftr\Model\ResourceModel\Section\Collection', [], [], '', false
);
        $this->objectManager = new ObjectManager($this);
        $this->contextMock = $this->objectManager->getObject(
            '\Magento\Framework\Model\Context',
            [
            ]
        );
        $this->sectionModel = $this->objectManager->getObject(
            '\Mirasvit\Giftr\Model\Section',
            [
                'fieldCollectionFactory' => $this->fieldCollectionFactoryMock,
                'giftrStoreview' => $this->giftrStoreviewMock,
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
        $this->assertEquals($this->sectionModel, $this->sectionModel);
    }
}
