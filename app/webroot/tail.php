<?php

$s=shell_exec('tail -n300 /var/log/nginx/error.log | grep "Update Product"');
var_dump($s);
