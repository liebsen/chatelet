    <div class="wrapper container is-flex-end">
      <div class="col-md-6">
        <h2 class="h2 mt-0 mb-4">Estemos <strong>conectadas</strong></h2>
        <p>Enterate de nuestras novedades, descuentos y beneficios exlusivos solo para clientas</p>
      </div>
      <div class="col-md-6">
        <?php echo $this->Form->create('Contact', array('class' => 'contacto')); ?>
          <input class="p-1" type="email" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
          <input type="submit" id="enviar" value="ok">
        <?php echo $this->Form->end(); ?>
      </div>
    </div>
