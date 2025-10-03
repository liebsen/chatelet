 <div id="headhelp">
  <div class="wrapper animated fadeIn delay1">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col-xs-12 col-md-6 datos-bancarios">
        <h1 class="m-0">CBU/Alias</h1>
        <h3 class="h3 mt-4 mw-26"><?= $data['bank_explain_title'] ?></h3>
        <?php if(isset($data['total_price'])): ?>
        <h3 class="d-block border-dark text-center mt-1 ps-4 max-25">
          <span class="text-dark h3">A transferir $ <?= number_format($data['total_price'], 2, ',', '.') ?></span>
        </h3>
        <a class="btn cart-btn-green border-success bg-white d-block max-25 mt-4" href="https://wa.me/<?= $data['bank_whatsapp'] ?>?text=Hola te escribo de la web de Chatelet para enviarte el comprobante de transferencia <?= urlencode('(ref. #'.$invoice_id.')') ?> ..." target="_blank">
          <span class="text-white h3">👉 Referencia #<?= $invoice_id ?></span>
        </a>
        <?php endif ?>
        <p class="pre-system font-pre border-light bg-white w-max-content min-25 p-6 mt-4"><?= $data['bank_explain_text'] ?></p>
      </div>
      <div class="col-xs-12 col-md-6 enviar-comprobante">
        <div class="animated scaleIn delay25 box-cont">
          <div class="box mt-8">  
            <h3 class="h3"><?= $data['bank_instructions_title'] ?></h3>
            <p class="pre-system font-system"><?= $data['bank_instructions_text'] ?></p>
            <div class="row mb-5">
              <!--div class="col-md-6 mt-3 text-center">
                <a class="btn cart-btn-green shrink" href="https://wa.me/?text=<?= urlencode($data['bank_explain_title']) ?><?= urlencode($data['bank_explain_text']) ?><?= urlencode($data['bank_instructions_title']) ?><?= urlencode($data['bank_instructions_text']) ?><?= urlencode($data['bank_instructions_text']) ?><?= urlencode($data['bank_total_text']) ?>" title="Enviar por WhatsApp" target="_blank">
                  Compartir este texto
                </a>
              </div-->
              <?php if(isset($data['bank_whatsapp'])): ?>
              <div class="col-xs-12 mt-4 text-center">
                <a class="btn cart-btn-green shrink mt-3" href="https://wa.me/<?= $data['bank_whatsapp'] ?>?text=Hola te escribo de la web de Chatelet para enviarte el comprobante de transferencia <?= urlencode('(ref. #'.$invoice_id.')') ?> ..." target="_blank">
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
