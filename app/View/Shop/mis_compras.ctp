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
          <div class="animated fadeIn delay2" title="">
            <span class="glyphicon glyphicon-remove"></span>
          </div>
          <div class="carrito-item-col cart-img-col">
            <div class="cart-img">
              <div class="ribbon bottom-left small"><span>50% OFF</span></div>
              <a href="/tienda/producto/8813/221/remera-conica-belen"><div class="carrito-item-image" style="background-image: url(/files/uploads/68910cd05656b.jpg)"></div></a></div></div><div class="carrito-item-col carrito-data" data-json="{&quot;id&quot;:&quot;8813&quot;,&quot;cod_chatelet&quot;:null,&quot;name&quot;:&quot;REMERA CONICA BELEN&quot;,&quot;desc&quot;:&quot;REMERA CONICA BELEN. ESCOTE BASE CON MANGA CAIDA Y PU\u00d1O, DETALLE TRABA CON BOTON, FRENTE CON UN BOLSILLO PLAQUE. TEJIDO ANGORA LISO.&quot;,&quot;img_url&quot;:&quot;68910ce672a6f.jpg&quot;,&quot;price&quot;:19500,&quot;mp_discount&quot;:&quot;50&quot;,&quot;bank_discount&quot;:&quot;50&quot;,&quot;article&quot;:&quot;i4105&quot;,&quot;category_id&quot;:&quot;221&quot;,&quot;ordernum&quot;:&quot;436&quot;,&quot;gallery&quot;:&quot;&quot;,&quot;discount&quot;:&quot;39000&quot;,&quot;promo&quot;:&quot;&quot;,&quot;stock_total&quot;:&quot;4&quot;,&quot;with_thumb&quot;:&quot;1&quot;,&quot;visible&quot;:true,&quot;discount_label&quot;:&quot;&quot;,&quot;discount_label_show&quot;:&quot;0&quot;,&quot;color&quot;:&quot;#ffffff&quot;,&quot;size&quot;:&quot;02&quot;,&quot;alias&quot;:&quot;Negro&quot;,&quot;color_code&quot;:&quot;02&quot;,&quot;alias_image&quot;:&quot;68910cd05656b.jpg&quot;,&quot;old_price&quot;:&quot;39000&quot;,&quot;number_ribbon&quot;:&quot;50&quot;,&quot;uid&quot;:0,&quot;count&quot;:1}"><span class="name is-carrito">REMERA CONICA BELEN</span><p class="color">Color: <span class="talle" color-code="02">Negro</span></p><p class="color">Talle: <span class="talle">02</span></p><p class="color">Cantidad: <span class="talle">1</span></p><label class="form-group mt-3">
              <input class="giftchecks" type="checkbox" id="giftcheck_8813" data-id="8813"><span class="label-text text-muted text-small">Es para regalo</span><br><br>
            </label><div class="text-right d-flex justify-content-end align-items-center gap-1"><span class="old_price text-grey animated fadeIn delay2">$ 39.000</span><span class="price animated fadeIn delay">$ 19.500</span></div><div class="carrito-hide-element">
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
            <span class="ch-btn-success btn-change-count disable is-clickable">Cambiar</span>
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