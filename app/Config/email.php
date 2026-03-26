<?php

class EmailConfig {
  public $default = array(
    'transport' => 'Smtp',
    'from' => array('no-responder@chatelet.com.ar' => 'Châtelet'),
    'host' => 'smtp.gmail.com',
    // 'port' => 465,
    'port' => 587,
    'timeout' => 30,
    'username' => 'chateletfacebook@gmail.com',
    'password' => 'rkvskpfrnixfadyh',
    'charset' => 'utf-8',
    'tls' => true
    // 'log' => true
    // 'ssl' => true
    //'headerCharset' => 'utf-8',
  );

  public $newsletter = array(
    'transport' => 'Smtp',
    'from' => array('newsletters@chatelet.com.ar' => 'Châtelet'),
    'host' => 'smtp.gmail.com',
    // 'port' => 465,
    'port' => 587,
    'timeout' => 30,
    'username' => 'newschatelet@gmail.com',
    'password' => 'fasqlgdfzvspuynx',
    'charset' => 'utf-8',
    'tls' => true
    // 'log' => true
    // 'ssl' => true
    //'headerCharset' => 'utf-8',
  );

}

