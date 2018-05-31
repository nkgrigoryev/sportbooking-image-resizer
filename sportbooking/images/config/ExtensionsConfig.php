<?php

namespace sportbooking\images\config;

/**
 * Class ExtensionsConfig
 * @package sportbooking\images\config
 */
class ExtensionsConfig
{
    /**
     * @var string[]
     */
    private $_extensions;

    /**
     * FormatsConfig constructor.
     * @param array $config Examples:
     *     [
     *         'jpg',
     *         'png'
     *     ]
     */
    public function __construct(array $config)
    {
        $this->_extensions = $config;
    }

    /**
     * Return true if file extension is valid.
     * @param string $extension
     * @return bool
     */
    public function extensionIsValid(string $extension):bool
    {
        return in_array($extension, $this->_extensions);
    }
}