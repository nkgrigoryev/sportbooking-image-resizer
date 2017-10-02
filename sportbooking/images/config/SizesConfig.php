<?php

namespace sportbooking\images\config;
use sportbooking\images\config\exceptions\InvalidSizeException;

/**
 * Class SizesConfig
 * @package sportbooking\images\config
 */
class SizesConfig
{
    private $_sizes;

    /**
     * SizesConfig constructor.
     * @param array $config Example:
     *     [
     *         '800x600',
     *         '400x400'
     *     ]
     */
    public function __construct(array $config)
    {
        $this->_sizes = [];
        foreach ($config as $parameter)
            $this->_sizes[$parameter] = new SizeConfig($parameter);
    }

    /**
     * Return SizeConfig object.
     * @param string $string Example:
     *     '800x600'
     * @return SizeConfig
     * @throws InvalidSizeException
     */
    public function getSize(string $string):SizeConfig
    {
        if (!isset($this->_sizes[$string])) throw new InvalidSizeException('Invalid size. ' . $string);
        return $this->_sizes[$string];
    }
}