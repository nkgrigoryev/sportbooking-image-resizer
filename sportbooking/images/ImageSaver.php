<?php

namespace sportbooking\images;
use Exception;
use Imagick;
use ImagickException;
use sportbooking\images\config\Config;
use sportbooking\images\config\exceptions\InvalidImageExtensionException;
use sportbooking\images\exceptions\ImageTooBigInBytesException;
use sportbooking\images\exceptions\ImageTooBigInPixelsException;
use sportbooking\images\exceptions\ImageTooSmallInBytesException;
use sportbooking\images\exceptions\ImageTooSmallInPixelsException;
use sportbooking\images\exceptions\InvalidImageException;
use sportbooking\images\exceptions\PHPUploadErrorException;
use sportbooking\images\interfaces\ImageDataInterface;
use sportbooking\images\utils\interfaces\MoverInterface;
use sportbooking\images\utils\SafeMover;

/**
 * Class ImageSaver
 * @package sportbooking\images
 */
class ImageSaver implements ImageDataInterface
{
    /**
     * @var int Random bytes length
     */
    const RANDOM_BYTES_FOR_HASH_LENGTH = 128;

    /**
     * @var Config
     */
    private $_config;

    /**
     * @var MoverInterface
     */
    private $_mover;

    /**
     * @var string
     */
    private $_name;

    /**
     * @var string
     */
    private $_type;

    /**
     * @var string
     */
    private $_temporaryName;

    /**
     * @var int
     */
    private $_error;

    /**
     * @var Imagick
     */
    private $_image;


    /**
     * @var int
     */
    private $_width;

    /**
     * @var int
     */
    private $_height;

    /**
     * @var int
     */
    private $_size;

    /**
     * @var string
     */
    private $_directoryFullPath;

    /**
     * @var string
     */
    private $_relativePath;

    /**
     * ImagesUploader constructor.
     * @param Config $config
     * @param MoverInterface $mover Example:
     *     new SafeMover();
     * @param string $name Example:
     *     'firefox_3.5_logo_256x256.png'
     * @param string $type Example:
     *     'image/png'
     * @param string $temporaryName Example:
     *     '/tmp/Xcd45'
     * @param int $error Example:
     *     0
     * @link http://www.php.net/manual/en/features.file-upload.errors.php
     * @see SafeMover, MoverInterface
     * @throws PHPUploadErrorException
     * @throws InvalidImageException
     * @throws ImageTooBigInPixelsException
     * @throws ImageTooBigInBytesException
     * @throws ImageTooSmallInPixelsException
     * @throws ImageTooSmallInBytesException
     */
    public function __construct
    (
        Config $config,
        MoverInterface $mover,
        string $name,
        string $type,
        string $temporaryName,
        int $error
    )
    {
        $this->_config = $config;
        $this->_mover = $mover;
        $this->_name = $name;
        $this->_type = $type;
        $this->_temporaryName = $temporaryName;
        $this->_error = $error;

        if ($this->_error != UPLOAD_ERR_OK) throw new PHPUploadErrorException();

        $extension = $this->_getExtension($this->_name);
        $this->_image = $this->_getImagickImage($this->_temporaryName);
        $this->_width = $this->_image->getImageWidth();
        $this->_height = $this->_image->getImageHeight();
        $this->_size = $this->_image->getImageLength();

        $limitsMaximal = $this->_config->getMaximal();
        $maximalWidth = $limitsMaximal->getWidth();
        $maximalHeight = $limitsMaximal->getHeight();
        $maximalSize = $limitsMaximal->getSize();
        $limitsMinimal = $this->_config->getMinimal();
        $minimalWidth = $limitsMinimal->getWidth();
        $minimalHeight = $limitsMinimal->getHeight();
        $minimalSize = $limitsMinimal->getSize();
        if ($this->_width > $maximalWidth || $this->_height > $maximalHeight) throw new ImageTooBigInPixelsException();
        if ($this->_size > $maximalSize) throw new ImageTooBigInBytesException();
        if ($this->_width < $minimalWidth || $this->_height < $minimalHeight) throw new ImageTooSmallInPixelsException();
        if ($this->_size < $minimalSize) throw new ImageTooSmallInBytesException();

        $hash = md5(openssl_random_pseudo_bytes(self::RANDOM_BYTES_FOR_HASH_LENGTH));
        $firstDirectory = substr($hash,0, 2);
        $secondDirectory = substr($hash,2, 2);
        $fileName = substr($hash,4);
        $this->_relativePath = '/' . $firstDirectory . '/' . $secondDirectory . '/' . $fileName . '_original.' . $extension;
        $this->_directoryFullPath = $this->_config->getBaseDirectory() . '/' . $firstDirectory . '/' . $secondDirectory;
    }

    /**
     * Save image into base directory. Return true if saved successful.
     * @return bool
     */
    public function save():bool
    {
        if (!is_dir($this->_directoryFullPath)) mkdir($this->_directoryFullPath, 0775, true);
        $fullTargetPath = $this->_config->getBaseDirectory() . $this->_relativePath;
        return $this->_mover::move($this->_temporaryName, $fullTargetPath);
    }

    /**
     * Return relative path.
     * @return string Example:
     *     '/f5/a7/662fdadf621df0151fd078247165_original.png'
     */
    public function getRelativePath():string
    {
        return $this->_relativePath;
    }

    /**
     * Return name.
     * @return string Example:
     *     'logo.png'
     */
    public function getName():string
    {
        return $this->_name;
    }

    /**
     * Return type.
     * @return string Example:
     *     'image/png'
     */
    public function getType():string
    {
        return $this->_type;
    }

    /**
     * Return width in pixels.
     * @return string Example:
     *     256
     */
    public function getWidth():string
    {
        return $this->_width;
    }

    /**
     * Return height in pixels.
     * @return string Example:
     *     256
     */
    public function getHeight():string
    {
        return $this->_height;
    }

    /**
     * Return size in bytes.
     * @return string Example:
     *     256
     */
    public function getSize():string
    {
        return $this->_size;
    }

    /**
     * Return Imagick object or throw exception.
     * @param string $path Example:
     *     'tmp/Xdd35'
     * @return Imagick
     * @throws InvalidImageException
     */
    private function _getImagickImage(string $path):Imagick
    {
        try
        {
            return new Imagick($path);
        }
        catch (ImagickException $exception)
        {
            throw new InvalidImageException();
        }
    }

    /**
     * Return file extension or throw exception.
     * @param string $name Example:
     *     'firefox_3.5_logo_256x256.png'
     * @return string Example:
     *     'png'
     * @throws InvalidImageExtensionException
     */
    private function _getExtension(string $name):string
    {
        try
        {
            $extension = pathinfo($name)['extension'];
        }
        catch (Exception $exception)
        {
            throw new InvalidImageExtensionException();
        }

        if (!$this->_config->getExtensions()->extensionIsValid($extension)) throw new InvalidImageExtensionException();
        return $extension;
    }
}