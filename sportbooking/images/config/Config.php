<?php

namespace sportbooking\images\config;
use sportbooking\images\config\exceptions\BaseDirectoryDoNotExistException;
use sportbooking\images\config\exceptions\BaseDirectoryDoNotSetException;
use sportbooking\images\config\exceptions\BaseDirectoryInvalidPermissionsException;
use sportbooking\images\config\exceptions\BaseDirectoryIsFileException;

/**
 * Class Config
 * @package sportbooking\images\config
 */
class Config
{
    /**
     * Default maximal quantity.
     */
    const DEFAULT_MAXIMAL_QUANTITY = 10;

    /**
     * Default maximal quantity.
     */
    const DEFAULT_PERMISSIONS = 0775;

    /**
     * @var ExtensionsConfig
     */
    private $_extensions;

    /**
     * @var LimitsMinimalConfig
     */
    private $_minimal;

    /**
     * @var LimitsMaximalConfig
     */
    private $_maximal;

    /**
     * @var SizesConfig
     */
    private $_sizes;

    /**
     * @var int
     */
    private $_maximalQuantity;

    /**
     * @var string
     */
    private $_baseDirectory;

    /**
     * @var int
     */
    private $_permissions;

    /**
     * Config constructor.
     * @param array $config Example:
     *     [
     *         'extensions' =>
     *         [
     *             'jpg',
     *             'jpeg',
     *             'png'
     *         ],
     *         'minimal' =>
     *         [
     *             'size' => 1024, // 1 KB
     *             'width' => 16,
     *             'height' => 16
     *         ],
     *         'maximal' =>
     *         [
     *             'size' => 20 * 1024 * 1024, // 20 MB
     *             'width' => 2048,
     *             'height' => 1536
     *         ],
     *         'sizes' =>
     *         [
     *             '200x200',
     *             '1024x768'
     *         ],
     *         'maximalQuantity' => 10,
     *         'baseDirectory' => __DIR__ . '/../files/images',
     *         'permissions' => 775
     *     ];
     * @throws BaseDirectoryDoNotSetException
     * @throws BaseDirectoryDoNotExistException
     * @throws BaseDirectoryIsFileException
     * @throws BaseDirectoryInvalidPermissionsException
     */
    public function __construct(array $config)
    {
        $extensionsData = $config['extensions'] ?? [];
        $minimalLimitsData = $config['minimal'] ?? [];
        $maximalLimitsData = $config['maximal'] ?? [];
        $sizesData = $config['sizes'] ?? [];
        $maximalQuantityData = $config['maximalQuantity'] ?? self::DEFAULT_MAXIMAL_QUANTITY;
        $baseDirectory = $config['baseDirectory'] ?? null;
        $permissions = $config['permissions'] ?? self::DEFAULT_PERMISSIONS;

        if (!$baseDirectory) throw new BaseDirectoryDoNotSetException('Invalid config. "baseDirectory" do not set in config.');
        if (!file_exists($baseDirectory)) throw new BaseDirectoryDoNotExistException('Invalid config. Base directory ' . $baseDirectory . ' do not exist.');
        if (!is_dir($baseDirectory)) throw new BaseDirectoryIsFileException('Invalid config. Base directory is ' . $baseDirectory . ' is file.');
        if (!is_readable($baseDirectory) || !is_writable($baseDirectory)) throw new BaseDirectoryInvalidPermissionsException('Invalid config. Invalid permissions for directory' . $baseDirectory . '. Need full access.');

        $this->_extensions = new ExtensionsConfig($extensionsData);
        $this->_minimal = new LimitsMinimalConfig($minimalLimitsData);
        $this->_maximal = new LimitsMaximalConfig($maximalLimitsData);
        $this->_sizes = new SizesConfig($sizesData);
        $this->_maximalQuantity = $maximalQuantityData;
        $this->_baseDirectory = $baseDirectory;
        $this->_permissions = $permissions;
    }

    /**
     * Return ExtensionsConfig object.
     * @return ExtensionsConfig
     */
    public function getExtensions():ExtensionsConfig
    {
        return $this->_extensions;
    }

    /**
     * Return LimitsMinimalConfig object.
     * @return LimitsMinimalConfig
     */
    public function getMinimal():LimitsMinimalConfig
    {
        return $this->_minimal;
    }

    /**
     * Return LimitsMaximalConfig object.
     * @return LimitsMaximalConfig
     */
    public function getMaximal():LimitsMaximalConfig
    {
        return $this->_maximal;
    }

    /**
     * Return SizesConfig object.
     * @return SizesConfig
     */
    public function getSizes():SizesConfig
    {
        return $this->_sizes;
    }

    /**
     * Return maximum quantity of images that can be downloaded per request.
     * @return int
     */
    public function getMaximalQuantity():int
    {
        return $this->_maximalQuantity;
    }

    /**
     * Return base directory for images.
     * @return string
     */
    public function getBaseDirectory():string
    {
        return $this->_baseDirectory;
    }

    /**
     * Return UNIX permissions. Example: 2775
     * @return int
     */
    public function getPermissions():int
    {
        return $this->_permissions;
    }
}