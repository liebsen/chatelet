 <div id="headhelp">
  <div class="wrapper">
    <div class="row">
      <div class="col-md-6">
        <h1>Transferencia<br>bancaria</h1>
      </div>
      <div class="col-md-6">
        <div class="box">
          <div class="row">
            <div class="col-md-6">
              <h3 class="h3"><?= $data['onlinebanking_explain_title'] ?></h3>
              <p class="font-system"><?= $data['onlinebanking_explain_text'] ?></p><br>
            </div>
            <div class="col-md-6">
              <h3 class="h3"><?= $data['onlinebanking_instructions_title'] ?></h3>
              <p class="font-system"><?= $data['onlinebanking_instructions_text'] ?></p>
              <p class="font-system"><?= $data['onlinebanking_total_text'] ?> $<?= $data['total_price'] ?></p>
            </div>
          </div>
          <div class="row mb-5">
            <div class="col-md-6 mt-3 text-center">
              <a class="btn cart-btn-green shrink" href="https://wa.me/?text=<?= urlencode($data['onlinebanking_explain_title']) ?><?= urlencode($data['onlinebanking_explain_text']) ?><?= urlencode($data['onlinebanking_instructions_title']) ?><?= urlencode($data['onlinebanking_instructions_text']) ?><?= urlencode($data['onlinebanking_instructions_text']) ?><?= urlencode($data['onlinebanking_total_text']) ?>" title="Enviar por WhatsApp" target="_blank">
                Compartir este texto
              </a>
            </div>
            <div class="col-md-6 mt-3 text-center">
              <a class="btn cart-btn-green shrink" href="https://wa.me/<?= $data['onlinebanking_whatsapp'] ?>?text=Hola te escribo de la web de Chatelet para enviarte el comprobante de transferencia..." target="_blank">
                Enviar comprobante
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
