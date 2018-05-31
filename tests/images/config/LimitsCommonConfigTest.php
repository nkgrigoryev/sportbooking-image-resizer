<?php

use PHPUnit\Framework\TestCase;
use sportbooking\images\config\LimitsCommonConfig;

class LimitsCommonConfigTest extends TestCase
{
    public function testSize()
    {
        $config =
        [
            'size' => 50000,
        ];
        $limitsMinimalConfig = new LimitsCommonConfig($config);
        $this->assertEquals($limitsMinimalConfig->getSize(), 50000);
    }

    public function testWidth()
    {
        $config =
        [
            'width' => 100,
        ];
        $limitsMinimalConfig = new LimitsCommonConfig($config);
        $this->assertEquals($limitsMinimalConfig->getWidth(), 100);
    }

    public function testHeight()
    {
        $config =
        [
            'height' => 200
        ];
        $limitsMinimalConfig = new LimitsCommonConfig($config);
        $this->assertEquals($limitsMinimalConfig->getHeight(), 200);
    }
}