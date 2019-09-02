<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Model\Category\Attribute\Source;

class ImageType extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                [
                    'value' => 'banner',
                    'label' => 'Banner',
                ],
                [
                    'value' => 'block',
                    'label' => 'Block',
                ],
            ];
        }
        return $this->_options;
    }
}
