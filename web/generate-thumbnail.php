<?php

use sportbooking\images\ThumbnailGeneratorWeb;

require __DIR__ . '/../vendor/autoload.php';
$config = require(__DIR__ . '/../config/config.php');
new ThumbnailGeneratorWeb($config);