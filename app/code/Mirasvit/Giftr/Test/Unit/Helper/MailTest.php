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
 * @covers \Mirasvit\Giftr\Helper\Mail
 * @SuppressWarnings(PHPMD)
 */
class MailTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Mirasvit\Giftr\Helper\Mail|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $mailHelper;

    /**
     * @var \Magento\Email\Model\TemplateFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $emailTemplateFactoryMock;

    /**
     * @var \Magento\Email\Model\Template|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $emailTemplateMock;

    /**
     * @var \Mirasvit\Giftr\Model\Config|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $configMock;

    /**
     * @var \Magento\Framework\App\Helper\Context|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $contextMock;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $storeManagerMock;

    /**
     * @var \Magento\Framework\Registry|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $registryMock;

    /**
     * @var \Magento\Framework\View\Asset\Repository|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $assetRepoMock;

    /**
     * @var \Magento\Framework\Filesystem|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $filesystemMock;

    /**
     * @var \Magento\Framework\View\DesignInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $designMock;

    /**
     * setup tests.
     */
    public function setUp()
    {
        $this->emailTemplateFactoryMock = $this->getMock(
'\Magento\Email\Model\TemplateFactory', ['create'], [], '', false
);
        $this->emailTemplateMock = $this->getMock(
'\Magento\Email\Model\Template', ['load',
'save',
'delete', ], [], '', false
);
        $this->emailTemplateFactoryMock->expects($this->any())->method('create')
                ->will($this->returnValue($this->emailTemplateMock));
        $this->configMock = $this->getMock(
'\Mirasvit\Giftr\Model\Config', [], [], '', false
);

        $this->storeManagerMock = $this->getMockForAbstractClass(
'\Magento\Store\Model\StoreManagerInterface', [], '', false, true, true, []
);
        $this->registryMock = $this->getMock(
'\Magento\Framework\Registry', [], [], '', false
);
        $this->assetRepoMock = $this->getMock(
'\Magento\Framework\View\Asset\Repository', [], [], '', false
);
        $this->filesystemMock = $this->getMock(
'\Magento\Framework\Filesystem', [], [], '', false
);
        $this->designMock = $this->getMockForAbstractClass(
'\Magento\Framework\View\DesignInterface', [], '', false, true, true, []
);
        $this->objectManager = new ObjectManager($this);
        $this->contextMock = $this->objectManager->getObject(
            '\Magento\Framework\App\Helper\Context',
            [
            ]
        );
        $this->mailHelper = $this->objectManager->getObject(
            '\Mirasvit\Giftr\Helper\Mail',
            [
                'emailTemplateFactory' => $this->emailTemplateFactoryMock,
                'config' => $this->configMock,
                'context' => $this->contextMock,
                'storeManager' => $this->storeManagerMock,
                'registry' => $this->registryMock,
                'assetRepo' => $this->assetRepoMock,
                'filesystem' => $this->filesystemMock,
                'design' => $this->designMock,
            ]
        );
    }

    /**
     * dummy test.
     */
    public function testDummy()
    {
        $this->assertEquals($this->mailHelper, $this->mailHelper);
    }
}
