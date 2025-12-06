<?php

$icons = ['facebook','instagram','x-twitter', 'youtube'];
$icons_show = false;
$icons_str = '';

foreach($icons as $icon) if(!empty($settings[$icon.'_on']))
    $icons_str.= '<a href="'.$settings[$icon.'_url'].'" target="_blank"><i class="fa fa-'.$icon.'"></i></a>';

?>

<div class="social-bottom">
    <span class="text-uppercase">
        <p class="h6">Seguinos en nuestras redes</p>
    </span><?php echo $icons_str ?>
</div>