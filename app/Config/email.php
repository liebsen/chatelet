<?php

class EmailConfig {

      public $default = array(
            'transport' => 'Smtp',
            'from' => array('no-responder@chatelet.com.ar' => 'Châtelet'),
            // 'host' => 'mail.infinixsoft.com',
            'host' => 'smtp.gmail.com',
            // 'port' => 465,
            'port' => 587,
            'timeout' => 30,
            'username' => 'chateletfacebook@gmail.com',
            // 'password' => 'Fran4850',
            // 'password' => 'A@spOWo9fS',
            //'password' => 'clryubbbmjeljkpp',
            'password' => 'rkvskpfrnixfadyh',
            'charset' => 'utf-8',
            'tls' => true
          //'log' => true
            // 'ssl' => true
            //'headerCharset' => 'utf-8',
      );
}

