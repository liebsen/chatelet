<?php

class EmailConfig {

            public $default = array(
                  'transport' => 'Smtp',
                  'from' => array('developers@infinixsoft.com' => 'chatelet.com'),
                  'host' => 'mail.infinixsoft.com',
                  'port' => 25,
                  'timeout' => 30,
                  'username' => 'developers@infinixsoft.com',
                  'password' => 'Infinix2015',
                  'charset' => 'utf-8',
                  'tls' => false,
                  //'headerCharset' => 'utf-8',
            );
}


