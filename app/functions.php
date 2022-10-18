<?php

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
  if (strpos($item['weekdays'], $week) === false) {
    $valid = [];
    $weekdays = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    foreach(str_split($item['weekdays']) as $week) {
      $valid[] = $weekdays[$week];
    }
    $str = implode(', ', $valid);
    return (object) [
      'status' => 'error',
      'title' => "Restricción horaria",
      'message' => "Esta promo solo es válida para días de semana {$str}. Puede volver a intentar mas adelante"
    ];
  }
  switch ($coupon_type) {
    case 'time':
      if ($inTime) {
        return (object) [
          'status' => 'success',
          'data' => $item
        ];
      } else {
        return (object) [
          'status' => 'error',
          'title' => "Restricción horaria",
          'message' => "Esta promo solo es válida para horario {$item['hour_from']} / {$item['hour_until']}"
        ];
      }
    case 'date':
      if ($inDate) { 
        return (object) [
          'status' => 'success',
          'data' => $item
        ];
      } else {
        $date_from = date('j M Y', strtotime($item['date_from']));
        $date_until = date('j M Y', strtotime($item['date_until']));
        return (object) [
          'status' => 'error',
          'title' => "Restricción fecha",
          'message' => "Esta promo solo es válida para periodo {$date_from} al {$date_until}"
        ];
      }
      break;
    case 'datetime':
      if ($inDateTime) { 
        return (object) [
          'status' => 'success',
          'data' => $item
        ];
      } else {
        return (object) [
          'status' => 'error',
          'title' => "Restricción fecha",
          'message' => "Esta promo solo es válida para fecha {$item['date_from']} {$item['hour_from']} / {$item['date_until']} {$item['hour_until']}"
        ];
      }
      break;
    case '':
    default:
        return (object) [
          'status' => 'success',
          'data' => $item
        ];      
      break;
  }
}

function price_format ($num) {
  $num = number_format((float) $num, 2, ',', '.');
  return str_replace(',00','', $num);
}

function title_fontsize ($str) {
  $font_size = '1.5rem';
  if (strlen($str) >= 18) {
      $font_size = '1.25rem';
  }
  if (strlen($str) >= 20) {
      $font_size = '1.15rem';
  }
  if (strlen($str) >= 24) {
      $font_size = '1rem';
  }
  if (strlen($str) >= 28) {
      $font_size = '0.75rem';
  }  
  if ($font_size){
      $str = '<span style="font-size:'.$font_size.'!important">'.$str.'</span>';
  }
  return $str;
}