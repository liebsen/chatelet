// Source - https://stackoverflow.com/a/75676652
// Posted by Ikenitenine, modified by community. See post 'Timeline' for change history
// Retrieved 2026-03-10, License - CC BY-SA 4.0

<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
header('Content-Type: text/html; charset=utf-8');

require __DIR__ . '/vendor/autoload.php';

use Minishlink\WebPush\VAPID;

print_r(VAPID::createVapidKeys());
