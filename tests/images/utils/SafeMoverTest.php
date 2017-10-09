<?php

use PHPUnit\Framework\TestCase;
use sportbooking\images\utils\SafeMover;

class SafeMoverTest extends TestCase
{
    public function testMoveResultFalse()
    {
        $source = __DIR__ . '/assets/source-is-not-exist.txt';
        $target = __DIR__ . '/assets/target.txt';
        $this->removeTargetFile($target);
        $moveResult = SafeMover::move($source, $target);
        $this->assertFalse($moveResult);
    }

    public function testMoveFileFail()
    {
        $source = __DIR__ . '/assets/source-is-not-exist.txt';
        $target = __DIR__ . '/assets/target.txt';
        $this->removeTargetFile($target);
        SafeMover::move($source, $target);
        $this->assertFalse(is_file($target));
    }

    private function createSourceFile(string $source)
    {
        if (file_exists($source)) return;
        $file = fopen($source, 'w');
        fwrite($file, 'test');
    }

    private function removeTargetFile(string $target)
    {
        if (!file_exists($target)) return;
        unlink($target);
    }
}