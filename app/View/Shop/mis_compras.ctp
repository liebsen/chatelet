<?php
	echo $this->Session->flash();
?>
  <div id="headcontacto">
    <div class="wrapper">
      <div class="row">
        <div class="col-md-4">
          <div class="animated fadeIn delay2">
            <h1>Mis compras</h1>
          </div>
        </div>
        <div class="col-md-8 pr-2-d">
          <div class="animated scaleIn delay box-cont">
            <div class="box">
              <h3>Aquí encontrarás las compras realizadas a tu cuenta</h3>
              <p>Aquí encontrarás las compras realizadas a tu cuenta en Chatelet y podrás gestionar a través de la tienda servicios post-venta.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section id="formulario">
    <div class="wrapper">
      <div class="ch-flex"> 
        <?php foreach($sales as $sale):?>
        <div class="ch-row is-clickable">
          <div class="ch-col p-5 gap-1">
            <!--span class="name">REMERA CONICA BELEN</span-->
            <p>Fecha: 
              <span class="text-muted"><?= $sale['Sale']['created'] ?></span>
              <span class="text-muted">(<?= \timeAgo(strtotime($sale['Sale']['created'])) ?>)</span>
            </p><br>
            <p>Costo de Envío: 
            <?php if(empty($sale['Sale']['delivery_cost'])):?>
              <span class="text-success">gratis</span>
            <?php else: ?>
            <span class="text-muted"><?= \price_format($sale['Sale']['delivery_cost']) ?></span>
            <?php endif; ?>
            </p>
            <p>Método de pago: <span class="text-muted"><?= $sale['Sale']['payment_method']; ?></span></p>
            
            <?php if($sale['Sale']['cargo'] == 'takeaway'):?>
              <p>Método de Envío: <span class="text-muted">Takeaway</span></p>
              <p>
                Retira en sucursal: 
                <span class="text-muted"><?= implode(", ", [
                  $sale['Sale']['store_address'], 
                  $sale['Sale']['store']
                ]) ?></span>
              </p>
            <?php else: ?>
              <p>Método de Envío: <span class="text-muted">Entrega a domicilio</span></p>
              <p>Entrega en: 
                <span class="text-muted"><?= implode(" ", [
                  $sale['Sale']['calle'],
                  $sale['Sale']['nro'],
                  $sale['Sale']['piso'],
                  $sale['Sale']['depto']
                ]) ?></span>
                <span class="text-muted"><?= implode(", ",[
                  $sale['Sale']['localidad'], 
                  $sale['Sale']['provincia']
                ]) ?> (<?= $sale['Sale']['cp'] ?>) </span>
              </p>
            <?php endif; ?>
            </p>
            <div class="text-right d-flex justify-content-end align-items-center gap-1">
              <span class="price animated fadeIn delay">$ <?= \price_format($sale['Sale']['value']) ?></span>
            </div>
          </div>
        </div>
        <?php endforeach ?>
      </div>
    </div>
  </section>

  <section id="suscribe">
    <div class="wrapper container is-flex-end">
      <div class="col-md-6">
        <h2 class="h2 mt-0 mb-4">Estemos <strong>conectad@s</strong></h2>
        <p>Enterate de nuestras novedades, descuentos y beneficios exlusivos solo para clientas</p>
      </div>
      <div class="col-md-6">
        <?php echo $this->Form->create('Contact', array('class' => 'contacto')); ?>
          <input class="p-1" type="email" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
          <input type="submit" id="enviar" value="ok">
        <?php echo $this->Form->end(); ?>
      </div>
    </div>
  </section>