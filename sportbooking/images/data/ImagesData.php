<?php

namespace sportbooking\images\data;

/**
 * Class ImagesData
 * @package sportbooking\images\data
 */
class ImagesData
{
    /**
     * @var array
     */
    private $_keys = [];

    /**
     * @var string
     */
    private $_length = 0;

    /**
     * @var array
     */
    private $_images = [];

    /**
     * ImagesData constructor.
     * @param array $files Example:
     *     [
     *         'name' =>
     *         [
     *             '01_3200x1800.jpg',
     *             '02_3200x1800.jpg',
     *             '03_3200x1800.jpg'
     *         ],
     *         'type' =>
     *         [
     *             'image/jpg',
     *             'image/jpg',
     *             'image/jpg'
     *         ],
     *          'tmp_name' =>
     *         [
     *             __DIR__ . '/assets/images/tmp/01_3200x1800.jpg',
     *             __DIR__ . '/assets/images/tmp/02_3200x1800.jpg',
     *             __DIR__ . '/assets/images/tmp/03_3200x1800.jpg'
     *         ],
     *         'error' =>
     *         [
     *             0,
     *             0,
     *             0
     *         ]
     *     ];
     */
    public function __construct
    (
        array $files
    )
    {
        $names = $files['name'] ?? [];
        $types = $files['type'] ?? [];
        $temporaryNames = $files['tmp_name'] ?? [];
        $errors = $files['error'] ?? [];
        foreach ($names as $key => $value)
        {
            $name = $names[$key];
            $type = $types[$key];
            $temporaryName = $temporaryNames[$key];
            $error = $errors[$key];
            $imageData = new ImageData($name, $type, $temporaryName, $error, $key);
            array_push($this->_keys, $key);
            $this->_images[$key] = $imageData;
            $this->_length++;
        }
    }

    /**
     * Return keys.
     * @return array Example:
     *     [0, 1, 'logo']
     */
    public function getKeys():array
    {
        return $this->_keys;
    }

    /**
     * Return images length.
     * @return int Example:
     *     3
     */
    public function getLength():int
    {
        return $this->_length;
    }

    /**
     * Return ImageDataInterface object.
     * @param int|string $key No mew then getImagesLength(). Example:
     *     0
     *
     *     'avatar'
     * @return ImageData
     */
    public function getImageDataByKey($key):ImageData
    {
        return $this->_images[$key];
    }

    /**
     * @return array Example:
     *     [
     *         [
     *             'name' => '01_3200x1800.jpg',
     *             'path' => '/19/03/bad54061ffc0fd68f11cc9a84b83_original.jpg',
     *             'type' => 'image/jpg',
     *             'width' => 3200,
     *             'height' => 1800,
     *             'size' => 1608113
     *         ],
     *         [
     *             'name' => '02_3200x1800.jpg',
     *             'path' => '/5f/2c/2b537eb93beec143b35aef6119f5_original.jpg',
     *             'type' => 'image/jpg',
     *             'width' => 3200,
     *             'height' => 1800,
     *             'size' => 1117776
     *         ]
     *     ]
     */
    public function getImagesDataInArray():array
    {
        $result = [];
        for ($i = 0; $i < $this->_length; $i++)
        {
            $key = $this->_keys[$i];
            $imageData = $this->getImageDataByKey($key);
            $data =
            [
                'name' => $imageData->getName(),
                'path' => $imageData->getRelativePath(),
                'type' => $imageData->getType(),
                'width' => $imageData->getWidth(),
                'height' => $imageData->getHeight(),
                'size' => $imageData->getSize(),
                'key' => $imageData->getKey()
            ];
            $result[$key] = $data;
        }
        return $result;
    }
}