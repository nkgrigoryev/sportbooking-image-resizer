<?php

use PHPUnit\Framework\TestCase;
use sportbooking\images\utils\UnsafeMover;

class UnsafeMoverTest extends TestCase
{
    public function testTrue()
    {
        $file = __DIR__ . '/assets/file.txt';
        $target = __DIR__ . '/assets/file-moved.txt';
        if (!file_exists($file))
        {
            $openedFile = fopen($file, 'w');
            fwrite($openedFile, 'test');
        }
        if (file_exists($target))
        {
            unlink($target);
        }
        $moveResult = UnsafeMover::move($file, $target);
        $this->assertTrue($moveResult);
        $this->assertTrue(is_file($target));
    }

    public function testFalse()
    {
        $file = __DIR__ . '/assets/file-not-exist.txt';
        $target = __DIR__ . '/assets/file-moved.txt';
        if (file_exists($target))
        {
            unlink($target);
        }
        $moveResult = UnsafeMover::move($file, $target);
        $this->assertFalse($moveResult);
        $this->assertFalse(is_file($target));
    }
}