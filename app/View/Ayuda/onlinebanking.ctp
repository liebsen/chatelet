 <div id="headhelp">
  <div class="wrapper">
    <div class="row">
      <div class="col-md-6">
        <h1 class="m-0">CBU/Alias</h1>
        <h3 class="h3 mw-26"><?= $data['onlinebanking_explain_title'] ?></h3>
        <?php if(isset($data['total_price'])): ?>
        <div class="badge bg-black">
          <span class="h4 text-white">Monto a transferir $<?= number_format($data['total_price'], 2, ',', '.') ?></span>
        </div>
        <?php endif ?>
        <p class="pre-system mt-4"><?= $data['onlinebanking_explain_text'] ?><br>Ref. #<?= $data['id'] ?></p><br><br>
      </div>
      <div class="col-md-6">
        <div class="box">
          <h3 class="h3"><?= $data['onlinebanking_instructions_title'] ?></h3>
          <p class="pre-system font-system"><?= $data['onlinebanking_instructions_text'] ?></p>
          <div class="row mb-5">
            <!--div class="col-md-6 mt-3 text-center">
              <a class="btn cart-btn-green shrink" href="https://wa.me/?text=<?= urlencode($data['onlinebanking_explain_title']) ?><?= urlencode($data['onlinebanking_explain_text']) ?><?= urlencode($data['onlinebanking_instructions_title']) ?><?= urlencode($data['onlinebanking_instructions_text']) ?><?= urlencode($data['onlinebanking_instructions_text']) ?><?= urlencode($data['onlinebanking_total_text']) ?>" title="Enviar por WhatsApp" target="_blank">
                Compartir este texto
              </a>
            </div-->
            <?php if(isset($data['onlinebanking_whatsapp'])): ?>
            <div class="col-xs-12 mt-3 text-center">
              <a class="btn cart-btn-green shrink" href="https://wa.me/<?= $data['onlinebanking_whatsapp'] ?>?text=Hola te escribo de la web de Chatelet para enviarte el comprobante de transferencia <?= urlencode('(ref. #'.$data['id'].')') ?> ..." target="_blank">
                Enviar comprobante
              </a>
            </div>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
