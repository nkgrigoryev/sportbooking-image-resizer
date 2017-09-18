<?php
$config = require('./config.php');

$path = $_GET['path'];

if($path == null || $path == ""){
    http_response_code(404);
//    echo json_encode([
//        'status' => 'error',
//        'code' => 3,
//        'message' => 'Path not set',
//    ]);
    return;
}

$splitedPath = explode('/images', $path);
if(count($splitedPath) < 2){
    http_response_code(404);
    return;
}

$path = __DIR__ . '/images' . $splitedPath[1];
$fileName = pathinfo($path)['filename'];
$ext = pathinfo($path)['extension'];
if(!in_array($ext, $config['image']['extensions'])){
    http_response_code(404);
//    echo json_encode([
//        'status' => 'error',
//        'code' => 2,
//        'message' => 'File extension: ' . $ext . ' not support',
//    ]);
    return;
}

$splitedPath = explode('/', $path);
if(count($splitedPath) < 5) {
    http_response_code(404);
//    echo json_encode([
//        'status' => 'error',
//        'code' => 3,
//        'message' => 'Path not valid',
//    ]);
    return;
}

$file = $splitedPath[count($splitedPath) - 1];
$sizeDirName = $splitedPath[count($splitedPath) - 2];
$parentDir = substr($path, 0, strlen($path) - strlen('/' . $sizeDirName . '/' . $file));

if(!in_array($sizeDirName, $config['image']['sizes'])){
    http_response_code(404);
    return;
}

$sizes = explode('x', $sizeDirName);
$originalFile = $parentDir . '/original/' . $file;

try{
    $image = new Imagick($originalFile);

//    $cx = round($image->getImageWidth() / 2);
//    $cy = round($image->getImageHeight() / 2);
//
//    $aspect = $image->getImageWidth() / $image->getImageHeight();
//    $k = 1.778;
//    if($aspect > 1){
//        //Too width
//        $newWidth = round($image->getImageHeight() * $k);
//
//        $image->chopImage();
//    }else{
//        //Too height
//
//    }

    //Create new directory for new image
    $parentDir = $parentDir . '/' . $sizeDirName;
    if(!mkdir($parentDir)){
        http_response_code(404);
        return;
    }

    $image->thumbnailImage($sizes[0], $sizes[1]);
    $image->writeImage($parentDir . '/' . $file);

    header('Content-Type:image/jpeg');
    echo $image;
    return;
}catch(ImagickException $e){
    http_response_code(404);
    return;
}