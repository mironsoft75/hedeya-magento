<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
declare(strict_types=1);

namespace Hedeya\GraphQl\Model\Resolver\Product;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class FinalPrice implements ResolverInterface
{    
    /**
     * {@inheritdoc}
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) : float
    {
        return 0.0;        
    }
}
