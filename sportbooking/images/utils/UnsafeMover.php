<?php

namespace sportbooking\images\utils;
use Exception;
use sportbooking\images\utils\interfaces\MoverInterface;

/**
 * Class UnsafeMover
 * @package sportbooking\images\utils
 */
class UnsafeMover implements MoverInterface
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
        try
        {
            return rename($source, $target);
        }
        catch (Exception $exception)
        {
            return false;
        }
    }
}