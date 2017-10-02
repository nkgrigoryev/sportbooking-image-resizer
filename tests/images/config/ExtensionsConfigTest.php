<?php

use PHPUnit\Framework\TestCase;
use sportbooking\images\config\ExtensionsConfig;

class ExtensionsConfigTest extends TestCase
{
    public function testTrue()
    {
        $config = ['jpg', 'png'];
        $extensionsConfig = new ExtensionsConfig($config);
        $this->assertTrue($extensionsConfig->extensionIsValid('jpg'));
    }

    public function testFalse()
    {
        $config = ['jpg'];
        $extensionsConfig = new ExtensionsConfig($config);
        $this->assertFalse($extensionsConfig->extensionIsValid('png'));
    }
}