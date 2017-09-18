<?php
header('Content-Type: application/json');
$config = require('./config.php');

$uploadDir = __DIR__ . '/images';
$files = $_FILES['files'];

if(count($files) == 0){
    echo json_encode([
        'status' => 'error',
        'code' => 8,
        'message' => 'Too few images',
    ]);
    return;
}

if(count($files['name']) > $config['image']['count']){
    echo json_encode([
        'status' => 'error',
        'code' => 7,
        'message' => 'Too much images',
    ]);
    return;
}

for($i = 0; $i < count($files['name']); $i++) {
    $fileName = pathinfo($files['name'][$i])['filename'];
    $ext = pathinfo($files['name'][$i])['extension'];

    if(intval($fileName) == 0){
        echo json_encode([
            'status' => 'error',
            'code' => 1,
            'message' => 'File name: ' . $fileName . ' is not integer',
        ]);
        return;
    }

    if(!in_array($ext, $config['image']['extensions'])){
        echo json_encode([
            'status' => 'error',
            'code' => 2,
            'message' => 'File extension: ' . $ext . ' not support',
        ]);
        return;
    }
}

$links = [];
for($i = 0; $i < count($files['tmp_name']); $i++) {
    $fileName = pathinfo($files['name'][$i])['filename'];
    $ext = pathinfo($files['name'][$i])['extension'];

    try {
        $image = new Imagick($files['tmp_name'][$i]);

        //Check image min size
        if($image->getImageLength() < $config['image']['min']['size']){
            echo json_encode([
                'status' => 'error',
                'code' => 6,
                'message' => 'Too small image size',
            ]);
            return;
        }

        //Check image max size
        if($image->getImageLength() > $config['image']['max']['size']){
            echo json_encode([
                'status' => 'error',
                'code' => 7,
                'message' => 'Too big image size',
            ]);
            return;
        }

        //Check image min width/height
        if($image->getImageWidth() < $config['image']['min']['width'] || $image->getImageHeight() < $config['image']['min']['height']){
            echo json_encode([
                'status' => 'error',
                'code' => 4,
                'message' => 'Too small image',
            ]);
            return;
        }

        //Check image max width/height
        if($image->getImageWidth() > $config['image']['max']['width'] || $image->getImageHeight() > $config['image']['max']['height']){
            echo json_encode([
                'status' => 'error',
                'code' => 5,
                'message' => 'Too big image',
            ]);
            return;
        }

        $imageId = str_pad($fileName, 9, '0', STR_PAD_LEFT);

        $dirs = str_split($imageId, 3);
        $parentDir = $uploadDir;
        for($j = 0; $j < count($dirs); $j++){
            $dir = $parentDir . '/' . md5($dirs[$j]);
            $parentDir = $dir;
            mkdir($dir);
        }

        $parentDir = $parentDir . '/original';
        mkdir($parentDir);

        $key = hash('sha256', $config['token']['key']);
        $iv = substr(hash('sha256', $config['token']['vector']), 0, 16);

        $token = openssl_encrypt($fileName, $config['token']['method'], $key, 0, $iv);

        $newImage = md5($token) . '.' . $ext;
        $image->writeImage($parentDir . '/' . $newImage);

        $parentDir = $config['scheme']. '://' . $_SERVER['SERVER_NAME'] . '/images' . explode('/images', $parentDir)[1];
        array_push($links, $parentDir . '/' . $newImage);
    }catch(ImagickException $e){
        echo json_encode([
            'status' => 'error',
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
        ]);
        return;
    }
}

echo json_encode([
    'status' => 'success',
    'result' => $links,
]);
return;