<?php

$socials = \get_socials();
$str = '';

foreach($socials as $icon) if(!empty($settings[$icon.'_on']))
    $socials_str.= '<a href="'.$settings[$icon.'_url'].'" target="_blank"><i class="fa fa-'.$icon.'"></i></a>';
?>

<?php if(strlen($str)): ?>
    <div class="social-bottom">
        <span class="text-uppercase">
            <p class="h6">Seguinos en nuestras redes</p>
        </span><?php echo $str ?>
    </div>
<?php endif ?>