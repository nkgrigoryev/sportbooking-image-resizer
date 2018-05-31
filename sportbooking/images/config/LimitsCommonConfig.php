<?php

namespace sportbooking\images\config;

/**
 * Class LimitsCommonConfig
 * @package sportbooking\images\config
 */
class LimitsCommonConfig
{
    /**
     * Used if parameter do not set in config. Must be override by parent class.
     */
    const DEFAULT_SIZE = 0;

    /**
     * Used if parameter do not set in config. Must be override by parent class.
     */
    const DEFAULT_WIDTH = 0;

    /**
     * Used if parameter do not set in config. Must be override by parent class.
     */
    const DEFAULT_HEIGHT = 0;

    /**
     * @var int
     */
    private $_size;

    /**
     * @var int
     */
    private $_width;

    /**
     * @var int
     */
    private $_height;

    /**
     * LimitsBaseConfig constructor.
     * @param array $config Example:
     *     [
     *         'size' => 1024, // 1 KB
     *         'width' => 16,
     *         'height' => 16
     *     ]
     */
    public function __construct(array $config)
    {
        $this->_size = $config['size'] ?? $this::DEFAULT_SIZE;
        $this->_width = $config['width'] ?? $this::DEFAULT_WIDTH;
        $this->_height = $config['height'] ?? $this::DEFAULT_HEIGHT;
    }

    /**
     * Return size in bytes.
     * @return int
     */
    public function getSize():int
    {
        return $this->_size;
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