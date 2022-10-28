<?php

require_once __DIR__ . '/app/functions.php';

$path = __DIR__ .'/app/version';
$version = (integer) file_get_contents($path);
$version+= 1;
log2file($path, $version, 'w');
$version_pub = (float) $version / 1000;
var_dump($version_pub);
