<?php

require_once __DIR__ . '/app/functions.php';
$path = __DIR__ .'/app/version';

$version = (int) file_get_contents($path);
var_dump($version);
$version+= 1;
var_dump($version);
log2file($path, $version, 'w');
//var_dump('v'. ($version / 10000));
