<?php

namespace sportbooking\images\config;
use sportbooking\images\config\exceptions\InvalidSizeFormatException;

/**
 * Class SizeConfig
 * @package sportbooking\images\config
 */
class SizeConfig
{
    /**
     * @var int
     */
    private $_width;

    /**
     * @var int
     */
    private $_height;

    /**
     * SizeConfig constructor.
     * @param string $string Example:
     *     '800x600'
     * @throws InvalidSizeFormatException
     */
    public function __construct(string $string)
    {
        $stringIsValid = preg_match('/^\d*x\d*$/', $string);
        if (!$stringIsValid) throw new InvalidSizeFormatException('Invalid config. Invalid size format in config: \'' . $string . '\'. Example: \'800x600\'');
        $array = explode('x', $string);
        $this->_width = $array[0];
        $this->_height = $array[1];
    }

    /**
     * Return width in pixels.
     * @return int
     */
    public function getWidth():int
    {
        return $this->_width;
    }

    /**
     * Return height in pixels.
     * @return int
     */
    public function getHeight():int
    {
        return $this->_height;
    }
}