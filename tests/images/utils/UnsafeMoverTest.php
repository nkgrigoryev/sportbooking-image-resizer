<?php

use PHPUnit\Framework\TestCase;
use sportbooking\images\utils\UnsafeMover;

class UnsafeMoverTest extends TestCase
{
    public function testMoveResultTrue()
    {
        $source = __DIR__ . '/assets/source.txt';
        $target = __DIR__ . '/assets/target.txt';
        $this->createSourceFile($source);
        $this->removeTargetFile($target);
        $moveResult = UnsafeMover::move($source, $target);
        $this->assertTrue($moveResult);
    }

    public function testMoveFileSuccess()
    {
        $source = __DIR__ . '/assets/source.txt';
        $target = __DIR__ . '/assets/target.txt';
        $this->createSourceFile($source);
        $this->removeTargetFile($target);
        UnsafeMover::move($source, $target);
        $this->assertTrue(is_file($target));
    }

    public function testMoveResultFalse()
    {
        $source = __DIR__ . '/assets/source-is-not-exist.txt';
        $target = __DIR__ . '/assets/target.txt';
        $this->removeTargetFile($target);
        $moveResult = UnsafeMover::move($source, $target);
        $this->assertFalse($moveResult);
    }

    public function testMoveFileFail()
    {
        $source = __DIR__ . '/assets/source-is-not-exist.txt';
        $target = __DIR__ . '/assets/target.txt';
        $this->removeTargetFile($target);
        UnsafeMover::move($source, $target);
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