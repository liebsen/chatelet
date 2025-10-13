<?php
	echo $this->Session->flash();
  echo $this->Html->script('mis_compras.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
?>

  <style type="text/css">
    .compra-item  {
      font-family: monospace;
      padding: 1.5rem;
      color: #666;
      border-radius: 0.5rem;
      line-height: 1.5;
    }
    .ch-image {
      min-height: 10rem;
      background-size: contain!important;
      border-radius: 0.5rem;
    }
  </style>

  <div id="headcontacto">
    <div class="wrapper">
      <div class="row">
        <div class="col-md-4">
          <div class="animated fadeIn delay">
            <h1>Mis compras</h1>
          </div>
        </div>
        <div class="col-md-8">
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
      <div class="is-flex-center gap-1 w-100 p-4">
        <h1 class="card-title mb-0"><i class="fa fa-shopping-cart mr-1"></i> Mis compras</h1>
        <span class="btn btn-success cart-btn-green btn-filter-calendar"><i class="fa fa-calendar mr-1"></i> <span class="capitalize">Último mes</span></span>
      </div>
      <div class="ch-flex"> 
        <?php foreach($sales as $sale):?>
        <div class="ch-row is-clickable" onclick="$(this).find('.compra-item').toggle()">
          <div class="ch-col p-6 gap-1">
            <!--span class="name">REMERA CONICA BELEN</span-->
            <p>Fecha: 
              <span class="text-muted timestamp"><?= $sale['Sale']['created'] ?></span>
              <span class="text-muted">(<?= \timeAgo(strtotime($sale['Sale']['created'])) ?>)</span>
            </p>
            <p>Productos: <?= count($sale['Products']) ?></p>
            <p>Estado: 
              <?php if(empty($sale['Sale']['def_mail_sent'])):?>
                <span class="text-success">Procesando</span>
              <?php else: ?>
                Asignado a <span class="text-muted"><?= $sale['Sale']['def_orden_tracking'] ?></span>
              <?php endif; ?>
            </p>
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
                  @$sale['Sale']['calle'],
                  @$sale['Sale']['nro'],
                  @$sale['Sale']['piso'],
                  @$sale['Sale']['depto']
                ]) ?></span>
                <span class="text-muted"><?= implode(", ",[
                  @$sale['Sale']['localidad'], 
                  @$sale['Sale']['provincia']
                ]) ?> (<?= $sale['Sale']['cp'] ?>) </span>
              </p>
            <?php endif; ?>
              <div class="compra-item bg-light" style="display: none;">
                <?php foreach(@$sale['Products'] as $item): ?>
                  <div class="is-flex-center">
                    <div class="flex-1"><?= implode('<br>', array_filter(explode('-|-', $item['SaleProduct']['description']), function($item) {
                      if(strpos($item, 'PRODUCTO') !== false || 
                        strpos($item, 'TALLE') !== false || 
                        strpos($item, 'REGALO') !== false || 
                        strpos($item, 'COLOR') !== false || 
                        strpos($item, 'CODIGO') !== false ||
                        strpos($item, 'PRECIO_LISTA') !== false) {
                        return strval($item);
                      }
                      return false;
                    })) ?></div>
                    <div class="ch-image flex-1" style="background-image: url('<?=Configure::read('uploadUrl').$item['Product']['img_url']?>');"></div>
                  </div><hr>
                <?php endforeach ?>
              </div>
              <br>
              <span class="text-link"><i class="fa fa-edit mr-1"></i> Ver detalles</span>
            </p>
            <div class="text-right d-flex justify-content-end align-items-center gap-1">
              <span class="price animated fadeIn delay">$ <?= \price_format($sale['Sale']['value']) ?> 
              <?php if($sale['Sale']['dues'] > 1):?>
                <span class="text-muted text-small">en <?= $sale['Sale']['dues'] ?> cuotas</span>
              <?php endif ?>
              </span>
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