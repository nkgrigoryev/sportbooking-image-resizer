<?php

use PHPUnit\Framework\TestCase;
use sportbooking\images\config\LimitsMaximalConfig;

class LimitsMaximalConfigTest extends TestCase
{
    public function testDefaultSize()
    {
        $config = [];
        $limitsMinimalConfig = new LimitsMaximalConfig($config);
        $this->assertEquals($limitsMinimalConfig->getSize(), LimitsMaximalConfig::DEFAULT_SIZE);
    }

    public function testDefaultWidth()
    {
        $config = [];
        $limitsMinimalConfig = new LimitsMaximalConfig($config);
        $this->assertEquals($limitsMinimalConfig->getWidth(), LimitsMaximalConfig::DEFAULT_WIDTH);
    }

    public function testDefaultHeight()
    {
        $config = [];
        $limitsMinimalConfig = new LimitsMaximalConfig($config);
        $this->assertEquals($limitsMinimalConfig->getWidth(), LimitsMaximalConfig::DEFAULT_WIDTH);
    }
}