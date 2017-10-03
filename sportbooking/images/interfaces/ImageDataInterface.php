<?php

namespace sportbooking\images\interfaces;

/**
 * Interface ImageDataInterface
 * @package sportbooking\images\interfaces
 */
interface ImageDataInterface
{
    /**
     * Return relative path.
     * @return string Example:
     *     '/f5/a7/662fdadf621df0151fd078247165_original.png'
     */
    public function getRelativePath():string;

    /**
     * Return name.
     * @return string Example:
     *     'logo.png'
     */
    public function getName():string;

    /**
     * Return type.
     * @return string Example:
     *     'image/png'
     */
    public function getType():string;

    /**
     * Return width in pixels.
     * @return string Example:
     *     256
     */
    public function getWidth():string;

    /**
     * Return height in pixels.
     * @return string Example:
     *     256
     */
    public function getHeight():string;

    /**
     * Return size in bytes.
     * @return string Example:
     *     256
     */
    public function getSize():string;

    /**
     * Return image key.
     * @return int|string Example:
     *     0
     *     'avatar'
     */
    public function getKey();
}