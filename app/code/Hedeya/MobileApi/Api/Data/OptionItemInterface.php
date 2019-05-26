<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Api\Data;

interface OptionItemInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return string|null
     */
    public function getLabel();

    /**
     * @return mixed|null
     */
    public function getValue();

    /**
     * @return Hedeya\MobileApi\Api\Data\OptionItemInterface[]|null
     */
    public function getOptions();

}
