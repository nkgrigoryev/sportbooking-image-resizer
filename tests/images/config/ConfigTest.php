<?php

use PHPUnit\Framework\TestCase;
use sportbooking\images\config\Config;
use sportbooking\images\config\exceptions\BaseDirectoryDoNotExistException;
use sportbooking\images\config\exceptions\BaseDirectoryDoNotSetException;
use sportbooking\images\config\exceptions\BaseDirectoryInvalidPermissionsException;
use sportbooking\images\config\exceptions\BaseDirectoryIsFileException;

class ConfigTest extends TestCase
{
    public function testBaseDirectoryDoNotSetException()
    {
        $config = [];
        $this->expectException(BaseDirectoryDoNotSetException::class);
        new Config($config);
    }

    public function testBaseDirectoryDoNotExistException()
    {
        $config =
        [
            'baseDirectory' => __DIR__ . '/directoryNotExist'
        ];
        $this->expectException(BaseDirectoryDoNotExistException::class);
        new Config($config);
    }

    public function testBaseDirectoryIsFileException()
    {
        $config =
        [
            'baseDirectory' => __DIR__ . '/assets/file.txt'
        ];
        $this->expectException(BaseDirectoryIsFileException::class);
        new Config($config);
    }

    public function testBaseDirectoryInvalidPermissionsException()
    {
        $directory = __DIR__ . '/assets/permissions';
        chmod($directory, 0555);
        $config =
        [
            'baseDirectory' => __DIR__ . '/assets/permissions'
        ];
        $this->expectException(BaseDirectoryInvalidPermissionsException::class);
        new Config($config);
    }

    public function testEmptyMaximalQuantity()
    {
        $config =
        [
            'baseDirectory' => __DIR__ . '/assets/upload'
        ];
        $config = new Config($config);
        $this->assertEquals(Config::DEFAULT_MAXIMAL_QUANTITY, $config->getMaximalQuantity());
    }

    public function testMaximalQuantity()
    {
        $maximalQuantity = 25;
        $config =
        [
            'maximalQuantity' => $maximalQuantity,
            'baseDirectory' => __DIR__ . '/assets/upload'
        ];
        $config = new Config($config);
        $this->assertEquals($maximalQuantity, $config->getMaximalQuantity());
    }

    public function testBaseDirectory()
    {
        $directory = __DIR__ . '/assets/upload';
        $config =
        [
            'baseDirectory' => $directory
        ];
        $config = new Config($config);
        $this->assertEquals($directory, $config->getBaseDirectory());
    }

    public function testPermissions()
    {
        $permissions = 2775;
        $config =
        [
            'baseDirectory' => __DIR__ . '/assets/upload',
            'permissions' => $permissions
        ];
        $config = new Config($config);
        $this->assertEquals($permissions, $config->getPermissions());
    }
}