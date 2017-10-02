<?php

use PHPUnit\Framework\TestCase;
use sportbooking\images\Uploader;
use sportbooking\images\utils\UnsafeMover;

class UploaderTest extends TestCase
{
    public function testSuccessUpload()
    {
        $this->copyImages();
        $baseDirectory = __DIR__ . '/assets/upload';
        $config =
        [
            'extensions' =>
            [
                'jpg'
            ],
            'baseDirectory' => $baseDirectory
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
        $uploader = new Uploader
        (
            $config,
            $files,
            new UnsafeMover()
        );
        $uploader->upload();
        $this->assertTrue(is_file($baseDirectory . $uploader->getImageData(0)->getRelativePath()));
        $this->assertTrue(is_file($baseDirectory . $uploader->getImageData(1)->getRelativePath()));
        $this->assertTrue(is_file($baseDirectory . $uploader->getImageData(2)->getRelativePath()));
        $this->assertEquals(3, $uploader->getImagesLength());
    }

    public function testImagesDataInArray()
    {
        $this->copyImages();
        $baseDirectory = __DIR__ . '/assets/upload';
        $config =
        [
            'extensions' =>
            [
                'jpg',
                'png'
            ],
            'baseDirectory' => $baseDirectory
        ];
        $files =
        [
            'name' =>
            [
                '01_3200x1800.jpg',
                '256x256.png'
            ],
            'type' =>
            [
                'image/jpg',
                'image/png'
            ],
             'tmp_name' =>
            [
                __DIR__ . '/assets/images/tmp/01_3200x1800.jpg',
                __DIR__ . '/assets/images/tmp/256x256.png'
            ],
            'error' =>
            [
                0,
                0
            ]
        ];
        $uploader = new Uploader
        (
            $config,
            $files,
            new UnsafeMover()
        );
        $data = $uploader->getImagesDataInArray();
        $imageOneData = $data[0];
        $this->assertEquals('01_3200x1800.jpg', $imageOneData['name']);
        $this->assertEquals('image/jpg', $imageOneData['type']);
        $this->assertEquals(3200, $imageOneData['width']);
        $this->assertEquals(1800, $imageOneData['height']);
        $this->assertEquals(1608113, $imageOneData['size']);

        $imageTwoData = $data[1];
        $this->assertEquals('256x256.png', $imageTwoData['name']);
        $this->assertEquals('image/png', $imageTwoData['type']);
        $this->assertEquals(256, $imageTwoData['width']);
        $this->assertEquals(256, $imageTwoData['height']);
        $this->assertEquals(76949, $imageTwoData['size']);
    }

    private function copyImages()
    {
        copy(__DIR__ . '/assets/images/01_3200x1800.jpg',__DIR__ . '/assets/images/tmp/01_3200x1800.jpg');
        copy(__DIR__ . '/assets/images/02_3200x1800.jpg',__DIR__ . '/assets/images/tmp/02_3200x1800.jpg');
        copy(__DIR__ . '/assets/images/03_3200x1800.jpg',__DIR__ . '/assets/images/tmp/03_3200x1800.jpg');
        copy(__DIR__ . '/assets/images/256x256.png',__DIR__ . '/assets/images/tmp/256x256.png');
    }
}