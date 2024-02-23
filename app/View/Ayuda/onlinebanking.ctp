 <div id="headhelp">
  <div class="wrapper">
    <div class="row">
      <div class="col-md-6 datos-bancarios">
        <h1 class="m-0">CBU/Alias</h1>
        <h3 class="h3 mt-2 mw-26"><?= $data['bank_explain_title'] ?></h3>
        <?php if(isset($data['total_price'])): ?>
        <div class="badge bg-black">
          <span class="h4 text-white">Monto a transferir $<?= number_format($data['total_price'], 2, ',', '.') ?></span>
        </div>
        <?php endif ?>
        <p class="pre-system mt-4"><?= $data['bank_explain_text'] ?><br>Ref. #<?= $data['id'] ?></p><br><br>
      </div>
      <div class="col-md-6 enviar-comprobante">
        <div class="animated slideInRight delay1 leaves-pad">
          <div class="box w-leaves mt-8">  
            <h3 class="h3"><?= $data['bank_instructions_title'] ?></h3>
            <p class="pre-system font-system"><?= $data['bank_instructions_text'] ?></p>
            <div class="row mb-5">
              <!--div class="col-md-6 mt-3 text-center">
                <a class="btn cart-btn-green shrink" href="https://wa.me/?text=<?= urlencode($data['bank_explain_title']) ?><?= urlencode($data['bank_explain_text']) ?><?= urlencode($data['bank_instructions_title']) ?><?= urlencode($data['bank_instructions_text']) ?><?= urlencode($data['bank_instructions_text']) ?><?= urlencode($data['bank_total_text']) ?>" title="Enviar por WhatsApp" target="_blank">
                  Compartir este texto
                </a>
              </div-->
              <?php if(isset($data['bank_whatsapp'])): ?>
              <div class="col-xs-12 mt-3 text-center">
                <a class="btn cart-btn-green shrink" href="https://wa.me/<?= $data['bank_whatsapp'] ?>?text=Hola te escribo de la web de Chatelet para enviarte el comprobante de transferencia <?= urlencode('(ref. #'.$data['id'].')') ?> ..." target="_blank">
                  Enviar por WhatsApp
                </a>
              </div>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
