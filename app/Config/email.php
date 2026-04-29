<?php

class EmailConfig {
  public $default = array(
    'transport' => 'Smtp',
    'from' => array('no-responder@chatelet.com.ar' => 'Châtelet'),
    'host' => 'smtp.gmail.com',
    // 'port' => 465,
    'port' => 587,
    'timeout' => 30,
    'username' => '',
    'password' => '',
    'charset' => 'utf-8',
    'tls' => true
    // 'log' => true
    // 'ssl' => true
    //'headerCharset' => 'utf-8',
  );
}

