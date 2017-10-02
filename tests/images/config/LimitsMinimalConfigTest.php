<?php

use PHPUnit\Framework\TestCase;
use sportbooking\images\config\LimitsMinimalConfig;

class LimitsMinimalConfigTest extends TestCase
{
    public function testFullConfig()
    {
        $config =
        [
            'size' => 50000,
            'width' => 100,
            'height' => 200
        ];
        $limitsMinimalConfig = new LimitsMinimalConfig($config);
        $this->assertEquals($limitsMinimalConfig->getSize(), 50000);
        $this->assertEquals($limitsMinimalConfig->getWidth(), 100);
        $this->assertEquals($limitsMinimalConfig->getHeight(), 200);
    }

    public function testEmptyConfig()
    {
        $config = [];
        $limitsMinimalConfig = new LimitsMinimalConfig($config);
        $this->assertEquals($limitsMinimalConfig->getSize(), LimitsMinimalConfig::DEFAULT_SIZE);
        $this->assertEquals($limitsMinimalConfig->getWidth(), LimitsMinimalConfig::DEFAULT_WIDTH);
        $this->assertEquals($limitsMinimalConfig->getHeight(), LimitsMinimalConfig::DEFAULT_HEIGHT);
    }
}