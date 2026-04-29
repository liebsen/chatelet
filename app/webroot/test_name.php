<?php 

function nameparts($full_name){
  $parts = explode(' ', $full_name);
  $name = "";
  $surname = "";
  if(count($parts) > 1) {
    $surname = array_pop($parts);
    $name = implode(' ', $parts);
  }
  return [
    "name" => $name,
    "surname" => $surname,
  ];
}

$name = "John E Smith";
$result = nameparts($name);
echo "<pre>";
var_dump($result);

