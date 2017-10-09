<?php

use PHPUnit\Framework\TestCase;
use sportbooking\images\config\LimitsMinimalConfig;

class LimitsMinimalConfigTest extends TestCase
{
    public function testDefaultSize()
    {
        $config = [];
        $limitsMinimalConfig = new LimitsMinimalConfig($config);
        $this->assertEquals($limitsMinimalConfig->getSize(), LimitsMinimalConfig::DEFAULT_SIZE);
    }

    public function testDefaultWidth()
    {
        $config = [];
        $limitsMinimalConfig = new LimitsMinimalConfig($config);
        $this->assertEquals($limitsMinimalConfig->getWidth(), LimitsMinimalConfig::DEFAULT_WIDTH);
    }

    public function testDefaultHeight()
    {
        $config = [];
        $limitsMinimalConfig = new LimitsMinimalConfig($config);
        $this->assertEquals($limitsMinimalConfig->getWidth(), LimitsMinimalConfig::DEFAULT_WIDTH);
    }
}