<?php

use PHPUnit\Framework\TestCase;
use sportbooking\images\config\LimitsMaximalConfig;

class LimitsMaximalConfigTest extends TestCase
{
    public function testFullConfig()
    {
        $config =
        [
            'size' => 50000,
            'width' => 100,
            'height' => 200
        ];
        $limitsMinimalConfig = new LimitsMaximalConfig($config);
        $this->assertEquals($limitsMinimalConfig->getSize(), 50000);
        $this->assertEquals($limitsMinimalConfig->getWidth(), 100);
        $this->assertEquals($limitsMinimalConfig->getHeight(), 200);
    }

    public function testEmptyConfig()
    {
        $config = [];
        $limitsMinimalConfig = new LimitsMaximalConfig($config);
        $this->assertEquals($limitsMinimalConfig->getSize(), LimitsMaximalConfig::DEFAULT_SIZE);
        $this->assertEquals($limitsMinimalConfig->getWidth(), LimitsMaximalConfig::DEFAULT_WIDTH);
        $this->assertEquals($limitsMinimalConfig->getHeight(), LimitsMaximalConfig::DEFAULT_HEIGHT);
    }
}