<?php

namespace sportbooking\images;
use sportbooking\images\config\Config;
use sportbooking\images\exceptions\InvalidInputDataException;
use sportbooking\images\exceptions\MaximalQuantityException;
use sportbooking\images\exceptions\NoImagesException;
use sportbooking\images\interfaces\ImageDataInterface;
use sportbooking\images\utils\interfaces\MoverInterface;

/**
 * Class ImagesSaver
 * @package sportbooking\images
 */
class ImagesSaver
{
    /**
     * @var ImageSaver[]
     */
    private $_savers = [];

    /**
     * @var int
     */
    private $_saversCount;

    /**
     * ImagesSaver constructor.
     * @param Config $config Config object.
     * @param array $files Example:
     *     [
     *         'name' =>
     *         [
     *             'firefox_3.5_logo_256x256.png',
     *             'wallpaper.jpg'
     *         ],
     *         'type' =>
     *         [
     *             'image/png',
     *             'image/jpg'
     *         ],
     *         'tmp_name' =>
     *         [
     *             __DIR__ . '/assets/images/firefox_3.5_logo_256x256.png',
     *             __DIR__ . '/assets/images/01_3200x1800.jpg'
     *         ],
     *         'error' =>
     *         [
     *             0,
     *             0
     *         ]
     *     ]
     * @param MoverInterface $mover Use SafeMover for production and UnsafeMover for tests.
     * @throws NoImagesException
     * @throws MaximalQuantityException
     */
    public function __construct
    (
        Config $config,
        array $files,
        MoverInterface $mover
    )
    {
        // TODO test for files with text keys
        // TODO test single file
        if (!isset($files['name'])) throw new NoImagesException();
        $filesCount = count($files['name']);
        if ($filesCount > $config->getMaximalQuantity()) throw new MaximalQuantityException();

        // TODO refactoring
        if (is_string($files['name']))
        {
            $name = $files['name'];
            $type = $files['type'];
            $temporaryName = $files['tmp_name'];
            $error = $files['error'];
            $saver = new ImageSaver
            (
                $config,
                $mover,
                $name,
                $type,
                $temporaryName,
                $error
            );
            array_push($this->_savers, $saver);
        }
        else
        {
            foreach ($files['name'] as $key => $value)
            {
                // TODO test on this exception
                if (!is_string($value) && !is_numeric($value)) throw new InvalidInputDataException();
                $name = $files['name'][$key];
                $type = $files['type'][$key];
                $temporaryName = $files['tmp_name'][$key];
                $error = $files['error'][$key];
                $saver = new ImageSaver
                (
                    $config,
                    $mover,
                    $name,
                    $type,
                    $temporaryName,
                    $error
                );
                array_push($this->_savers, $saver);
            }
        }
        $this->_saversCount = $filesCount;
    }

    /**
     * Save images into base directory. Return true if saved successful.
     * @return bool
     */
    public function save():bool
    {
        $saversCount = count($this->_savers);
        for ($i = 0; $i < $saversCount; $i++)
        {
            $saver = $this->_savers[$i];
            $result = $saver->save();
            if (!$result) return false;
        }
        return true;
    }

    /**
     * Return images length.
     * @return int Example:
     *     3
     */
    public function getImagesLength():int
    {
        return $this->_saversCount;
    }

    /**
     * Return ImageDataInterface object.
     * @param int $index No mew then getImagesLength(). Example:
     *     0
     * @return ImageDataInterface
     */
    public function getImageData(int $index):ImageDataInterface
    {
        return $this->_savers[$index];
    }
}