<?php 

$contents = get_contents('file.css');

$str = '';

foreach($contents as $line) {
	if(strpos('-webkit-', $line) == false){
		$str.= $line . "\n";
	}
}

echo $str;