 <div id="headhelp">
  <div class="wrapper container animation-fadeIn w-100">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col-xs-12 col-md-4">
        <div class="datos-bancarios">
          <h1 class="m-0">CBU / Alias</h1>
          <h3 class="h3 mt-4 mw-26"><?= $settings['bank_explain_title'] ?></h3>
          <?php if(isset($price)): ?>
          <div class="bank-pill bank-amount">
            <span>A transferir $ <?= number_format($price, 2, ',', '.') ?></span>
          </div>
          <a href="https://wa.me/<?= $settings['bank_whatsapp'] ?>?text=Hola te escribo de la web de Châtelet para enviarte el comprobante de transferencia <?= urlencode('(ref. #'.$invoice_id.')') ?> ..." target="_blank">
          	<div class="bank-pill bank-ref">
            	<span class="">👉 Referencia #<?= $invoice_id ?></span>
            </div>
          </a>
          <?php endif ?>
          <p class="bank-pill bank-text"><?= $settings['bank_explain_text'] ?></p>
        </div>
      </div>
      <div class="col-xs-12 col-md-8 enviar-comprobante">
        <div class="box-cont">
          <div class="box mt-8">  
            <h3 class="h3"><?= $settings['bank_instructions_title'] ?></h3>
            <p class="pre-system font-system"><?= $settings['bank_instructions_text'] ?></p>
            <div class="row is-flex-center gap-05 mb-2 pt-4 w-100">
              <!--div class="col-md-6 mt-3 text-center">
                <a class="btn btn-chatelet shrink" href="https://wa.me/?text=<?= urlencode($settings['bank_explain_title']) ?><?= urlencode($settings['bank_explain_text']) ?><?= urlencode($settings['bank_instructions_title']) ?><?= urlencode($settings['bank_instructions_text']) ?><?= urlencode($settings['bank_instructions_text']) ?><?= urlencode($settings['bank_total_text']) ?>" title="Enviar por WhatsApp" target="_blank">
                  Compartir este texto
                </a>
              </div-->
              <?php if(isset($settings['bank_whatsapp'])): ?>
              <a class="btn btn-success w-100 text-white" href="https://wa.me/<?= $settings['bank_whatsapp'] ?>?text=Hola te escribo de la web de Châtelet para enviarte el comprobante de transferencia <?= urlencode('(ref. #'.$invoice_id.')') ?> ..." target="_blank">
                <i class="fa fa-lg fa-whatsapp"></i> Enviar por WhatsApp
              </a>
              <a class="btn btn-chatelet dark w-100" href="/shop/mis_compras">
                Ir a mis compras
              </a>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
