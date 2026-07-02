  <section class="subscribe-box bg-salmon animation-pullUp animation-both delay10 d-none-i">
    <div class="w-100">
      <span class="corner-pin is-clickable">
        <i class="ico-times" role="img" aria-label="Cerrar"></i>
      </span>
      <div class="subscribe-form d-flex flex-column justify-content-start align-items-center gap-05 max-25 m-auto">
        <span class="text-center">
          <h3 class="text-uppercase"><i class="gi gi-bell mr-1"></i> Estemos <strong>conectadas</strong></h3>
          <p class="text-uppercase text-sm">Enterate de nuestras novedades, descuentos<br>y beneficios exclusivos solo para clientas</p>
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
              <input class="form-control m-0" type="text" name="data[Subscription][full_name]" placeholder="Tu nombre completo" required>
            </div>
            <div class="is-flex-center gap-05">
              <input class="form-control m-0" type="email" name="data[Subscription][email]" placeholder="Tu email" required>
              <input type="submit" class="btn btn-chatelet dark" id="enviar" value="Suscribirme">
            </div>
          </div>
        <?php echo $this->Form->end(); ?>
        </span>
        <span class="subscribe-message text-danger"></span>      
        <span class="subscribe-dismiss is-clickable" data-toggle="click" data-hide=".subscribe-box">No, gracias</span>
      </div>    
      <div class="subscribe-success max-25 m-auto d-none-i">
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
      <div class="subscribe-error max-25 m-auto d-none-i">
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
  
  <div class="btn-subscribe is-clickable d-none-i" title="Estemos conectadas"><i class="fa fa-envelope-o fa-lg animation-floating animation-both m-auto"></i></div>
  <style>
    .subscribe-box { 
      position: fixed;
      z-index: 1000;
      left: 0.05rem;
      right: 0.05rem;
      bottom: 0;
      font-weight: 500;
      overflow: hidden;
      padding: 1.5rem 1rem;
      border-top-left-radius: 1rem;
      border-top-right-radius: 1rem;
      color: white;
    }

    .subscribe-box p {
    	color: white!important;
    }

    .subscribe-box i {
    	color: yellow!important;
    }

    .subscribe-box .ico-times::before {
      color: darkred;
    } 

    @media(min-width: 768px) {
      .subscribe-box { 
        border-radius: 0.5rem;
        bottom: 0.5rem;
        left: 0.5rem;
        right: auto;
        min-width: 30rem;
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

    .btn-subscribe {
      animation-name: fadeIn;
      animation-fill-mode: both;
      animation-delay: 5s;      
      animation-duration: 5s;
      display: flex;
      justify-content: center;
      align-items: center;
      position: fixed;
      color: lightcoral;
      width: 3rem;
      height: 3rem;
      border-radius: 3rem;
      background-color: coral;
      color: lightgoldenrodyellow;
      z-index: 99;
      right: 0.8rem;
      bottom: 8rem;
    }

  </style>

  <script type="text/javascript">

    function subscribe_retry(){
      $('.subscribe-success,.subscribe-error,.btn-subscribe').addClass('d-none-i')
      $('.subscribe-box form .form-control').val('')
      setTimeout(function(){
        $('.subscribe-box').removeClass('d-none-i')
        $('.subscribe-box').show()
        $('.subscribe-form').removeClass('d-none-i')
      }, 500)
    }

    $(document).ready(function() {
      const subscription_release = localStorage.subscription_release || 'undefined'
      
      if(!subscription_release || subscription_release == 'undefined') {
        $('.subscribe-box').removeClass('d-none-i')
      } else {
        $('.btn-subscribe').removeClass('d-none-i')
      }

      $('.subscribe-dismiss').on('click', function(e) {
        e.preventDefault()
        localStorage.subscription_release = 1
        $('.btn-subscribe').removeClass('d-none-i')
      })

      $('.corner-pin').on('click', function(e) {
        e.preventDefault()
        $('.subscribe-box').removeClass('delay3')
        $('.subscribe-box').fadeOut(500)
        $('.btn-subscribe').removeClass('d-none-i')
      })

      $('.btn-subscribe').on('click', function(e) {
        e.preventDefault()
        subscribe_retry()
        setTimeout(() => {
          $('input[name="data[Subscription][full_name]"]').focus()
        }, 500)
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
                $('.subscribe-form,.subscribe-error').addClass('d-none-i')
                $('.subscribe-success').removeClass('d-none-i')
                localStorage.subscription_release = 1
              }
            } else {
              $('.subscribe-form').addClass('d-none-i')
              $('.subscribe-error').removeClass('d-none-i')
            }
            btnSubmit.text(btnSubmit.data('name'))
            btnSubmit.prop('disabled', false)
          },
          error: function(xhr, status, error) {
            $('.subscribe-form').removeClass('d-none-i')
            $('.subscribe-error').removeClass('d-none-i')
            //console.error("AJAX Error: " + status + " - " + error);
            btnSubmit.prop('disabled', false)
          }
        });
      });
    });
  </script>