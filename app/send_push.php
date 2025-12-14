<?php 

$data = json_encode([
    'title' => 'New Update!',

    'body' => 'Check out the latest article now.',

    'icon' => '/icon.png',

    'click_action' => 'https://yourwebsite.com'

]);

$ch = curl_init('https://fcm.googleapis.com/fcm/send');

curl_setopt($ch, CURLOPT_POST, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, [

    'Authorization: key=YOUR_SERVER_KEY',

    'Content-Type: application/json'

]);

curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

curl_exec($ch);

curl_close($ch);