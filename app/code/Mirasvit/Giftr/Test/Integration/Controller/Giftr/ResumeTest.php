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



namespace Mirasvit\Giftr\Controller\Giftr;

class ResumeTest extends \Magento\TestFramework\TestCase\AbstractController
{
    /**
     * @covers  Mirasvit\Giftr\Controller\Giftr\Resume::execute
     */
    public function testResumeAction()
    {
        $this->dispatch('giftr/giftr/resume');

        $baseUrl = $this->_objectManager->get('\Magento\Store\Model\StoreManagerInterface')->getStore()->getBaseUrl();

        $this->assertNotEquals('noroute', $this->getRequest()->getControllerName());
        $this->assertRedirect($this->equalTo($baseUrl));
    }
}
