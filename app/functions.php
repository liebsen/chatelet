<?php

function startsWith($haystack, $needle) {
  $length = strlen($needle);
  return substr($haystack, 0, $length) === $needle;
}

function endsWith($haystack, $needle) {
  $length = strlen($needle);
  if(!$length) {
    return true;
  }
  return substr($haystack, -$length) === $needle;
}

function log2file($path, $data, $mode="a"){
  $fh = fopen($path, $mode) or die($path);
  fwrite($fh,$data . "\n");
  fclose($fh);
  chmod($path, 0777);
}

function filtercoupon ($data) {
  $coupon_type = '';
  $date = date('Y-m-d');
  $week = (string) date('w');
  $time = time();
  $hour = date('H:i:s');
  $item = $data['Coupon'];
  $coupon_type = isset($item['hour_from']) && isset($item['hour_until']) && $item['hour_from'] !== '00:00:00' && $item['hour_until'] !== '00:00:00' ? 'time' : $coupon_type;
  $coupon_type = isset($item['date_from']) && isset($item['date_until']) && $coupon_type === '' ? 'date' : $coupon_type;
  $coupon_type = isset($item['date_from']) && isset($item['date_until']) && $coupon_type === 'time' ? 'datetime' : $coupon_type;
  $inTime = strtotime($item['hour_from']) <= strtotime($hour) && strtotime($item['hour_until']) >= strtotime($hour);
  $inDate = strtotime($item['date_from']) <= strtotime($date) && strtotime($item['date_until']) >= strtotime($date);
  $inDateTime = $inTime && $inDate;

  if (strlen($coupon_type) && strpos($item['weekdays'], $week) === false) {
    $valid = [];
    $weekdays = [
      'Domingo',
      'Lunes',
      'Martes',
      'Miércoles',
      'Jueves',
      'Viernes',
      'Sábado'
    ];

    foreach(str_split($item['weekdays']) as $week) {
      $valid[] = @$weekdays[$week];
    }

    $str = implode(', ', $valid);

    return (object) [
      'status' => 'error',
      'title' => "Restricción horaria",
      'message' => "Esta promo solo es válida para días de semana {$str}. Puede volver a intentar mas adelante"
    ];
  }

  $ret = (object) [
    'status' => 'error',
    'message' => 'No coupon type'
  ];
  
  switch ($coupon_type) {
    case 'time':
      if ($inTime) {
        $ret = (object) [
          'status' => 'success',
          'data' => $item
        ];
      } else {
        $ret = (object) [
          'status' => 'error',
          'title' => "Restricción horaria",
          'message' => "Esta promo solo es válida para horario {$item['hour_from']} / {$item['hour_until']}"
        ];
      }
    case 'date':
      if ($inDate) { 
        $ret = (object) [
          'status' => 'success',
          'data' => $item
        ];
      } else {
        $date_from = date('j M Y', strtotime($item['date_from']));
        $date_until = date('j M Y', strtotime($item['date_until']));
        $ret = (object) [
          'status' => 'error',
          'title' => "Restricción fecha",
          'message' => "Esta promo solo es válida para periodo {$date_from} al {$date_until}"
        ];
      }
      break;
    case 'datetime':
      if ($inDateTime) { 
        $ret = (object) [
          'status' => 'success',
          'data' => $item
        ];
      } else {
        $ret = (object) [
          'status' => 'error',
          'title' => "Restricción fecha",
          'message' => "Esta promo solo es válida para fecha {$item['date_from']} {$item['hour_from']} / {$item['date_until']} {$item['hour_until']}"
        ];
      }
      break;
    case '':
    default:
      $ret = (object) [
        'status' => 'success',
        'data' => $item
      ];      
      break;
  }
  return $ret;
}

function price_format($num) {
  $num = number_format((float) ceil($num), 2, ',', '.');
  return str_replace(',00','', $num);
}

function title_fontsize($str) {
  $font_size = '1.5rem';
  if (strlen($str) >= 15) {
    $font_size = '1.25rem';
  }
  if (strlen($str) >= 19) {
    $font_size = '1.15rem';
  }
  if (strlen($str) >= 24) {
    $font_size = '1rem';
  }
  if (strlen($str) >= 30) {
    $font_size = '0.75rem';
  }  
  if ($font_size){
    $str = '<span style="font-size:'.$font_size.'!important">'.$str.'</span>';
  }
  return $str;
}
