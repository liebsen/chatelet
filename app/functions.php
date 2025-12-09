<?php

function site_url() {
  $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || 
    $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
  $domainName = $_SERVER['HTTP_HOST'];
  return $protocol.$domainName;
}

function get_socials(){
  return ['facebook','instagram','x-twitter', 'youtube'];
}

function readable_time_ago($timestamp) {
    $current_time = time();
    $diff = $current_time - $timestamp;

    if ($diff < 60) {
        return $diff == 1 ? "1 segundo" : $diff . " segundos";
    } elseif ($diff < 3600) {
        $minutes = round($diff / 60);
        return $minutes == 1 ? "1 minuto" : $minutes . " minutos";
    } elseif ($diff < 86400) {
        $hours = round($diff / 3600);
        return $hours == 1 ? "1 hora" : $hours . " horas";
    } elseif ($diff < 2592000) { // 30 days
        $days = round($diff / 86400);
        return $days == 1 ? "1 día" : $days . " días";
    } elseif ($diff < 31536000) { // 365 days
        $months = round($diff / 2592000);
        return $months == 1 ? "1 mes" : $months . " meses";
    } else {
        $years = round($diff / 31536000);
        return $years == 1 ? "1 año" : $years . " años";
    }
}

function starts_with($haystack, $needle) {
  $length = strlen($needle);
  return substr($haystack, 0, $length) === $needle;
}

function ends_with($haystack, $needle) {
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

function filtercoupon ($data, $config = null, $amount = 0) {
  $payment_method = @$config['payment_method'] ?: 'bank';
  $item = $data['Coupon'];
  $coupon_type = '';
  $coupon_ids = [];
  $config = ["prods","cats"];
  $date = date('Y-m-d');
  $week = (string) date('w');
  $time = time();
  $hour = date('H:i:s');
  $coupon_payment = $item['coupon_payment'] ?: "";
  $min_amount = $item['min_amount'] ?: 0;
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
    'message' => 'No coupon type',
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
          'title' => "No es válido ahora",
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
          'title' => "No es válido ahora",
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
          'title' => "No es válido ahora",
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

  if($config && strpos($coupon_payment, $payment_method) === false) {
    $payments = explode(',',$item['coupon_payment']);
    $valid_for = implode(' o ', $payments);
    $valid_for = str_replace('bank', 'transferencia', $valid_for);
    $ret->paying_with = $valid_for;
    /* $ret = (object) [
      'status' => 'error',
      'title' => "Restricción de método de pago",
      'message' => "Esta promo solo es válida pagando con {$valid_for}"
    ]; */
  }

  if($amount && $min_amount && $min_amount > $amount) {
    $ret = (object) [
      'status' => 'error',
      'title' => "Restricción monto de compra",
      'message' => "Esta promo solo es válida para compras de $ {$min_amount} o más"
    ];
  }

  return $ret;
}

function parse_template($str, $data) {
  $html = $str;
  foreach ($data as $key => $value) {
    $html = str_replace(["{{" . $key . "}}", "{{ " . $key . " }}"], $value, $html);
  }   
  return $html;
}

function version_readable($version) {  
  $a = str_split((string) $version);
  $a = array_merge(array_slice($a, 0, 1), array("."), array_slice($a, 1));
  $a = array_merge(array_slice($a, 0, 4), array("."), array_slice($a, 4));
  return implode("", $a);
}

function shipping_text($settings, $cart_totals) {  
  $text_shipping_min_price = '';

  if ($settings['shipping_type'] == 'min_price') {
    $params = [
      'precio_min_envio_gratis' => str_replace(',00','',number_format($settings['shipping_price_min'], 0, ',', '.')),
      'resto_min_envio_gratis' => str_replace(',00','',number_format($settings['shipping_price_min'] - (integer) $cart_totals['grand_total'], 0, ',', '.')),
      'total' => str_replace(',00','',number_format($cart_totals['grand_total'], 0, ',', '.'))
    ];

    $text_shipping_min_price = ($settings['display_text_shipping_min_price'] && $settings['text_shipping_min_price']) ? 
      \parse_template($settings['text_shipping_min_price'], $params) : 
      '';
  }

  return $text_shipping_min_price;
}

function price_format($num, $unsigned = 0) {
  $num = number_format((float) ceil($num), 2, ',', '.');
  return ($unsigned ? '' : '$ ') . str_replace(',00','', $num);
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
