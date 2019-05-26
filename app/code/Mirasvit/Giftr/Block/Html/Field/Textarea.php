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



namespace Mirasvit\Giftr\Block\Html\Field;

class Textarea extends \Mirasvit\Giftr\Block\Html\Field
{
    public function getElement()
    {
        return $this->elementFactory
            ->create('\Magento\Framework\Data\Form\Element\Textarea', [
                'html_id'   => $this->getId(),
                'name'      => $this->getName(),
                'class'     => $this->getClass(),
                'value'     => $this->getValue(),
                'title'     => $this->getTitle(),
            ]);
    }
}
