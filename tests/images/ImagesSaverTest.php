<?php

use PHPUnit\Framework\TestCase;
use sportbooking\images\config\Config;
use sportbooking\images\exceptions\MaximalQuantityException;
use sportbooking\images\exceptions\NoImagesException;
use sportbooking\images\ImagesSaver;
use sportbooking\images\utils\UnsafeMover;

class ImagesSaverTest extends TestCase
{
    public function testNoImagesException()
    {
        $this->copyImages();
        $config =
        [
            'extensions' =>
            [
                'jpg'
            ],
            'baseDirectory' => __DIR__ . '/assets/upload'
        ];
        $files = [];
        $config = new Config($config);
        $this->expectException(NoImagesException::class);
        new ImagesSaver
        (
            $config,
            $files,
            new UnsafeMover()
        );
    }

    public function testMaximalQuantityException()
    {
        $this->copyImages();
        $config =
        [
            'maximalQuantity' => 2,
            'extensions' =>
            [
                'jpg'
            ],
            'baseDirectory' => __DIR__ . '/assets/upload'
        ];
        $files =
        [
            'name' =>
            [
                '01_3200x1800.jpg',
                '02_3200x1800.jpg',
                '03_3200x1800.jpg'
            ],
            'type' =>
            [
                'image/jpg',
                'image/jpg',
                'image/jpg'
            ],
             'tmp_name' =>
            [
                __DIR__ . '/assets/images/tmp/01_3200x1800.jpg',
                __DIR__ . '/assets/images/tmp/02_3200x1800.jpg',
                __DIR__ . '/assets/images/tmp/03_3200x1800.jpg'
            ],
            'error' =>
            [
                0,
                0,
                0
            ]
        ];
        $config = new Config($config);
        $this->expectException(MaximalQuantityException::class);
        new ImagesSaver
        (
            $config,
            $files,
            new UnsafeMover()
        );
    }

    public function testTrue()
    {
        $this->copyImages();
        $config =
        [
            'extensions' =>
            [
                'jpg'
            ],
            'baseDirectory' => __DIR__ . '/assets/upload'
        ];
        $files =
        [
            'name' =>
            [
                '01_3200x1800.jpg',
                '02_3200x1800.jpg',
                '03_3200x1800.jpg'
            ],
            'type' =>
            [
                'image/jpg',
                'image/jpg',
                'image/jpg'
            ],
             'tmp_name' =>
            [
                __DIR__ . '/assets/images/tmp/01_3200x1800.jpg',
                __DIR__ . '/assets/images/tmp/02_3200x1800.jpg',
                __DIR__ . '/assets/images/tmp/03_3200x1800.jpg'
            ],
            'error' =>
            [
                0,
                0,
                0
            ]
        ];
        $config = new Config($config);
        $imagesSaver = new ImagesSaver
        (
            $config,
            $files,
            new UnsafeMover()
        );
        $result = $imagesSaver->save();
        $this->assertTrue($result);
        $this->assertTrue(is_file($config->getBaseDirectory() . $imagesSaver->getImageData(0)->getRelativePath()));
        $this->assertTrue(is_file($config->getBaseDirectory() . $imagesSaver->getImageData(1)->getRelativePath()));
        $this->assertTrue(is_file($config->getBaseDirectory() . $imagesSaver->getImageData(2)->getRelativePath()));
        $this->assertEquals(3, $imagesSaver->getImagesLength());
    }

    private function copyImages()
    {
        copy(__DIR__ . '/assets/images/01_3200x1800.jpg',__DIR__ . '/assets/images/tmp/01_3200x1800.jpg');
        copy(__DIR__ . '/assets/images/02_3200x1800.jpg',__DIR__ . '/assets/images/tmp/02_3200x1800.jpg');
        copy(__DIR__ . '/assets/images/03_3200x1800.jpg',__DIR__ . '/assets/images/tmp/03_3200x1800.jpg');
    }
}