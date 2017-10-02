<?php

use PHPUnit\Framework\TestCase;
use sportbooking\images\config\exceptions\InvalidSizeException;
use sportbooking\images\config\SizesConfig;

class SizesConfigTest extends TestCase
{
    public function testInvalidSizeException()
    {
        $config =
        [
            '800x600',
            '400x400'
        ];
        $this->expectException(InvalidSizeException::class);
        $sizesConfig = new SizesConfig($config);
        $sizesConfig->getSize('100x100');
    }

    public function testValidConfig()
    {
        $config =
        [
            '800x600',
            '400x400'
        ];
        $sizesConfig = new SizesConfig($config);
        $this->assertEquals($sizesConfig->getSize('800x600')->getWidth(), 800);
        $this->assertEquals($sizesConfig->getSize('800x600')->getHeight(), 600);
        $this->assertEquals($sizesConfig->getSize('400x400')->getWidth(), 400);
        $this->assertEquals($sizesConfig->getSize('400x400')->getHeight(), 400);
    }
}