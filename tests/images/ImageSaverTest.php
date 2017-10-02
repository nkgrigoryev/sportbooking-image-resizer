<?php

use PHPUnit\Framework\TestCase;
use sportbooking\images\config\Config;
use sportbooking\images\config\exceptions\InvalidImageExtensionException;
use sportbooking\images\exceptions\ImageTooBigInBytesException;
use sportbooking\images\exceptions\ImageTooBigInPixelsException;
use sportbooking\images\exceptions\ImageTooSmallInBytesException;
use sportbooking\images\exceptions\ImageTooSmallInPixelsException;
use sportbooking\images\exceptions\InvalidImageException;
use sportbooking\images\exceptions\PHPUploadErrorException;
use sportbooking\images\ImageSaver;
use sportbooking\images\utils\UnsafeMover;

class ImageSaverTest extends TestCase
{
    public function testPHPUploadErrorException()
    {
        $this->copyImages();
        $config =
        [
            'baseDirectory' => __DIR__ . '/assets/upload'
        ];
        $config = new Config($config);
        $this->expectException(PHPUploadErrorException::class);
        new ImageSaver
        (
            $config,
            new UnsafeMover(),
            '256x256.png',
            'image/png',
            __DIR__ . '/assets/images/tmp/256x256.png',
            1
        );
    }

    public function testInvalidImageExtensionException()
    {
        $this->copyImages();
        $config =
        [
            'extensions' =>
            [
                'jpg',
                'gif'
            ],
            'baseDirectory' => __DIR__ . '/assets/upload'
        ];
        $config = new Config($config);
        $this->expectException(InvalidImageExtensionException::class);
        new ImageSaver
        (
            $config,
            new UnsafeMover(),
            '256x256.png',
            'image/png',
            __DIR__ . '/assets/images/tmp/256x256.png',
            0
        );
    }

    public function testInvalidImageException()
    {
        $this->copyImages();
        $config =
        [
            'extensions' =>
            [
                'png'
            ],
            'baseDirectory' => __DIR__ . '/assets/upload'
        ];
        $config = new Config($config);
        $this->expectException(InvalidImageException::class);
        new ImageSaver
        (
            $config,
            new UnsafeMover(),
            'invalid_image.png',
            'image/png',
            __DIR__ . '/assets/images/tmp/invalid_image.png',
            0
        );
    }

    public function testImageTooBigInPixelsException()
    {
        $this->copyImages();
        $config =
        [
            'extensions' =>
            [
                'png'
            ],
            'maximal' =>
            [
                'width' => 32,
                'height' => 32
            ],
            'baseDirectory' => __DIR__ . '/assets/upload'
        ];
        $config = new Config($config);
        $this->expectException(ImageTooBigInPixelsException::class);
        new ImageSaver
        (
            $config,
            new UnsafeMover(),
            '256x256.png',
            'image/png',
            __DIR__ . '/assets/images/tmp/256x256.png',
            0
        );
    }

    public function testImageTooBigInBytesException()
    {
        $this->copyImages();
        $config =
        [
            'extensions' =>
            [
                'png'
            ],
            'maximal' =>
            [
                'size' => 1024
            ],
            'baseDirectory' => __DIR__ . '/assets/upload'
        ];
        $config = new Config($config);
        $this->expectException(ImageTooBigInBytesException::class);
        new ImageSaver
        (
            $config,
            new UnsafeMover(),
            '256x256.png',
            'image/png',
            __DIR__ . '/assets/images/tmp/256x256.png',
            0
        );
    }

    public function testImageTooSmallInPixelsException()
    {
        $this->copyImages();
        $config =
        [
            'extensions' =>
            [
                'png'
            ],
            'minimal' =>
            [
                'width' => 512,
                'height' => 512
            ],
            'baseDirectory' => __DIR__ . '/assets/upload'
        ];
        $config = new Config($config);
        $this->expectException(ImageTooSmallInPixelsException::class);
        new ImageSaver
        (
            $config,
            new UnsafeMover(),
            '256x256.png',
            'image/png',
            __DIR__ . '/assets/images/tmp/256x256.png',
            0
        );
    }

    public function testImageTooSmallInBytesException()
    {
        $this->copyImages();
        $config =
        [
            'extensions' =>
            [
                'png'
            ],
            'minimal' =>
            [
                'size' => 1024 * 1024
            ],
            'baseDirectory' => __DIR__ . '/assets/upload'
        ];
        $config = new Config($config);
        $this->expectException(ImageTooSmallInBytesException::class);
        new ImageSaver
        (
            $config,
            new UnsafeMover(),
            '256x256.png',
            'image/png',
            __DIR__ . '/assets/images/tmp/256x256.png',
            0
        );
    }

    public function testParameters()
    {
        $this->copyImages();
        $config =
        [
            'extensions' =>
            [
                'png'
            ],
            'baseDirectory' => __DIR__ . '/assets/upload'
        ];
        $config = new Config($config);
        $imageSaver = new ImageSaver
        (
            $config,
            new UnsafeMover(),
            '256x256.png',
            'image/png',
            __DIR__ . '/assets/images/tmp/256x256.png',
            0
        );
        $this->assertEquals($imageSaver->getName(), '256x256.png');
        $this->assertEquals($imageSaver->getType(), 'image/png');
        $this->assertEquals($imageSaver->getWidth(), 256);
        $this->assertEquals($imageSaver->getHeight(), 256);
        $this->assertEquals($imageSaver->getSize(), 76949);
    }

    public function testTrue()
    {
        $this->copyImages();
        $config =
        [
            'extensions' =>
            [
                'png'
            ],
            'baseDirectory' => __DIR__ . '/assets/upload'
        ];
        $config = new Config($config);
        $imageSaver = new ImageSaver
        (
            $config,
            new UnsafeMover(),
            '256x256.png',
            'image/png',
            __DIR__ . '/assets/images/tmp/256x256.png',
            0
        );
        $result = $imageSaver->save();
        $this->assertTrue($result);
        $this->assertTrue(is_file($config->getBaseDirectory() . $imageSaver->getRelativePath()));
    }

    private function copyImages()
    {
        copy(__DIR__ . '/assets/images/256x256.png',__DIR__ . '/assets/images/tmp/256x256.png');
        copy(__DIR__ . '/assets/images/invalid_image.png',__DIR__ . '/assets/images/tmp/invalid_image.png');
    }
}