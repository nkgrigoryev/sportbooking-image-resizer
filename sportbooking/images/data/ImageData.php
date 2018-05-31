<?php

namespace sportbooking\images\data;

use Exception;
use Imagick;
use ImagickException;
use sportbooking\images\data\exceptions\InvalidImageException;
use sportbooking\images\data\exceptions\NoImageExtensionException;
use sportbooking\images\data\exceptions\PHPUploadErrorException;

/**
 * Class ImageData
 * @package sportbooking\images\data
 */
class ImageData
{
    /**
     * @var int Random bytes length
     */
    const RANDOM_BYTES_FOR_HASH_LENGTH = 128;

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
     * @var int|string
     */
    private $_key;

    /**
     * @var string
     */
    private $_extension;

    /**
     * @var string
     */
    private $_relativePath;

    /**
     * ImagesUploader constructor.
     * @param string $name Example:
     *     'firefox_3.5_logo_256x256.png'
     * @param string $type Example:
     *     'image/png'
     * @param string $temporaryName Example:
     *     '/tmp/Xcd45'
     * @param int $error Example:
     *     0
     * @param int|string $key Examples:
     *     0
     *     '0'
     *     'avatar'
     * @link http://www.php.net/manual/en/features.file-upload.errors.php
     * @throws PHPUploadErrorException
     * @throws InvalidImageException
     * @throws NoImageExtensionException
     */
    public function __construct
    (
        string $name,
        string $type,
        string $temporaryName,
        int $error,
        $key
    )
    {
        $this->_name = $name;
        $this->_type = $type;
        $this->_temporaryName = $temporaryName;
        $this->_error = $error;
        $this->_key = $key;

        if ($this->_error != UPLOAD_ERR_OK) throw new PHPUploadErrorException();
        $this->_extension = $this->_getExtension($this->_name);

        $image = $this->_getImagickImage($this->_temporaryName);
        $this->_width = $image->getImageWidth();
        $this->_height = $image->getImageHeight();
        $this->_size = $image->getImageLength();

        $hash = md5(openssl_random_pseudo_bytes(self::RANDOM_BYTES_FOR_HASH_LENGTH));
        $firstDirectory = substr($hash,0, 2);
        $secondDirectory = substr($hash,2, 2);
        $fileName = substr($hash,4);
        $this->_relativePath = '/' . $firstDirectory . '/' . $secondDirectory . '/' . $fileName . '_original.' . $this->_extension;
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
     * Return image key.
     * @return int|string Example:
     *     0
     *     'avatar'
     */
    public function getKey()
    {
        return $this->_key;
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
     * Return extension.
     * @return string Example:
     *     'png'
     */
    public function getExtension():string
    {
        return $this->_extension;
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
     * @throws NoImageExtensionException
     */
    private function _getExtension(string $name):string
    {
        try
        {
            $extension = pathinfo($name)['extension'];
        }
        catch (Exception $exception)
        {
            throw new NoImageExtensionException();
        }
        return $extension;
    }
}