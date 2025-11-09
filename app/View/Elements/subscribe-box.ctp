  <div class="wrapper container w-100">
    <span class="corner-pin">
      <i class="ico-times" role="img" aria-label="Cerrar"></i>
    </span>
    <div class="is-flex-center flex-column gap-1">
      <span>
        <h2>Estemos <strong>conectad@s</strong></h2>
        <p>Enterate de nuestras novedades, descuentos y beneficios exlusivos solo para clientas</p>
      </span>
      <span>
      <?php echo $this->Form->create('Contact', array('class' => 'contacto')); ?>
        <div class="is-flex-center gap-05">
          <input class="form-control m-0" type="email" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
          <input type="submit" class="btn btn-chatelet dark" id="enviar" value="Confirmar">
        </div>
      <?php echo $this->Form->end(); ?>
      </span>
    </div>
  </div>

  <style>
    #suscribe { 
      position: fixed;
      left: 0;
      bottom: 0;
      background: #e6e6e6; 
      color: #333;
      font-weight: 300;
      overflow: hidden;
      padding: 1.5rem 1rem;
    }
  </style>