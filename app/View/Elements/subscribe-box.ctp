  <div class="wrapper container w-100">
    <span class="corner-pin is-clickable">
      <i class="ico-times" data-toggle="click" data-remove=".subscribe-box" role="img" aria-label="Cerrar"></i>
    </span>
    <div class="subscribe-form d-flex flex-column justify-content-start align-items-center gap-1">
      <span class="subscribe-text text-center">
        <h4 class="text-uppercase">Estemos <strong>conectad@s</strong></h4>
        <p>Enterate de nuestras novedades, descuentos y beneficios exlusivos solo para clientas</p>
      </span>
      <span>
      <?php echo $this->Form->create('Contact', array('class' => 'contacto', 'url' => array('controller' => 'contacto', 'action' => 'index'))); ?>
        <input type="hidden" name="ajax" value="1" />
        <div class="is-flex-center gap-05">
          <input class="form-control m-0" type="email" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
          <input type="submit" class="btn btn-chatelet dark" id="enviar" value="Confirmar">
        </div>
      <?php echo $this->Form->end(); ?>
      </span>
      <span class="subscribe-message text-danger"></span>      
      <span class="is-clickable text-muted text-link" onclick="suscribe_release()" data-toggle="click" data-remove=".subscribe-box">No, gracias</span>
    </div>    
    <div class="subscribe-success hidden">
      <span class="subscribe-text text-center">
        <h4 class="text-uppercase">¡Ya estamos <strong>conectad@s</strong>!</h4>
        <p>A partir de ahora ya formas parte de nuestra comunidad y te enviaremos información exclusiva de nuestras novedades, descuentos y beneficios exlusivos solo para clientas</p>
        <p class="text-center">
          <a class="text-link" data-toggle="click" data-remove=".subscribe-box">Cerrar esta ventana</a>
          <a href="/Shop" class="text-link btn-continue-shopping">Ir al Shop</a>
          <a class="text-link" onclick="subscribe_retry()">Volver a subscribirme</a>
        </p>
      </span>
    </div>
    <div class="subscribe-error hidden">
      <span class="subscribe-text text-center">
        <h4 class="text-uppercase">Hubo une error</h4>
        <p>Algo sucedió y no pudimos suscribirte, intenta nuevamente en unos instantes o <a href="/contacto">contactanos</a></p>
        <p class="text-center">
          <a class="text-link" onclick="subscribe_retry()">Volver a subscribirme</a>
        </p>
      </span>
    </div>
  </div>

  <style>
    #suscribe { 
      position: fixed;
      z-index: 20;
      left: 0;
      right: 0;
      bottom: 0;
      background: #e6e6e6; 
      color: #333;
      font-weight: 300;
      overflow: hidden;
      padding: 1.5rem 1rem;
      min-width: 30rem;
    }

    .subscribe-text {
      max-width: 30rem;
    }

  </style>

  <script type="text/javascript">

    function suscribe_release(){
      localStorage.setItem('subscription_release', 1);
      save_preference({
        subscription_release: 1
      })
    }

    function subscribe_retry(){
      $('.subscribe-success,.subscribe-error').addClass('hidden')
      $('.subscribe-form').removeClass('hidden')
    }

    $(document).ready(function() {
      $('.contacto').on('submit', function(event) {
        event.preventDefault();
        const formData = $(this).serialize();
        const btnSubmit = $(this).find('[type="submit"]');
        const redirect = $(this).find('[name="redirect"]').val();
        btnSubmit.prop('disabled', true)
        $.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          data: formData,
          success: function(res) {
            if(res.success) {
              // onSuccessAlert('Success', res.message)
              // $('#responseContainer').html(res.message);
              if(res.is_already_subscribed) {
                $('.subscribe-message').text(res.message)
              } else {
                $('.subscribe-form').addClass('hidden')
                $('.subscribe-success').removeClass('hidden')
                localStorage.setItem('subscribed_complete', true)
              }
            } else {
              // onWarningAlert('Error al suscribir usuario', res.errors)
              $('.subscribe-form').addClass('hidden')
              $('.subscribe-error').removeClass('hidden')
              // $('#responseContainer').html(res.errors);
            }
            btnSubmit.prop('disabled', false)
          },
          error: function(xhr, status, error) {
            $('.subscribe-form').addClass('hidden')
            $('.subscribe-error').removeClass('hidden')
            console.error("AJAX Error: " + status + " - " + error);
            btnSubmit.prop('disabled', false)
            // Handle errors
          }
        });
      });
    });
  </script>
