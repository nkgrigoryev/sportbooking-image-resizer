<?php

use PHPUnit\Framework\TestCase;
use sportbooking\images\config\exceptions\InvalidSizeFormatException;
use sportbooking\images\config\SizeConfig;

class SizeConfigTest extends TestCase
{
    public function testInvalidSizeFormatExceptionOne()
    {
        $this->expectException(InvalidSizeFormatException::class);
        new SizeConfig('abcd');
    }

    public function testInvalidConfigExceptionTwo()
    {
        $this->expectException(InvalidSizeFormatException::class);
        new SizeConfig('800xx600');
    }

    public function testInvalidConfigExceptionThree()
    {
        $this->expectException(InvalidSizeFormatException::class);
        new SizeConfig('800x600x500');
    }

    public function testWidth()
    {
        $sizeConfig = new SizeConfig('800x600');
        $this->assertEquals($sizeConfig->getWidth(), 800);
    }

    public function testHeight()
    {
        $sizeConfig = new SizeConfig('1024x768');
        $this->assertEquals($sizeConfig->getHeight(), 768);
    }
}