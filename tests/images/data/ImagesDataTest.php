<?php

use PHPUnit\Framework\Error\Notice;
use PHPUnit\Framework\TestCase;
use sportbooking\images\data\ImagesData;

class ImagesDataTest extends TestCase
{
    public function testCrash()
    {
        $this->copyImages();
        $files =
        [
            'name' =>
            [
                '01_3200x1800.jpg',
                '02_3200x1800.jpg'
            ],
            'type' =>
            [
                'image/jpg'
            ],
            'tmp_name' =>
            [
                __DIR__ . '/../assets/images/tmp/01_3200x1800.jpg'
            ],
            'error' =>
            [
                0
            ]
        ];
        $this->expectException(Notice::class);
        new ImagesData($files);
    }

    public function testImagesDataInArray()
    {
        $this->copyImages();
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
                __DIR__ . '/../assets/images/tmp/01_3200x1800.jpg',
                __DIR__ . '/../assets/images/tmp/02_3200x1800.jpg',
                __DIR__ . '/../assets/images/tmp/03_3200x1800.jpg'
            ],
            'error' =>
            [
                0,
                0,
                0
            ]
        ];
        $imagesData = new ImagesData($files);
        $result = $imagesData->getImagesDataInArray();
        $this->assertEquals('01_3200x1800.jpg', $result[0]['name']);
        $this->assertEquals('02_3200x1800.jpg', $result[1]['name']);
        $this->assertEquals('03_3200x1800.jpg', $result[2]['name']);
        $this->assertEquals('image/jpg', $result[0]['type']);
        $this->assertEquals('image/jpg', $result[1]['type']);
        $this->assertEquals('image/jpg', $result[2]['type']);
        $this->assertEquals(3200, $result[2]['width']);
        $this->assertEquals(3200, $result[2]['width']);
        $this->assertEquals(3200, $result[2]['width']);
        $this->assertEquals(1800, $result[0]['height']);
        $this->assertEquals(1800, $result[1]['height']);
        $this->assertEquals(1800, $result[2]['height']);
        $this->assertEquals(1608113, $result[0]['size']);
        $this->assertEquals(1117776, $result[1]['size']);
        $this->assertEquals(784306, $result[2]['size']);
        $this->assertEquals(0, $result[0]['key']);
        $this->assertEquals(1, $result[1]['key']);
        $this->assertEquals(2, $result[2]['key']);
    }

    public function testLength()
    {
        $this->copyImages();
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
                __DIR__ . '/../assets/images/tmp/01_3200x1800.jpg',
                __DIR__ . '/../assets/images/tmp/02_3200x1800.jpg',
                __DIR__ . '/../assets/images/tmp/03_3200x1800.jpg'
            ],
            'error' =>
            [
                0,
                0,
                0
            ]
        ];
        $imagesData = new ImagesData($files);
        $this->assertEquals(3, $imagesData->getLength());
    }

    public function testKeys()
    {
        $this->copyImages();
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
                __DIR__ . '/../assets/images/tmp/01_3200x1800.jpg',
                __DIR__ . '/../assets/images/tmp/02_3200x1800.jpg',
                __DIR__ . '/../assets/images/tmp/03_3200x1800.jpg'
            ],
            'error' =>
            [
                0,
                0,
                0
            ]
        ];
        $imagesData = new ImagesData($files);
        $this->assertEquals([0, 1, 2], $imagesData->getKeys());
    }

    public function testGetImageDataByKey()
    {
        $this->copyImages();
        $files =
        [
            'name' =>
            [
                '01_3200x1800.jpg',
                'logo' => '02_3200x1800.jpg'
            ],
            'type' =>
            [
                'image/jpg',
                'logo' => 'image/jpg',
            ],
            'tmp_name' =>
            [
                __DIR__ . '/../assets/images/tmp/01_3200x1800.jpg',
                'logo' => __DIR__ . '/../assets/images/tmp/02_3200x1800.jpg',
            ],
            'error' =>
            [
                0,
                'logo' => 0,
            ]
        ];
        $imagesData = new ImagesData($files);
        $firstImageData = $imagesData->getImageDataByKey(0);
        $logoImageData = $imagesData->getImageDataByKey('logo');

        $this->assertEquals('01_3200x1800.jpg', $firstImageData->getName());
        $this->assertEquals('02_3200x1800.jpg', $logoImageData->getName());
        $this->assertEquals('image/jpg', $firstImageData->getType());
        $this->assertEquals('image/jpg', $logoImageData->getType());
        $this->assertEquals(3200, $firstImageData->getWidth());
        $this->assertEquals(3200, $logoImageData->getWidth());
        $this->assertEquals(1800, $firstImageData->getHeight());
        $this->assertEquals(1800, $logoImageData->getHeight());
        $this->assertEquals(1608113, $firstImageData->getSize());
        $this->assertEquals(1117776, $logoImageData->getSize());
        $this->assertEquals(0, $firstImageData->getKey());
        $this->assertEquals('logo', $logoImageData->getKey());
    }

    private function copyImages()
    {
        copy(__DIR__ . '/../assets/images/01_3200x1800.jpg',__DIR__ . '/../assets/images/tmp/01_3200x1800.jpg');
        copy(__DIR__ . '/../assets/images/02_3200x1800.jpg',__DIR__ . '/../assets/images/tmp/02_3200x1800.jpg');
        copy(__DIR__ . '/../assets/images/03_3200x1800.jpg',__DIR__ . '/../assets/images/tmp/03_3200x1800.jpg');
    }
}