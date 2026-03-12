<?php

require_once __DIR__ . '/app/functions.php';

$path = __DIR__ .'/app/app_version';
$version = (float) file_get_contents($path);
$version+= 1;

if(!empty($version)) {
	log2file($path, $version, 'w');
}

//var_dump('v'. ($version / 10000));
