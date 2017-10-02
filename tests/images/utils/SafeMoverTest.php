<?php

use PHPUnit\Framework\TestCase;
use sportbooking\images\utils\SafeMover;

class SafeMoverTest extends TestCase
{
    public function testFalse()
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
        $moveResult = SafeMover::move($file, $target);
        $this->assertFalse($moveResult);
        $this->assertFalse(is_file($target));
    }
}