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

use \Zend\Json\Decoder;
use \Zend\Json\Json;
use \Mirasvit\Giftr\Controller\Item;

class AddtocartTest extends \Magento\TestFramework\TestCase\AbstractController
{
    /**
     * setUp.
     */
    public function setUp()
    {
        $this->resource = 'Mirasvit_Giftr::giftr_dictionary_field';
        $this->uri = 'backend/helpdesk/field/edit';
        parent::setUp();
    }

    /**
     * @covers  Mirasvit\Giftr\Controller\Item\Addtocart::execute
     *
     * @magentoDataFixture Mirasvit/Giftr/_files/registry.php
     */
    public function testAddtocartAction()
    {
        $params = ['item_id' => 1];
        $this->getRequest()->setParams($params);
        $this->dispatch('giftr/item/addtocart');

        /* @var $cart \Magento\Checkout\Model\Cart */
        $cart = $this->_objectManager->create('Magento\Checkout\Model\Cart');

        $this->assertNotEquals('noroute', $this->getRequest()->getControllerName());
        $this->assertFalse($this->getResponse()->isRedirect());
        $this->assertGreaterThanOrEqual(1, $cart->getItemsCount());
        $this->assertSessionMessages(
            $this->isEmpty(),
            \Magento\Framework\Message\MessageInterface::TYPE_ERROR
        );
    }
}
