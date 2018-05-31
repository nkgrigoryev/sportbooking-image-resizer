<?php

namespace sportbooking\images\requirements;
use sportbooking\images\requirements\exceptions\ImagickIsNotInstalledException;
use sportbooking\images\requirements\exceptions\PHPVersionException;

/**
 * Class Requirements
 * @package sportbooking\images\requirements
 */
class Requirements
{
    const MINIMAL_PHP_VERSION = '7.1';

    public static function validate()
    {
        if (version_compare(phpversion(), self::MINIMAL_PHP_VERSION, '<='))
            throw new PHPVersionException();
        if (!class_exists('Imagick'))
            throw new ImagickIsNotInstalledException();
    }
}