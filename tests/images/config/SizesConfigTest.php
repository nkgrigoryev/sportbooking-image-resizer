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

    public function testWidth()
    {
        $config =
        [
            '800x600',
            '400x400'
        ];
        $sizesConfig = new SizesConfig($config);
        $this->assertEquals($sizesConfig->getSize('800x600')->getWidth(), 800);
    }

    public function testHeight()
    {
        $config =
        [
            '800x600',
            '400x400'
        ];
        $sizesConfig = new SizesConfig($config);
        $this->assertEquals($sizesConfig->getSize('800x600')->getHeight(), 600);
    }
}