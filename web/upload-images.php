<?php

use sportbooking\images\UploaderWeb;

require __DIR__ . '/../vendor/autoload.php';
$config = require(__DIR__ . '/../config/config.php');
new UploaderWeb($config);