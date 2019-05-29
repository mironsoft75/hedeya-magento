<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\RokanBrand\Block\Adminhtml\Form\Element;

use Magento\Catalog\Block\Adminhtml\Category\AbstractCategory;

class CategoryOptions extends AbstractCategory implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        $options = [];

        foreach ($this->getCategoryCollection() as $category) {
            $options[$category->getId()] = $category->getName();
        }

        return $options;
    }

}
