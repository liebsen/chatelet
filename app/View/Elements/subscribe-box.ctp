  <section class="subscribe-box bg-salmon animation-pullUp animation-both delay3 d-none">
    <div class="w-100">
      <span class="corner-pin is-clickable">
        <i class="ico-times" role="img" aria-label="Cerrar"></i>
      </span>
      <div class="subscribe-form d-flex flex-column justify-content-start align-items-center gap-05 max-25 m-auto">
        <span class="text-center">
          <h4 class="text-uppercase">Estemos <strong>conectadas</strong></h4>
          <p class="text-uppercase">Enterate de nuestras novedades, descuentos<br>y beneficios exclusivos solo para clientas</p>
        </span>
        <span>
        <?php echo $this->Form->create('Subscribe', array(
          'class' => 'form-subscription', 
          'url' => array(
            'controller' => 'users', 
            'action' => 'subscribe'
          )
        )); ?>
          <input type="hidden" name="ajax" value="1" />
          <div class="is-flex-center flex-column gap-05 w-100">
            <div class="is-flex-center gap-05 w-100">
              <input class="form-control m-0" type="text" name="data[Subscription][full_name]" placeholder="Ingresá tu nombre" required>
            </div>
            <div class="is-flex-center gap-05">
              <input class="form-control m-0" type="email" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
              <input type="submit" class="btn btn-chatelet dark" id="enviar" value="Confirmar">
            </div>
          </div>
        <?php echo $this->Form->end(); ?>
        </span>
        <span class="subscribe-message text-danger"></span>      
        <span class="subscribe-dismiss is-clickable" data-toggle="click" data-hide=".subscribe-box">No, gracias</span>
      </div>    
      <div class="subscribe-success max-25 m-auto d-none">
        <span class="subscribe-text text-center">
          <h3 class="text-uppercase">¡Ya estamos <strong>conectadas</strong>!</h3>
          <h1><i class="gi gi-flash text-warning"></i></h1>
          <div class="d-flex align-items-center mb-4">
            <p class="text-theme">A partir de ahora ya formas parte de nuestra comunidad y te enviaremos información exclusiva de nuestras novedades, descuentos y beneficios exclusivos solo para clientas</p>
          </div>
          <div class="is-flex-center gap-1">
            <a class="text-link" data-toggle="click" data-hide=".subscribe-box">Cerrar esta ventana</a>
            <a class="text-link" onclick="subscribe_retry()">Volver a subscribirme</a>
            <a href="/Shop" class="text-link btn-continue-shopping">Ir al Shop</a>
          </div>
        </span>
      </div>
      <div class="subscribe-error max-25 m-auto d-none">
        <span class="subscribe-text text-center">
          <h4 class="text-uppercase">Error al suscribir</h4>
          <p>Hubo un error al procesar esta página y no pudimos suscribirte, intenta nuevamente en unos instantes o <a href="/contacto">contactanos</a></p>
          <p class="text-center">
            <a class="text-link" onclick="subscribe_retry()">Subscribirme con otra cuenta</a>
          </p>
        </span>
      </div>
    </div>
  </section>
  
  <div class="subscribe-btn is-clickable d-none" title="Estemos conectadas"><i class="fa fa-envelope-o text-muted"></i></div>
  <style>
    .subscribe-box { 
      position: fixed;
      z-index: 20;
      left: 0.05rem;
      right: 0.05rem;
      bottom: 0;
      font-weight: 500;
      overflow: hidden;
      padding: 1.5rem 1rem;
      border-top-left-radius: 1rem;
      border-top-right-radius: 1rem;
      animation-fill-mode: both;
    }

    .subscribe-box .ico-times::before {
      color: darkred;
    } 

    @media(min-width: 768px) {
      .subscribe-box { 
        position: absolute;
        border-radius: 0.5rem;
        bottom: 0.5rem;
        right: 0.5rem;
        bottom: 0.25rem;
        min-width: 30rem;
        left: auto;
      }
    }

    @media(max-width: 767px) {
      .subscribe-box:before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 8px;
        height: 4px;
        width: 5rem;
        margin: auto;
        background-color: lightcoral;
        border-radius: 4px;
      }
    }

    .subscribe-btn {
      position: fixed;
      background-color: transparent!important;
      z-index: 99;
      left: 0;
      bottom: 0;
      padding: 0.5rem 1rem;
      color: lightcoral;
    }

  </style>

  <script type="text/javascript">

    function subscribe_retry(){
      $('.subscribe-success,.subscribe-error,.subscribe-btn').hide()
      $('.subscribe-box form .form-control').val('')
      setTimeout(function(){
        $('.subscribe-box').removeClass('delay3')
        $('.subscribe-box').fadeIn(1000)
        $('.subscribe-form').show()
      }, 500)
    }

    $(document).ready(function() {
      const subscription_release = localStorage.subscription_release || 'undefined'
      
      if(!subscription_release || subscription_release == 'undefined') {
        $('.subscribe-box').removeClass('d-none')
        $('.subscribe-box').addClass('animation-fadeIn')
      } else {
        $('.subscribe-btn').delay(3000).fadeIn('slow')
      }

      $('.subscribe-dismiss').on('click', function(e) {
        e.preventDefault()
        localStorage.subscription_release = 1
        $('.subscribe-btn').show()
      })

      $('.corner-pin').on('click', function(e) {
        e.preventDefault()
        $('.subscribe-box').removeClass('delay3')
        $('.subscribe-box').fadeOut(1000)
        $('.subscribe-btn').delay(3000).fadeIn(1000)
      })

      $('.subscribe-btn').on('click', function(e) {
        e.preventDefault()
        subscribe_retry()        
      })

      $('.form-subscription').on('submit', function(event) {
        event.preventDefault();
        const formData = $(this).serialize();
        const btnSubmit = $(this).find('[type="submit"]');
        const redirect = $(this).find('[name="redirect"]').val();
        btnSubmit.data('name', btnSubmit.text())
        btnSubmit.text('Espere...')
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
                localStorage.subscription_release = 1
              }
            } else {
              $('.subscribe-form').hide()
              $('.subscribe-error').show('hidden')
            }
            btnSubmit.text(btnSubmit.data('name'))
            btnSubmit.prop('disabled', false)
          },
          error: function(xhr, status, error) {
            $('.subscribe-form').hide('hidden')
            $('.subscribe-error').show('hidden')
            //console.error("AJAX Error: " + status + " - " + error);
            btnSubmit.prop('disabled', false)
          }
        });
      });
    });
  </script>