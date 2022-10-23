<?php

require_once __DIR__ . '/app/functions.php';

$path = __DIR__ .'/app/version';
$version = (float) file_get_contents($path);
$version+= 0.001;
var_dump($version);
log2file($path, $version, 'w');

