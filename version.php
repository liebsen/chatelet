<?php

require_once __DIR__ . '/app/functions.php';

$filename = __DIR__ .'/app/version';
$count = intval(file_get_contents($filename));
$count+= 1;

if(!empty($count)) {
	$fp = fopen($filename, 'c+');
  ftruncate($fp,0);
  fseek($fp,0);
  fwrite($fp, $count);
  flock($fp, LOCK_UN);	
}

