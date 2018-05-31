<?php

namespace sportbooking\images\utils\interfaces;

/**
 * Interface MoverInterface
 * @package sportbooking\images\utils\interfaces
 */
interface MoverInterface
{
    /**
     * Move file from source to target.
     * @param string $source Example:
     *     '/tmp/AXxdF3'
     * @param string $target Example:
     *     '/srv/www/files/f5/a7/662fdadf621df0151fd078247165_original.png'
     * @return bool Return true if saved successful.
     */
    public static function move(string $source, string $target):bool;
}