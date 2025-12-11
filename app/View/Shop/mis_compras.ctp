<?php
	echo $this->Session->flash();
  echo $this->Html->script('mis_compras.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
?>

  <div id="headhelp">
    <?php echo $this->element('navbar-ayuda'); ?>
    <div class="wrapper container animated fadeIn w-100">
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col-xs-12 col-md-4">
          <div class="animated fadeIn delay">
            <h1>Mis compras</h1>
          </div>
        </div>
        <div class="col-xs-12 col-md-8">
          <div class="animated fadeIn delay box-cont">
            <div class="box">
              <h3>Revisa tu historial de compras</h3>
              <p>Aquí encontrarás las compras realizadas a tu cuenta en <i>Châtelet</i></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section id="formulario">
    <div class="wrapper">
      <div class="d-flex justify-content-between align-items-center gap-1 w-100 p-4">
        <h1 class="card-title mb-0"><i class="fa fa-shopping-bag mr-1"></i> Mis compras</h1>
      <?php if(empty($sales) == false) : ?>
        <div class="form-group">
          <select class="form-control btn-filter-calendar" name="filter[Type]">
            <option value="day" selected>Hoy</option>
            <option value="month">Último mes</option>
            <option value="year">Último año</option>
            <option value="start">Siempre</option>
          </select>
        </div>
      <?php endif ?>
        <!--span class="btn btn-chatelet dark btn-filter-calendar capitalize">
          <i class="fa fa-calendar mr-1"></i> Último mes</span-->
      </div>
      <div class="row"> 
        <?php if(empty($sales)) : ?>
          <p class="is-flex-center p-5 text-muted min-h-12">No registras compras hasta ahora. &nbsp;<a href="/Shop" class="text-link">Hacer mi primera compra</a></p>
        <?php endif ?>
        <?php foreach($sales as $sale):?>
        <div class="history-items col-xs-12 col-lg-6 is-clickable" onclick="$(this).find('.area-secondary').toggle()">
          <div class="card p-3 gap-1">
            <div class="card-body card-area is-bordered">
              <!--span class="name">REMERA CONICA BELEN</span-->
              <p>Fecha: 
                <span class="text-muted timestamp"><?= $sale['Sale']['created'] ?></span><br>
                <span class="text-muted">(hace <?= \readable_time_ago(strtotime($sale['Sale']['created'])) ?>)</span>
              </p>
              <p>Productos: <?= count($sale['Products']) ?></p>
              <p>Estado: 
                <?php if(empty($sale['Sale']['def_mail_sent'])):?>
                  <span class="text-success">Procesando</span>
                <?php else: ?>
                  Asignado a <span class="text-muted"><?= $sale['Sale']['def_orden_tracking'] ?></span>
                <?php endif; ?>
              </p>
              <div class="area-secondary d-none">
                <p>Costo de Envío: 
                <?php if(empty($sale['Sale']['delivery_cost'])):?>
                  <span class="text-success">gratis</span>
                <?php else: ?>
                <span class="text-muted"><?= \price_format($sale['Sale']['delivery_cost']) ?></span>
                <?php endif; ?>
                </p>
                <p>Método de pago: <span class="text-muted"><?php echo $this->App->payment_method($sale['Sale']['payment_method']); ?></span></p>
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
                  <div class="compra-item bg-light">
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
                        <div class="ch-image flex-1" style="background-image: url('<?=$settings['upload_url'].$item['Product']['img_url']?>');"></div>
                      </div><hr>
                    <?php endforeach ?>
                  </div>
                </div>
                <br>
                <div class="d-flex justify-content-start align-items-center gap-1">
                  <span class="text-link"><i class="fa fa-edit mr-1"></i> Detalles</span>
                  <?php if($sale['Sale']['payment_method'] == 'bank'): ?><a class="text-link" href="/ayuda/onlinebanking/<?php echo $sale['Sale']['id'] ?>#f:.datos-bancarios"><i class="fa fa-support mr-1"></i> Instrucciones</a><?php endif ?>
                </div>
              </p>
              <div class="text-right d-flex justify-content-end align-items-center gap-1">
                <span class="price animated fadeIn delay"><?= \price_format($sale['Sale']['value']) ?> 
                <?php if($sale['Sale']['dues'] > 1):?>
                  <span class="text-muted text-sm">en <?= $sale['Sale']['dues'] ?> cuotas</span>
                <?php endif ?>
                </span>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach ?>
      </div>
    </div>
  </section>

  <section id="suscribe">
    <?php $this->element('subscribe-box') ?>
  </section>

  <style type="text/css">
    .card-area p {
      margin-bottom: 4px;
    }
    .compra-item  {
      font-family: monospace;
      padding: 1.5rem;
      color: #666;
      border-radius: 0.5rem;
      line-height: 1.5;
    }
    .ch-image {
      min-height: 10rem;
      aspect-ratio: inherit!important;
      background-size: contain!important;
      border-radius: 0.5rem;
    }
  </style>  