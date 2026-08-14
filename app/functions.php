<?php

function render_google_article_schema($headline, $author_name, $date_published, $image_url) {
  $schema = [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => $headline,
    'author' => [
      '@type' => 'Person',
      'name' => $author_name
    ],
    'datePublished' => $date_published,
    'image' => $image_url
  ];

  // JSON_UNESCAPED_SLASHES and JSON_UNESCAPED_UNICODE keep the output clean
  $json = json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
  
  echo '<script type="
  ">' . "\n" . $json . "\n" . '</script>';
}
/*
render_google_article_schema(
    'Understanding PHP Structured Data',
    'Jane Doe',
    '2026-08-11T08:00:00+00:00',
    'https://example.com'
);
*/
function sanitize_email($Str) {  
  $StrArr = str_split($Str); $NewStr = '';
  foreach ($StrArr as $Char) {    
    $CharNo = ord($Char);
    #if ($CharNo == 163) { $NewStr .= $Char; continue; } // keep £ 
    if ($CharNo > 31 && $CharNo < 127) {
      $NewStr .= $Char;    
    }
  }  
  return $NewStr;
}

 
function read_file($file, $lines) {
  //global $fsize;
  $handle = fopen($file, "r");
  $linecounter = $lines;
  $pos = -2;
  $beginning = false;
  $text = array();
  while ($linecounter > 0) {
    $t = " ";
    while ($t != "\n") {
      if(fseek($handle, $pos, SEEK_END) == -1) {
        $beginning = true; 
        break; 
      }
      $t = fgetc($handle);
      $pos --;
    }
    $linecounter --;
    if ($beginning) {
      rewind($handle);
    }
    $text[$lines-$linecounter-1] = fgets($handle);
    if ($beginning) break;
  }
  fclose ($handle);
  return array_reverse($text);
}

function word_limit($str, $at=4) {
  if(!strlen(trim($str))) {
    return 'Sin nombre';
  }
  $parts = array_filter(array_values(explode(' ', trim($str))));
  if(count($parts) <= $at) {
    return implode(' ', $parts);
  }
  $keeps = array_slice($parts,0,$at);
  array_push($keeps, '...');
  return implode(' ', $keeps);
}

function extract_jpeg_url($html) {
  preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $html, $matches);
  return $matches['src'] ?? 'images/isologo-w.png';
}

function array_count_values_of($value, $array) {
  $counts = array_count_values($array);
  return $counts[$value];
}

function b($a, $b = null){
  echo '<pre>';
  var_dump($a);
  echo '</pre>';
  if($b) die();
}

function d($a=null,$b=null,$c=null){
  if(empty($a)) return false;
  $d = !empty($c) ? $b : json_encode($b, JSON_PRETTY_PRINT);
  CakeLog::write('debug',$a.':'.$d);
}

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

function filter_orientation($list, $upload_url=""){
  $images = array_filter(explode(';',$list));
  $filtered = [];
  $mobile = \device_mobile();
  foreach($images as $image){
    if($mobile){                
      if(strstr($image, 'mobile') != false) {
          $filtered[]= $upload_url . str_replace(['desktop-', 'mobile-'], '', $image);
      }
    } else {
      if(strstr($image, 'desktop') != false) {
          $filtered[]= $upload_url . str_replace(['desktop-', 'mobile-'], '', $image);
      }
    }
  }
  return $filtered;
}

function site_url() {
  $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || 
    $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
  $domainName = $_SERVER['HTTP_HOST'];
  return $protocol.$domainName;
}

function device_mobile(){
  if(empty($_SERVER["HTTP_USER_AGENT"])) {
    return false;
  }

  return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '') || !empty($_GET['mobile']);
}


function upload_local() {
  return 1;
}

function upload_url() {
  return '/files/uploads/';
}

function get_socials(){
  return [
    'facebook',
    'instagram',
    'tiktok',
    'whatsapp',
    'x-twitter', 
    'youtube',
  ];
}

function get_mc_audiences(){
  return array(
    'account' => "Clientas",
    'contact' => "Contactos",
    'subscription' => "Suscripciones",
    'store' => "Store"
  );
}

function parsed_socials($settings){
  $socials = [];
  
  foreach(\get_socials() as $social) {
    if($settings[$social.'_on'] == '1') {
      $socials[$social] = $settings[$social.'_url'];
    }
  }

  return $socials;
}

function readable_tag_event($tag) {

    $trans = array(
      'page-view' => 'Vió una página',
      'page-exit' => 'Cerró la página',
      'newsletter-click' => 'Interactuó con newsletter',
      'session-resume' => 'Reanudó sesión',
      'session-start' => 'Inició sesión',
      'session-end' => 'Terminó sesión',
      'session-register' => 'Se registró',
      'cart-add' => 'Agregó al carrito',
      'cart-remove' => 'Quitó del carrito',
      'variant-select' => 'Seleccionó una variante',
    );

  return $trans[$tag] ?? $tag;
}

function readable_tag_color($tag) {
    
    $trans = array(
      'page-view' => 'info',
      'page-exit' => 'info',
      'newsletter-click' => 'danger',
      'session-resume' => 'light',
      'session-start' => 'light',
      'session-end' => 'light',
      'session-register' => 'light',
      'cart-add' => 'success',
      'cart-remove' => 'success',
      'variant-select' => 'success',
    );

  return $trans[$tag] ?? $tag;
}


