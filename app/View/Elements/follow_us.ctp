<?php

$socials = \get_socials();
$str = '';

foreach($socials as $icon) {
    if($settings[$icon.'_on'] == '1'){
        $str.= '<a href="'.$settings[$icon.'_url'].'" title="'.ucfirst($icon).'" target="_blank"><img src="/img/share/'.$icon.'-brands-solid.png" width="40" height="40"></a>';
    }
}

?>

<?php if(strlen($str)): ?>
    <div class="social-bottom">
        <span class="text-uppercase mr-2">
            <h4>Seguinos en nuestras redes</h4>
        </span><?php echo $str ?>
    </div>
<?php endif ?>