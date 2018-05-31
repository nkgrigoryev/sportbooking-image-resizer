<?php

use PHPUnit\Framework\TestCase;
use sportbooking\images\data\exceptions\InvalidImageException;
use sportbooking\images\data\exceptions\NoImageExtensionException;
use sportbooking\images\data\exceptions\PHPUploadErrorException;
use sportbooking\images\data\ImageData;

class ImageDataTest extends TestCase
{
    public function testPHPUploadErrorException()
    {
        $this->copyImages();
        $this->expectException(PHPUploadErrorException::class);
        new ImageData
        (
            '256x256.png',
            'image/png',
            __DIR__ . '/../assets/images/tmp/256x256.png',
            1,
            'logo'
        );
    }

    public function testInvalidImageException()
    {
        $this->copyImages();
        $this->expectException(InvalidImageException::class);
        new ImageData
        (
            '256x256.png',
            'image/png',
            __DIR__ . '/../assets/images/tmp/invalid_image.png',
            0,
            'logo'
        );
    }

    public function testNoImageExtensionException()
    {
        $this->copyImages();
        $this->expectException(NoImageExtensionException::class);
        new ImageData
        (
            '256x256',
            'image/png',
            __DIR__ . '/../assets/images/tmp/256x256.png',
            0,
            'logo'
        );
    }

    public function testName()
    {
        $name = '256x256.png';
        $this->copyImages();
        $imageData = new ImageData
        (
            $name,
            'image/png',
            __DIR__ . '/../assets/images/tmp/256x256.png',
            0,
            'logo'
        );
        $this->assertEquals($name, $imageData->getName());
    }

    public function testType()
    {
        $type = 'image/png';
        $this->copyImages();
        $imageData = new ImageData
        (
            '256x256.png',
            $type,
            __DIR__ . '/../assets/images/tmp/256x256.png',
            0,
            'logo'
        );
        $this->assertEquals($type, $imageData->getType());
    }

    public function testKey()
    {
        $key = 'logo';
        $this->copyImages();
        $imageData = new ImageData
        (
            '256x256.png',
            'image/png',
            __DIR__ . '/../assets/images/tmp/256x256.png',
            0,
            $key
        );
        $this->assertEquals($key, $imageData->getKey());
    }

    public function testWidth()
    {
        $this->copyImages();
        $imageData = new ImageData
        (
            '256x256.png',
            'image/png',
            __DIR__ . '/../assets/images/tmp/256x256.png',
            0,
            'logo'
        );
        $this->assertEquals(256, $imageData->getWidth());
    }

    public function testHeight()
    {
        $this->copyImages();
        $imageData = new ImageData
        (
            '256x256.png',
            'image/png',
            __DIR__ . '/../assets/images/tmp/256x256.png',
            0,
            'logo'
        );
        $this->assertEquals(256, $imageData->getHeight());
    }

    public function testSize()
    {
        $this->copyImages();
        $imageData = new ImageData
        (
            '256x256.png',
            'image/png',
            __DIR__ . '/../assets/images/tmp/256x256.png',
            0,
            'logo'
        );
        $this->assertEquals(76949, $imageData->getSize());
    }

    public function testExtension()
    {
        $this->copyImages();
        $imageData = new ImageData
        (
            '256x256.png',
            'image/png',
            __DIR__ . '/../assets/images/tmp/256x256.png',
            0,
            'logo'
        );
        $this->assertEquals('png', $imageData->getExtension());
    }

    private function copyImages()
    {
        copy(__DIR__ . '/../assets/images/256x256.png',__DIR__ . '/../assets/images/tmp/256x256.png');
        copy(__DIR__ . '/../assets/images/invalid_image.png',__DIR__ . '/../assets/images/tmp/invalid_image.png');
    }
}