<?php

namespace sportbooking\images\utils;
use sportbooking\images\utils\interfaces\MoverInterface;

/**
 * Class SafeMover
 * @package sportbooking\images\utils
 */
class SafeMover implements MoverInterface
{
    /**
     * Move file from source to target.
     * @param string $source Example:
     *     '/tmp/AXxdF3'
     * @param string $target Example:
     *     '/srv/www/files'
     * @return bool Return true if moved successful.
     */
    public static function move(string $source, string $target):bool
    {
        return move_uploaded_file($source, $target);
    }
}