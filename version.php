<?php

require_once __DIR__ . '/app/functions.php';

$filename = __DIR__ .'/app/app_version';
$count = (float) file_get_contents($filename);
$count+= 1;

if(!empty($count) && $count > 100) {
	// log2file($filename, $version, 'w');
	$fp = fopen($filename, 'c+');
  ftruncate($fp,0);
  fseek($fp,0);
  fwrite($fp, $count);
  flock($fp, LOCK_UN);	
}

//var_dump('v'. ($version / 10000));
