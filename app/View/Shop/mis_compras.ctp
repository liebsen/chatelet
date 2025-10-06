<?php
	echo $this->Session->flash();
?>
  <div id="headcontacto">
    <div class="wrapper">
      <div class="row">
        <div class="col-md-4">
          <div class="animated fadeIn delay2">
            <h1>Proximamente...</h1>
          </div>
        </div>
        <div class="col-md-8 pr-2-d">
          <div class="animated scaleIn delay box-cont">
            <div class="box">
              <h3>¿Tenés alguna consulta o sugerencia?</h3>
              <p>Aquí podrás próximamente acceder a tus compras realizadas en esta tienda.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section id="formulario">
    <div class="wrapper">
      <div class="carrito-items">
        <?php foreach($sales as $sale):?>
        <div class="carrito-item-row is-clickable">
          <div class="carrito-item-col cart-img-col">
            <div class="cart-img">
              <div class="ribbon bottom-left small"><span>50% OFF</span></div>
              <a href="/tienda/producto/8813/221/remera-conica-belen">
                <div class="carrito-item-image" style="background-image: url(/files/uploads/68910cd05656b.jpg)"></div>
                </a>
              </div>
            </div>
            <div class="carrito-item-col carrito-data">
              <span class="name is-carrito">REMERA CONICA BELEN</span>
              <p class="color">Color: <span class="talle" color-code="02">Negro</span></p>
              <p class="color">Talle: <span class="talle">02</span></p>
              <p class="color">Cantidad: <span class="talle">1</span></p>
              <label class="form-group mt-3">
                <input class="giftchecks" type="checkbox" id="giftcheck_8813" data-id="8813">
                <span class="label-text text-muted text-small">Es para regalo</span>
                <br><br>
              </label>
              <div class="text-right d-flex justify-content-end align-items-center gap-1">
                <span class="old_price text-grey animated fadeIn delay2">$ 39.000</span>
                <span class="price animated fadeIn delay">$ 19.500</span>
              </div>
              <div class="carrito-hide-element">
                <div class="form-inline">
                  <div class="form-group">
                    <div class="input-group mt-4">
                      <div class="input-group-addon input-lg is-clickable" onclick="removeCount()">
                       <span class="fa fa-minus"></span>
                      </div>
                      <input type="text" size="2" class="form-control product-count input-lg text-center" placeholder="Cantidad" value="1" original-value="1">
                      <div class="input-group-addon input-lg is-clickable" onclick="addCount()">
                       <span class="fa fa-plus"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <span class="ch-btn-success btn-change-count disable is-clickable">Reclamar</span>
              </div>
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