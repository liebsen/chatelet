<?php 
	$this->set('short_header', 'Checkout');
	echo $this->Session->flash();
	echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
	echo $this->Html->css('bootstrap-datepicker', array('inline' => false));
	echo $this->Html->css('checkout.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
	echo $this->Html->script('coupon.js?v=' . Configure::read('APP_VERSION'),array( 'inline' => false ));
	echo $this->Html->script('carrito-lib.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));	
	echo $this->Html->script('checkout_sale.js?v=' . Configure::read('APP_VERSION'),array('inline' => false));
	//echo $this->element('carrito');
?>
<script>window.freeShipping = <?=(int)@$freeShipping?>;</script>
<script>
	var coupon_bonus = 0;
	var shipping_price = <?= $shipping_price_min ?>;
	var carrito_config = <?php echo json_encode($this->Session->read('cart_totals'), JSON_PRETTY_PRINT);?>;
	var carrito_items = <?php echo json_encode(array_values($this->Session->read('cart')), JSON_PRETTY_PRINT);?>;
	var bank = {
		enable: <?= isset($data['bank_enable']) ? $data['bank_enable'] : 0 ?>,
		discount_enable: <?= isset($data['bank_discount_enable']) ? $data['bank_discount_enable'] : 0 ?>,
		discount: <?= isset($data['bank_discount']) ? $data['bank_discount'] : 0 ?>
	}
</script>

<div id="dues_message" class="container">
	<h3>Vamos a redirigirte a la pasarela de pagos<h3>
	<h4>Asegurate de seleccionar <span class="dues-message-dues"></span> cuotas en MercadoPago</h4>
	<hr>
	<div>
		<button type="button" onclick="$('#submitform').click()" class="btn cart-btn-green" href="" class="mp-link">Entendido, continuar a MercadoPago</button>
	</div>
	<hr>
	<span>¡Muchas gracias!</span>
</div>
<div id="main" class="container animated fadeIn delay1">
	<form role="form" method="post" id="checkoutform" autocomplete="off" onkeydown="return event.key != 'Enter';" action="<?php echo $this->Html->url(array(
				'controller' => 'carrito',
				'action' => 'sale'
			)) ?>">

		<div class="row">
			<div id="carrito">
				<div class="carrito-row">
					<div class="carrito-col">
						<div class="ch-flex">
							<div class="card bg-transparent">
							  <div class="card-body">
							    <h5 class="card-title">
							    	<!--i class="fa fa-edit"></i-->
							    	Resumen de tu compra
							    </h5>
							    <h6 class="card-subtitle">
							    	Acá podés ver el resumen de tu compra. Luego de efectuada la compra te enviaremos un email con el código de seguimiento del envío.
							    </h6>
							    <div class="row card-row">
							    	<?php if($loggedIn): ?>
							    	<div class="col-xs-12 is-clickable option-regular">
						          <div class="d-inline">
						          	<span class="h4">Cliente</span><br>
						          	<p class="mt-2 text-muted"><?= $userData['User']['name'] ?> <?= $userData['User']['surname'] ?> (DNI <?= $userData['User']['dni'] ?>)</p>
			                  <div class="d-flex justify-content-start mt-2 gap-05">
			                    <div data-toggle="modal" data-target="#particular-modal" class="card-link">
			                      <i class="fa fa-user-o fa-lg mr-1"></i>
			                       Cambiar datos
			                    </div>
			                    <div onclick="$('.checkoutform-container').removeClass('hide');$('input[name=street]').focus()" class="card-link">
			                      <i class="fa fa-map-marker fa-lg mr-1"></i>
			                       Cambiar dirección
			                    </div>
			                  </div>
						        	</div>				          
						        </div>
						      	<?php endif ?>
							    	<div class="col-xs-12 option-regular">
						          <div class="d-inline">
						          	<span class="h4">Subtotal productos</span><br>
						          	<p class="mt-2 h3 text-muted mb-0">
						          		$ <span class="subtotal_price"></span>
                    		</p>
                    	</div>
                    </div>						        
							    	<div class="col-xs-12 option-regular shipping-block hide">
						          <div class="d-inline">
						          	<span class="h4 text-success free-shipping-block<?= $freeShipping ? '' : ' hidden' ?>">Envío gratis</span>
												<div class="paid-shipping-block<?= $freeShipping ? ' hidden' : '' ?>">
							          	<span class="h4">Costo de envío</span><br>
							          	<p class="mt-2">
							          		<span class="shipping_price text-bold h3 text-muted mb-0"></span>
													<?php if($loggedIn): ?>
												    <br><br><span> Entrega <span class="shipping text-uppercase"></span> en 
												    	<?= $userData['User']['street'] ?: $userData['User']['address'] ?> <?= $userData['User']['street_n'] ?: '' ?>, <?= $userData['User']['city'] ?> <?= $userData['User']['province'] ?> (<?= $this->Session->read('cp') ?>) 
												    </span>
												  <?php endif ?>
												  	<br><a href="/carrito#f:.shipment-options.takeaway" class="card-link">
												    	<i class="fa fa-car fa-lg mr-1"></i> Retirar en sucursal
												    </a>
							          	</p>
							          </div>
						        	</div>
						        	<p class="mt-2 text-muted">El monto mínimo para obtener beneficio <b>envío gratis</b> es de $ <?= number_format($shipping_price, 2, ',', '.') ?></p>
						        </div>  
							    	<div class="col-xs-12 option-regular cargo-takeaway hide">
						          <div class="d-inline">
						          	<span class="h4">Retiro en sucursal</span><br>
						          	<p class="mt-2"> Elegiste retirarlo en 
						          		<span class="text-bold store_address"></span>
                    			<span class="text-bold store"></span>. 
                    			<?= $data['carrito_takeaway_text'] ?>
                    		</p>
                    	</div>
		                  <div class="d-flex justify-content-start mt-2">
		                    <a href="/carrito#f:.shipment-options.shipping" class="card-link">
		                      <i class="fa fa-truck fa-lg mr-1"></i>
		                       Solicitar envío
		                    </a>
		                  </div>
                    </div>
							    	<div class="col-xs-12 option-regular bank-block hide">
						          <label class="d-inline text-theme">
						          	<span class="h4">Descuento pago Transferencia</span><br>
						          	<p class="mt-2 text-bold text-success h2 mb-0">
						          		$ <span class="bank_bonus"></span>
						          	</p>
						          </span>
						        </div>
										<div class="col-xs-12 option-regular coupon-discount hidden animated speed">
						          <label class="d-inline text-theme">
						          	<span class="h4">Descuento Cupón</span><br>
						          	<p class="mt-2 text-bold text-left h2 mb-0">
						          		<span class="coupon_bonus"></span>
						          	</p>
						          </label>
											<div class="coupon-info alert mt-4 mb-0 alert-success animated hidden">
												<p>
													<i class="fa fa-tags"></i>
													<span class="coupon-info-info"></span>
												</p>
											</div>
										</div>
							    	<div class="col-xs-12 option-regular cost_total-container">
						          <label class="d-inline text-theme">
						          	<span class="h4">Total a pagar</span><br>
						          	<p class="mt-2 text-bold text-left h2 mb-0">
						          		<span class="calc_total"></span>
						          	</p>
						          </span>
						        </div>
						      </div>

									<!--div class="row card-row flex-row justify-content-start p-3 mt-2 gap-05">
								  	<a href="/carrito#f:.beneficios-exclusivos" class="card-link coupon-actions-block hide">
								  		<i class="fa fa-tag fa-lg mr-1"></i>
								  		Ingresar cupón
								  	</a>
								  </div-->
									<div class="pt-3 min-h-5">
										<div class="coupon-click d-flex justify-content-start align-items-center gap-1 is-clickable p-4" onclick="showCouponInput()">
											<div class="png-icon" style="background-image: url(/images/gift-voucher.png)"></div> 
											<span class="text-italic">Si tenés un cupón de descuento podés aplicarlo haciendo <span class="text-dark is-clickable">click aquí.</span></span>
										</div>
										<div class="calc-coupon d-none">
											<div class="d-flex justify-content-center align-items-center gap-05">
										  	<input type="text" id="coupon_name" name="coupon" placeholder="Tu cupón" value="" class="form-control input-coupon input-lg both" title="Ingresá el código de tu cupón" data-valid="0" autocomplete="off" />
									    	<button id="btn-calculate-coupon" class="btn btn-outline-danger btn-input-lg btn-calculate-coupon" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" title="Aplicá este cupón a tu compra" type="button" onclick="submitCoupon()">Calcular</button>
									    	<span class="muted is-clickable text-muted" onclick="resetCoupon()">Cancelar</span>
											</div>
										</div>
									</div>								  
								</div>
							</div>
						</div>
					</div>
					<div class="carrito-col min-max-30 m-w-auto">
						<div class="card">
						  <div class="card-body">
						    <h5 class="card-title">
						    	<!--i class="fa fa-credit-card"></i-->
						    	¿Cómo querés pagar tu compra?
						    </h5>
						    <h6 class="card-subtitle">Total a pagar <span class="calc_total"></span>.  Seleccioná un método de pago para realizar esta compra</h6>
						    <div class="row card-row gap-05 payment_method pl-3 pr-3">
						    	<label for="mercadopago" class="col-xs-12 is-clickable select-payment-option option-rounded<?= !@$config['payment_method'] || @$config['payment_method'] === 'mercadopago' ? ' is-selected': '' ?>">
						    		<input type="radio" id="mercadopago" name="payment_method" value="mercadopago" required <?= !@$config['payment_method'] || @$config['payment_method'] === 'mercadopago' ?  'checked': '' ?>/>
					          	<span class="h4">Mercado Pago</span><br>
					          	<p class="mt-2 text-small">Pagá con débito, crédito o rapipago a través de Mercadopago</p>
				        	</label>				          
					      <?php if($data['bank_enable']): ?>
					        <label for="bank" class="col-xs-12 is-clickable select-payment-option option-rounded<?= @$config['payment_method'] === 'bank' ? ' is-selected': '' ?>">
					          <input type="radio" class="" id="bank" name="payment_method" value="bank" required  <?= @$config['payment_method'] === 'bank' ?  'checked': '' ?>/>
				          	<span class="h4">Transferencia</span><br>
				          	<p class="mt-2 text-small">Pagá a través de transferencia bancaria con tu home banking</p>
				          </label>
					       <?php endif ?>
				        </div>
						  </div>
						</div>
					<?php if(count($legends) && $this->App->show_legends($legends)): ?>
						<div class="payment-dues card mt-4-d animated scaleIn">
						  <div class="card-body">
						    <h5 class="card-title">
						    	<!--i class="fa fa-calendar-o"></i-->
						    	¿Querés financiar tu compra?
						    </h5>
						    <h6 class="card-subtitle">Seleccioná la cantidad de cuotas en que te gustaría realizar esta compra</h6>
						    <div class="row card-row gap-05 pl-3 pr-3">
					        <!--label for="dues_1" class="col-xs-12 is-clickable option-rounded is-selected" onclick="select_dues(event,this)">
					          <input type="radio" class="" id="dues_1" name="payment_dues" value="1" required checked />
				          	<span class="h4"> 1 cuota</span><br>
				          	<p class="mt-2 text-small">1 cuota de <span class="total_price calc_total"></span></p>
				          </label-->
						    <?php foreach($legends as $legend): ?>
						    	<?php if($total >= @$legend['Legend']['min_sale']):?>
						    	<label for="dues_<?= @$legend['Legend']['dues'] ?>" class="col-xs-12 is-clickable option-rounded <?= $legend['Legend']['dues'] == 1 ? 'is-selected' : 'is-secondary' ?><?= @$config['payment_method'] !== 'bank' ? '' : ' hide' ?>"  data-interest="<?= @$legend['Legend']['interest'] ?>" onclick="select_dues(event,this)">
						    	<input type="radio" id="dues_<?= @$legend['Legend']['dues'] ?>" name="payment_dues" value="<?= @$legend['Legend']['dues'] ?>" <?= $legend['Legend']['dues'] == 1 ? 'checked' : '' ?>/>
					          	<span class="h4"> <?= @$legend['Legend']['dues'] ?> cuota<?= @$legend['Legend']['dues'] > 1 ? 's' : '' ?></span><br>
					          	<p class="mt-2 text-small calc-dues" data-dues="<?= @$legend['Legend']['dues'] ?>" data-interest="<?= @$legend['Legend']['interest'] ?>"><?= 
								str_replace([
				                    '{cuotas}','{interes}','{monto}'
				                ], [
				                    $legend['Legend']['dues'],
				                    $legend['Legend']['interest'],
				                    '$ ' . \price_format(ceil($total * (((float) $legend['Legend']['interest'] / 100) + 1 ) / (int) $legend['Legend']['dues']))
				                ],
				                $legend['Legend']['title']) ?></p>
				        	</label>
				        	<?php endif ?>
			        	<?php endforeach ?>
				        </div>
						  </div>
						</div>						
					<?php endif ?>
						<div class="mt-4-d checkoutform-container">
							<div class="card pt-3">
								<div class="card-body">
							    <h5 class="card-title">
										<!--i class="fa fa-user"></i-->
										Ingresá tus datos para finalizar tu compra
							    </h5>
							    <h6 class="card-subtitle">Asegurate de verificar y actualizar tus datos correctos para que tu compra llegue a tu domicilio antes y mejor. <?php if(!$loggedIn):?><a href="#" data-toggle="modal" data-target="#particular-login">Iniciar sesión</a><?php endif ?></h6>
									<input type="hidden" name="shipping" value=""/>
									<input type="hidden" name="coupon" value=""/>
									<input type="hidden" name="cargo" value=""/>
									<input type="hidden" name="store" value=""/>
									<input type="hidden" name="postal_address" value="<?= $this->Session->read('cp') ?>"/>
									<input type="hidden" name="store_address" value=""/>
									<input type="hidden" name="gifts" value=""/>
									<div class="is-rounded-content">
										<div class="form-group">
											<label for="nombre">Nombre</label>
											<input type="text" class="form-control" id="nombre" name="name" value="<?= (!empty($userData['User']['name']))?$userData['User']['name']:''; ?>" required>
										</div>
										<div class="form-group">
											<label for="apellido">Apellido</label>
											<input type="text" class="form-control" id="apellido" name="surname" value="<?= (!empty($userData['User']['surname']))?$userData['User']['surname']:''; ?>" required>
										</div>
										<div class="form-group">
											<label for="dni">DNI</label>
											<input type="number" class="form-control" id="dni" name="dni" value="<?= (!empty($userData['User']['dni']))? str_replace('.', '', $userData['User']['dni']):''; ?>" required>
										</div>
										<div class="form-group">
											<label for="email">Email</label>
											<input type="email" class="form-control" id="email" name="email" value="<?= (!empty($userData['User']['email']))?$userData['User']['email']:''; ?>" required>
										</div>
										<div class="form-group">
											<label for="telefono">Teléfono</label>
											<input type="tel" class="form-control" id="telefono" name="telephone" value="<?= (!empty($userData['User']['telephone']))?$userData['User']['telephone']:''; ?>" required>
										</div>
										<div class="form-group">
											<label for="direccion">Provincia</label>
											<select class="form-control" name="provincia" autocomplete="off">
												<option value=""></option>
												<?php foreach ($provincias as $key => $value): ?>
													<option value="<?php echo $value['provincia']; ?>"<?= isset($userData['User']) && strtoupper($value['provincia']) == strtoupper($userData['User']['province']) ? '  selected' : ''?>><?php echo ucfirst($value['provincia']) ?></option>
												<?php endforeach ?>
											</select>
										</div>
										<div class="form-group">
											<label for="direccion">Localidad</label>
											<input type="text" class="form-control" name="localidad" value="<?= isset($userData['User']) ? $userData['User']['city'] : '' ?>" required>
										</div>
										<span class="clearfix"></span>
										<div class="form-group">
											<label for="direccion">Calle y Número</label>
											<input style="width:75%;float:left;" type="text" class="form-control" placeholder="Riobamba" id="calle" name="street" value="<?= @$userData['User']['street'] ?>" required>
											<input style="margin-left:1%;width:24%;float:left;" min="0" class="form-control" placeholder="1234" name="street_n" type="number" value="<?= @$userData['User']['street_n'] ?>"/>
										</div>
										<span class="clearfix"></span>
										<div class="form-group">
											<label for="direccion">Piso y Departamento</label>
											<input style="margin-right:1%;width:49%;float:left;" min="0" class="form-control" placeholder="1,2,3..." name="floor" type="number" value="<?=(!empty($userData['User']['floor']))?$userData['User']['floor']:''; ?>"/>
											<input style="margin-left:1%;width:49%;float:left;" class="form-control" placeholder="A,B,C..." name="depto" type="text" value="<?= (!empty($userData['User']['depto']))?$userData['User']['depto']:''; ?>"/>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>					
				</div>
			</div>
		</div>
		<div class="button-group-fixed-bottom animated slideInUp delay2">
			<div class="d-flex justify-content-center align-items-center gap-1 text-center option-regular">
				<span class="text-theme h3 m-0">Total a pagar <span class="calc_total"></span></span>
			</div>
			<div class="d-flex justify-content-center align-items-center gap-05 pt-3">
				<?php
					echo $this->Html->link('Ver carrito', array(
						'controller' => 'carrito',
						'action' => 'index'
					), array(
						'class' => 'btn cart-btn-green',
						'escape' => false
					));
				?>			
				<button type="button" id="submitcheckoutbutton" class="btn cart-btn-green checkout-btn btn-pink">
					Finalizar compra
				</button>
				<input type="submit" id="submitform" class="hidden-force" />
			</div>
		</div>
	</form>
</div>
<script>

$(function(){
	<?php if(!$loggedIn):?>	
	setTimeout(() => {
		$('#particular-login').modal('show')
	}, 1000)
	<?php endif;?>
	var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
	setTimeout(() => {
		$('#<?= @$config['payment_method'] ?: 'mercadopago'?>').click()
	}, 100)
	if(carrito.gifts && carrito.gifts.length) {
		$('#gifts').val(carrito.gifts.join(','))
	}
})
</script>
