<?php

require_once __DIR__ . '/app/functions.php';
$path = __DIR__ .'/app/version';

$version = (int) file_get_contents($path);
$version+= 1;

log2file($path, $version, 'w');
//var_dump('v'. ($version / 10000));
