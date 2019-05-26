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



namespace Mirasvit\Giftr\Controller\Item;

class MassUpdateTest extends \Magento\TestFramework\TestCase\AbstractController
{
    /**
     * @var \Magento\Customer\Api\AccountManagementInterface
     */
    private $accountManagement;

    protected function setUp()
    {
        parent::setUp();
        $logger = $this->getMock('Psr\Log\LoggerInterface', [], [], '', false);
        $session = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Customer\Model\Session',
            [$logger]
        );
        $this->accountManagement = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
            'Magento\Customer\Api\AccountManagementInterface'
        );
        $customer = $this->accountManagement->authenticate('customer@example.com', 'password');
        $session->setCustomerDataAsLoggedIn($customer);
    }

    /**
     * @covers  Mirasvit\Giftr\Controller\Item\Manage::execute
     *
     * @magentoDataFixture Mirasvit/Giftr/_files/registry.php
     */
    public function testMassUpdateAction()
    {
        $params = ['id' => 1, 'items' => [1 => ['note' => 'Nice product']]];
        $this->getRequest()->setMethod(\Zend\Http\Request::METHOD_POST);
        $this->getRequest()->setParams($params);
        $this->dispatch('giftr/item/massupdate');

        $this->assertNotEquals('noroute', $this->getRequest()->getControllerName());
        $this->assertRedirect($this->stringContains('giftr/item/manage/id/1'));
        $this->assertSessionMessages($this->contains('Gift Registry Items successfully updated'));
    }
}
