<?php

namespace sportbooking\images\config;

/**
 * Class LimitsMinimalConfig
 * @package sportbooking\images\config
 */
class LimitsMinimalConfig extends LimitsCommonConfig
{
    /**
     * Default minimal size in bytes. 1 KB.
     */
    const DEFAULT_SIZE = 1024;

    /**
     * Default minimal width in bytes.
     */
    const DEFAULT_WIDTH = 16;

    /**
     * Default minimal height in bytes.
     */
    const DEFAULT_HEIGHT = 16;
}