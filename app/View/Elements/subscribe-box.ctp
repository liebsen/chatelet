  <section class="subscribe-box d-none">
    <div class="w-100">
      <span class="corner-pin is-clickable">
        <i class="ico-times" onclick="suscribe_release()" data-toggle="click" data-hide=".subscribe-box" role="img" aria-label="Cerrar"></i>
      </span>
      <div class="subscribe-form d-flex flex-column justify-content-start align-items-center gap-05 max-25 m-auto">
        <span class="text-center">
          <h4 class="text-uppercase">Estemos <strong>conectadas</strong></h4>
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
        <span class="is-clickable text-muted text-link" onclick="suscribe_release()" data-toggle="click" data-hide=".subscribe-box">No, gracias</span>
      </div>    
      <div class="subscribe-success max-25 m-auto d-none">
        <span class="subscribe-text text-center">
          <h4 class="text-uppercase">¡Ya estamos <strong>conectadas</strong>!</h4>
          <p>A partir de ahora ya formas parte de nuestra comunidad y te enviaremos información exclusiva de nuestras novedades, descuentos y beneficios exlusivos solo para clientas</p>
          <div class="is-flex-center gap-1">
            <a class="text-link" data-toggle="click" data-hide=".subscribe-box">Cerrar esta ventana</a>
            <!--a href="/Shop" class="text-link btn-continue-shopping">Ir al Shop</a-->
            <a class="text-link" onclick="subscribe_retry()">Volver a subscribirme</a>
          </div>
        </span>
      </div>
      <div class="subscribe-error max-25 m-auto d-none">
        <span class="subscribe-text text-center">
          <h4 class="text-uppercase">Hubo une error</h4>
          <p>Algo sucedió y no pudimos suscribirte, intenta nuevamente en unos instantes o <a href="/contacto">contactanos</a></p>
          <p class="text-center">
            <a class="text-link" onclick="subscribe_retry()">Volver a subscribirme</a>
          </p>
        </span>
      </div>
    </div>
  </section>
  
  <div class="suscribe-unrelease is-clickable d-none" onclick="suscribe_unrelease()" title="Estemos conectadas"><i class="fa fa-envelope-o text-muted"></i></div>
  <style>
    .subscribe-box { 
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
    }

    @media(min-width: 768px) {
      .subscribe-box { 
        min-width: 30rem;
        right: auto;
      }
    }

    .suscribe-unrelease {
      position: fixed;
      background-color: transparent!important;
      z-index: 99;
      left: 0;
      bottom: 0;
      padding: 0.5rem 1rem;
      color: #888;
    }

  </style>

  <script type="text/javascript">
    function suscribe_release(){
      localStorage.setItem('subscription_release', 1);
      setTimeout(() => {
        $('.suscribe-unrelease').show()
      }, 100)
    }

    function suscribe_unrelease(){
      localStorage.removeItem('subscription_release');
      subscribe_retry()
    }

    function subscribe_retry(){
      $('.subscribe-success,.subscribe-error,.suscribe-unrelease').hide()
      $('.subscribe-box,.subscribe-form').show()
    }

    $(document).ready(function() {
      if(!localStorage.getItem('subscription_release') || localStorage.getItem('subscription_release') == 'undefined') {
        setTimeout(() => {
          $('.subscribe-box').fadeIn('slow')
        }, 5000)
      } else {
        setTimeout(() => {
          $('.suscribe-unrelease').fadeIn('slow')
        }, 5000)        
      }

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
                $('.subscribe-form,.subscribe-error').hide()
                $('.subscribe-success').show()
                localStorage.setItem('subscription_release', 1);
              }
            } else {
              // onWarningAlert('Error al suscribir usuario', res.errors)
              $('.subscribe-form').hide()
              $('.subscribe-error').show('hidden')
              // $('#responseContainer').html(res.errors);
            }
            btnSubmit.prop('disabled', false)
          },
          error: function(xhr, status, error) {
            $('.subscribe-form').hide('hidden')
            $('.subscribe-error').show('hidden')
            console.error("AJAX Error: " + status + " - " + error);
            btnSubmit.prop('disabled', false)
            // Handle errors
          }
        });
      });
    });
  </script>