function readable_time_ago($timestamp, $short = false) {
  $current_date = time();
  $date = strtotime($timestamp);
  $asc = $current_date > $date;
  $prep =  $asc ? 'hace' : 'en';
  $skipprep = false;
  $diff = abs($current_date - $date);
  $weekdays = array(
    'Domingo',
    'Lunes',
    'Martes',
    'Miércoles',
    'Jueves', 
    'Viernes',
    'Sábado'
  );
  $span = "";
  if ($diff < 15) {
    $span = "ahora";
    $skipprep = true;
  } elseif ($diff < 60) {
    $span = $diff == 1 ? "1 seg" : $diff . " segs";
  } elseif ($diff < (3600 - 60)) {
    $minutes = round($diff / 60);
    $span = $minutes == 1 ? "1 min" : $minutes . " mins";
  } elseif ($diff < (86400 - 3600)) {
    $hours = round($diff / 3600);
    $span = $hours == 1 ? "1 hora" : $hours . " hs";
  } elseif ($diff < 2592000) { // 30 days
    $days = round($diff / 86400);
    $span = $days == 1 ? "1 día" : $days . " días";
    if($days == 1) {
      $span = $asc ? "ayer" : 'mañana';
      $skipprep = true;
    } else if($days < 6) {
      $span = $weekdays[date('w', $date)];
      $skipprep = true;
    } else {
      $weeks = round($diff / 604800);
      $span = $weeks == 1 ? "1 semana" : $weeks . " semanas";
    }
  } elseif ($diff < 31536000) { // 365 days
    $months = round($diff / 2592000);
    $span = $months == 1 ? "1 mes" : $months . " meses";
  } else {
    $years = round($diff / 31536000);
    $span = $years == 1 ? "1 año" : $years . " años";
  }
  if($short) {
    return $span;
  }
  return (!$skipprep ? $prep : '') . ' ' . $span;
}

function readable_time_duration($when, $then) {
  $current_date = strtotime($when);
  $date = strtotime($then);
  $asc = $current_date > $date;
  $prep =  $asc ? 'hace' : 'en';
  $skipprep = false;
  $diff = abs($current_date - $date);
  $span = "";
  if ($diff < 60) {
    $span = $diff == 1 ? "1 seg" : $diff . " segs";
  } elseif ($diff < (3600 - 60)) {
    $minutes = round($diff / 60);
    $span = $minutes == 1 ? "1 min" : $minutes . " mins";
  } elseif ($diff < (86400 - 3600)) {
    $hours = round($diff / 3600);
    $span = $hours == 1 ? "1 h" : $hours . " hs";
  } elseif ($diff < 2592000) { // 30 days
    $days = round($diff / 86400);
    $span = $days == 1 ? "1 día" : $days . " días";
  } elseif ($diff < 31536000) { // 365 days
    $months = round($diff / 2592000);
    $span = $months == 1 ? "1 mes" : $months . " meses";
  } else {
    $years = round($diff / 31536000);
    $span = $years == 1 ? "1 año" : $years . " años";
  }
  return $span;
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
  // chmod($path, 0777);
}

function parse_coupon($coupon, $cart_totals) {
  // CakeLog::write('debug', 'payment_method:'.$cart_totals['payment_method']);
  $payment_method = $cart_totals['payment_method'] ?? 'bank';
  $amount = $cart_totals['grand_total'] || 0;
  $item = $coupon['Coupon'];
  $coupon_type = '';
  $coupon_ids = [];
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

  if($cart_totals && strpos($coupon_payment, $payment_method) === false) {
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

function parse_medal($i) {
	$medal = '<i class="fa fa-star text-warning"></i>';
	if($i==1) $medal = '<i class="fa fa-trophy text-warning"></i>';
	elseif($i==2) $medal = '<i class="fa fa-trophy text-warning"></i>';
	elseif($i==3) $medal = '<i class="fa fa-trophy text-warning"></i>';
	return (string) $medal. ' ('.$i.')';
}

function email_fix_images($html){
	// 1. Create a DOM Document and load the HTML
	$dom = new DOMDocument();
	// Use LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD to prevent adding html/body wrappers
	@$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

	// 2. Find all <img> tags
	$images = $dom->getElementsByTagName('img');

	// 3. Loop through each image and update the style attribute
	foreach ($images as $img) {
	    // Get existing styles if they exist
	    $existingStyle = $img->getAttribute('style');
	    
	    // Define the new style you want to add
	    //$newStyle = 'width: 100%; max-width: 100%; height: auto;';
	    $newStyle = 'max-width: 100%; height: auto;';
	    
	    // Combine existing and new styles cleanly
	    if (!empty($existingStyle)) {
	        // Ensure the existing style ends with a semicolon
	        $combinedStyle = rtrim($existingStyle, '; ') . '; ' . $newStyle;
	    } else {
	        $combinedStyle = $newStyle;
	    }
	    
	    // Apply the updated style back to the element
	    $img->setAttribute('style', $combinedStyle);
	}

	// 4. Output the updated HTML
	$updatedHtml = $dom->saveHTML();
	return $updatedHtml;
}

function parse_email($html, $data) {
	$str = \parse_template(
		\email_fix_images($html), 
		$data
	);
	return $str;
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
    $text_shipping_min_price = 
      ($settings['display_text_shipping_min_price'] && $settings['text_shipping_min_price']) ? 
      \parse_template($settings['text_shipping_min_price'], array(
      'precio_min_envio_gratis' => str_replace(',00','',number_format($settings['shipping_price_min'], 0, ',', '.')),
      'resto_min_envio_gratis' => str_replace(',00','',number_format($settings['shipping_price_min'] - (integer) $cart_totals['grand_total'], 0, ',', '.')),
      'total' => str_replace(',00','',number_format($cart_totals['grand_total'], 0, ',', '.'))
    )) : 
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
