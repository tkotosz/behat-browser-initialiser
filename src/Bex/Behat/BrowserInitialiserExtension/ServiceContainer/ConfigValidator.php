<?php

namespace Bex\Behat\BrowserInitialiserExtension\ServiceContainer;

class ConfigValidator
{
    /**
     * @return \Closure
     */
    public function getBrowserSizeValueValidator()
    {
        $validator = $this;
        return function ($value) use ($validator) {
            if ($validator->isMaxSize($value) || $validator->isWidthHeightSize($value)) {
                return $value;
            }

            throw new \InvalidArgumentException("Invalid browser size: $value. Valid values: 'max' or 'WIDTHxHEIGHT'");
        };
    }

    /**
     * @return boolean
     */
    public function isMaxSize($size)
    {
        return $size == 'max';
    }

    /**
     * @return boolean
     */
    public function isWidthHeightSize($size)
    {
        $size = explode('x', $size);
        $width = isset($size[0]) ? $size[0] : '';
        $height = isset($size[1]) ? $size[1] : '';

        return (is_numeric($width) && is_numeric($height));
    }
}