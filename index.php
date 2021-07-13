<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

$app = new \Kyte\Core\Api();
$app->route();

?>
