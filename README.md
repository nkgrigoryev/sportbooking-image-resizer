# Sportbooking static

## Requirements

- PHP 7.1 or above
- Composer
- Composer fxp/composer-asset-plugin
- ImageMagick
- NGINX

## Installation
**Tested on Ubuntu 16.04 and CentOS 7**

Go to project directory
```bash
cd /your/project/directory/
```

Install by composer
```bash
composer update
```

Copy configs
```bash
cp phpunit.xml.dist phpunit.xml
cp config/config.php.dist config/config.php
cp config/tokens.php.dist config/tokens.php
```

Copy and modify NGINX config
```bash
sudo cp /server/nginx/static.sportbooking.com.conf /etc/nginx/conf.d/
sudo nano /etc/nginx/conf.d/static.sportbooking.com.conf
```

## Examples of using

### Curl from console

Upload single image
```bash
curl -F "images=@/home/user/Desktop/test.png" -F "token=xxxxxxxxxxxxxxxx" static.sportbooking.com/upload-images
```
```json
{
    "result": [
        {
            "name": "test.png",
            "path": "\/0a\/e6\/fd6210e33a9cbe006f56fa591267_original.png",
            "type": "application\/octet-stream",
            "width": "256",
            "height": "256",
            "size": "76949",
            "key": 0
        }
    ]
}
```

Upload two images
```bash
curl -F "images[0]=@/home/user/Desktop/test.png" -F "images['second']=@/home/user/Desktop/test2.jpg" -F "token=xxxxxxxxxxxxxxxx" static.sportbooking.com/upload-images
```
```json
{
    "result": [
        {
            "name": "test.png",
            "path": "\/8a\/a1\/6b5bf1e1582dd0e64f15195f6615_original.png",
            "type": "application\/octet-stream",
            "width": "256",
            "height": "256",
            "size": "76949",
            "key": 0
        },
        {
            "name": "test2.jpg",
            "path": "\/cc\/f2\/ddce638c9b9613e3d9add523b889_original.jpg",
            "type": "image\/jpeg",
            "width": "400",
            "height": "400",
            "size": "41095",
            "key": "second"
        }
    ]
}
```

### Curl from PHP

Upload single image
```php
<?php
    
$data = 
[
    'token' => 'xxxxxxxxxxxxxxxx',
    'images' => curl_file_create('/home/user/Desktop/test.png', 'image/png')
];
    
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://static.sportbooking.com/upload-images');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
echo curl_exec($curl);
```

Upload two images
```php
<?php
    
$data = 
[
    'token' => 'xxxxxxxxxxxxxxxx',
    'images[0]' => curl_file_create('/home/user/Desktop/test.png', 'image/png'),
    'images[second]' => curl_file_create('/home/user/Desktop/test2.jpg', 'image/jpg')
];
    
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://static.sportbooking.com/upload-images');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
echo curl_exec($curl);
```

## Errors
# TODO errors examples

## Run tests
```bash
vendor/bin/phpunit
```

## Generate documentation
```bash
vendor/bin/apidoc api sportbooking docs --interactive=0
```