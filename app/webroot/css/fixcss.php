<?php 


$file_handle = fopen("animate.css", "r");
while (!feof($file_handle)) {
  $line = fgets($file_handle);
	if(strpos($line, '-webkit-') === false){
  	$str.= $line;
  }
}
fclose($file_handle);
echo $str;

/*
$contents = file_get_contents('animate.css');
print_r($contents);
die();
$str = '';

foreach($contents as $line) {
	if(strpos('-webkit-', $line) === false){
		$str.= $line . "\n";
	}
}

echo $str;*/