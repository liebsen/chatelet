<?php if(!$loggedIn): ?>
  <?php echo $this->element('subscribe-box') ?>
<?php endif ?>

  <?php if (@$settings['whatsapp_enable'] == '1'): ?>
    <div class="whatsapp-block">
      <a href="javascript:$zopim.livechat.window.show()" class="chat" title="Contactanos por Chat">
        <i class="fa fa-messages"></i>
      </a>
      <a href="https://wa.me/<?= $settings['whatsapp_phone'] ?>?text=Hola, tengo una consulta" class="d-block whatsapp" target="_blank" title="Contactanos por WhatsApp">
        <i class="fa fa-whatsapp"></i>
      </a>   
    </div>
  <?php endif ?>
  <?php if(
    !empty($settings['whatsapp_text']) && 
    (
      strstr($_SERVER['REQUEST_URI'], "/tienda") != false ||
      strstr($_SERVER['REQUEST_URI'], "/ayuda") != false
    )
  ): ?>
    <a href="https://wa.me/<?= $settings['whatsapp_phone'] ?>?text=Hola, tengo una consulta" class="d-block" target="_blank" title="Contactanos por WhatsApp">
      <div class="whatsapp-text <?=$settings['whatsapp_autohide'] == '1' ? " autohide segs-{$settings['whatsapp_autohide']}" : '' ?>">
        <span class="pr-3">
          <?= $settings['whatsapp_text'] ?>
        </span>
      </div>
    </a>
    <style>
    .whatsapp-block > a.whatsapp > .fa {
      animation-delay: <?= $settings['whatsapp_autohide'] + 5 ?>s;
    }
    </style>
  <?php endif ?>
