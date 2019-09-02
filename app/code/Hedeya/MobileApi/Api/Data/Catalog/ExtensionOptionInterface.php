<?php
/**
 * Copyright © Hedeya. All rights reserved.
 */
namespace Hedeya\MobileApi\Api\Data\Catalog;

interface ExtensionOptionInterface
{
    const CODE = "code";
    const VALUE = "value";
    const LABEL = "label";
    const SWATCH = "swatch";
    
    /**
     * @return mixed|null
     */
    public function getCode();

    /**
     * @param string $code
     * @return $this
     */
    public function setCode($code);

    /**
     * @return mixed|null
     */
    public function getValue();

    /**
     * @param string $value
     * @return $this
     */
    public function setValue($value);

    /**
     * @return string|null
     */
    public function getLabel();

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel($label);

    /**
     * @return string|null
     */
    public function getSwatch();

    /**
     * @param string $swatch
     * @return $this
     */
    public function setSwatch($swatch);

}
