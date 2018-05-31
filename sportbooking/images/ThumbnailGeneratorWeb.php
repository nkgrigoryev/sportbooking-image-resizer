<?php

namespace sportbooking\images;

use Imagick;
use sportbooking\images\config\Config;

class ThumbnailGeneratorWeb
{
    /**
     *
     */
    const NO_FOUND_PAGE_LAYOUT =
'<!doctype html>
<head>
    <meta charset="utf-8">
    <title>404 Not Found</title>
    <style>
        body
        {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>404 Not Found</h1>
    <hr>php
</body>';

    public function __construct(array $config)
    {
        $configObject = new Config($config);

        $serverDocumentURI = $_SERVER['REQUEST_URI'];
        $array = explode('/', $serverDocumentURI);

        $arrayLength = count($array);
        if (count($array) < 4) $this->_error();
        $array = array_splice($array, $arrayLength - 3);
        $relativePath =  '/' . implode('/', $array);
//        http://static.sportbooking/images/c0/3f/b49f3fbf89e1cfeea57efdd8e563_200x200.jpg
        $matches = [];
        preg_match('/_\d+x\d+\./', $relativePath, $matches);
        if (count($matches) != 1) $this->_error();

//        echo $configObject->getBaseDirectory() . $relativePath;
        $originalRelativePath = str_replace($matches[0], '_original.', $relativePath);
        if (!is_file($configObject->getBaseDirectory() . $originalRelativePath))
        {
            $this->_error();
        }
        $size = substr($matches[0], 1);
        $size = substr($size, 0,strlen($size) - 1);

        try
        {
            $sizeConfig = $configObject->getSizes()->getSize($size);
        }
        catch (\Exception $exception)
        {
            $this->_error();
        }

        try
        {
            $image = new Imagick($configObject->getBaseDirectory() . $originalRelativePath);
        }
        catch (\Exception $exception)
        {
            $this->_error();
        }

        $image->cropThumbnailImage($sizeConfig->getWidth(), $sizeConfig->getHeight());
        $image->writeImage($configObject->getBaseDirectory() . $relativePath);

        header('Content-Type: image/' . $image->getImageFormat());
        echo $image;
        $image->destroy();
    }

    private function _error()
    {
        $serverProtocol = $_SERVER['SERVER_PROTOCOL'];
        $httpHeader = $serverProtocol . ' 404 Not Found';
        header($httpHeader);

        echo self::NO_FOUND_PAGE_LAYOUT;
        die();
    }
}