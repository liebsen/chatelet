<?php

$socials = \get_socials();
$str = '';

foreach($socials as $icon) {
    if($settings[$icon.'_on'] == '1'){
        $str.= '<a href="'.$settings[$icon.'_url'].'" title="'.ucfirst($icon).'" target="_blank"><img src="/img/share/'.$icon.'-brands-solid.png" width="50" height="50"></a>';
    }
}

?>

<?php if(strlen($str)): ?>
    <div class="social-bottom">
        <span class="text-uppercase">
            <h6>Seguinos en nuestras redes</h6>
        </span><?php echo $str ?>
    </div>
<?php endif ?>