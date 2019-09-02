<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MirasvitGiftrApi\Plugin; 

class RegistryPlugin
{
    public function afterGetData(
        \Mirasvit\Giftr\Model\Registry $subject,
        $results
    ) {
        $subject->setItemsCount(
            $subject->getItemCollection()->getSize()
        );
        return $results;
    }

}
