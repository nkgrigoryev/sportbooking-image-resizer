<?php

namespace sportbooking\images\config;

/**
 * Class LimitsMinimalConfig
 * @package sportbooking\images\config
 */
class LimitsMaximalConfig extends LimitsCommonConfig
{
    /**
     * Default maximal size in bytes. 20 MB.
     */
    const DEFAULT_SIZE = 20 * 1024 * 1024;

    /**
     * Default maximal width in bytes.
     */
    const DEFAULT_WIDTH = 16000;

    /**
     * Default maximal height in bytes.
     */
    const DEFAULT_HEIGHT = 9000;
}