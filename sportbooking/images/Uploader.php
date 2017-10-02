<?php

namespace sportbooking\images;
use sportbooking\images\config\Config;
use sportbooking\images\interfaces\ImageDataInterface;
use sportbooking\images\utils\interfaces\MoverInterface;
use sportbooking\images\utils\SafeMover;

/**
 * Class ImagesUploader
 * @package sportbooking\images
 */
class Uploader
{
    // TODO example of config and files
    /**
     * Uploader constructor.
     * @param array $config
     * @param array $files
     * @param MoverInterface|null $mover
     */
    public function __construct
    (
        array $config,
        array $files,
        MoverInterface $mover = null
    )
    {
        $configObject = new Config($config);
        $mover = $mover ?? new SafeMover();
        $this->_saver = new ImagesSaver($configObject, $files, $mover);
    }

    /**
     * Save images into base directory. Return true if saved successful.
     * @return bool
     */
    public function upload():bool
    {
        return $this->_saver->save();
    }

    /**
     * Return images length.
     * @return int Example:
     *     3
     */
    public function getImagesLength():int
    {
        return $this->_saver->getImagesLength();
    }

    /**
     * Return ImageDataInterface object.
     * @param int $index No mew then getImagesLength(). Example:
     *     0
     * @return ImageDataInterface
     */
    public function getImageData(int $index):ImageDataInterface
    {
        return $this->_saver->getImageData($index);
    }

    // TODO test this
    /**
     * @return array
     */
    public function getImagesDataInArray():array
    {
        $result = [];
        for ($i = 0; $i < $this->_saver->getImagesLength(); $i++)
        {
            $saver = $this->_saver->getImageData($i);
            $data =
            [
                'name' => $saver->getName(),
                'path' => $saver->getRelativePath(),
                'type' => $saver->getType(),
                'width' => $saver->getWidth(),
                'height' => $saver->getHeight(),
                'size' => $saver->getSize()
            ];
            array_push($result, $data);
        }
        return $result;
    }
}
