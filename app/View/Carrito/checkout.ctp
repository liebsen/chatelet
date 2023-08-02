<?php 
	echo $this->Session->flash();
  echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
  echo $this->Html->css('bootstrap-datepicker', array('inline' => false));
	echo $this->Html->css('checkout.css?v=' . Configure::read('DIST_VERSION'), array('inline' => false));
	echo $this->Html->script('carrito-lib.js?v=' . Configure::read('DIST_VERSION'), array('inline' => false));	
	echo $this->Html->script('checkout_sale.js?v=' . Configure::read('DIST_VERSION'),array('inline' => false));
	echo $this->element('carrito');
?>
<script>
	var shipping_price = <?= $shipping_price ?>;
	var carrito_config = <?php echo json_encode($this->Session->read('Config'), JSON_PRETTY_PRINT);?>;
	var carrito_items = <?php echo json_encode(array_values($this->Session->read('Carro')), JSON_PRETTY_PRINT);?>;
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
<div id="main" class="container">
	<form role="form" method="post" id="checkoutform" autocomplete="off" action="<?php echo $this->Html->url(array(
				'controller' => 'carrito',
				'action' => 'sale'
			)) ?>">

		<div class="row">
			<div class="col-md-12 mt-8 text-center">
				<?php
					echo $this->Html->link('Volver al carrito', array(
						'controller' => 'carrito',
						'action' => 'index'
					), array(
						'class' => 'btn cart-btn-green',
						'escape' => false
					));
				?>
			</div>	
		</div>
		<div class="row">
			<div id="carrito">
				<div class="carrito-row">
					<div class="carrito-col">
						<div class="carrito-items">
						<?php if($loggedIn): ?>
							<!--div class="col-12">
								<div class="card">
								  <div class="card-body">
								    <h5 class="card-title">
								    	<i class="fa fa-user"></i>
								    	<?= $userData['User']['name'] ?> <?= $userData['User']['surname'] ?>
								    </h5>
								    <h6 class="card-subtitle">DNI <?= $userData['User']['dni'] ?></h6>
								    <p class="card-text"><?= $userData['User']['email'] ?></p>
								    <span class="card-link is-clickable" onclick="$('input[name=street]').focus()" class="card-link">Modificar</span>
								  </div>
								</div>
							</div-->
						<?php endif ?>						
							<!--div class="col-xs-12 mt-4-d cargo-takeaway hide">
								<div class="card">
								  <div class="card-body">
								    <h5 class="card-title">
								    	<i class="fa fa-car"></i>
								    	Retiro en sucursal
								    </h5>
								    <h6 class="card-subtitle">
								    	<span class="store_address"></span>
								    	<span class="store"></span>								    	
								    </h6>
								    <p class="card-text">
								    	<?= $data['carrito_takeaway_text'] ?>
								    </p>
								    <a href="/carrito#f:.como-queres-recibir-tu-compra" class="card-link">Solicitar envío a domicilio</a>
								    <a href="/carrito#f:.shipment-options.takeaway" class="card-link">Modificar</a>
								  </div>
								</div>
							</div-->
							<div class="card">
							  <div class="card-body">
							    <h5 class="card-title">
							    	<i class="fa fa-pencil"></i>
							    	Resumen de tu compra
							    </h5>
							    <h6 class="card-subtitle">
							    	Acá podés ver el resumen de tu compra. Luego de efectuada la compra te enviaremos un email con el código de seguimiento del envío.
							    </h6>
							    <div class="row card-row">
							    	<?php if($loggedIn): ?>
							    	<div class="col-xs-12 is-clickable option-regular">
						          <label class="d-inline">
						          	<span class="h4">Cliente</span><br>
						          	<p class="mt-2 text-muted"><?= $userData['User']['name'] ?> <?= $userData['User']['surname'] ?> (DNI <?= $userData['User']['dni'] ?>)</p>
			                  <div class="row card-row flex-row justify-content-center mt-3 gap-05">
			                    <span data-toggle="modal" data-target="#particular-modal" class="card-link">
			                      <i class="fa fa-user-o"></i>
			                       Modificar datos
			                    </span>
			                    <span onclick="$('.checkoutform-container').removeClass('hide');$('input[name=street]').focus()" class="card-link">
			                      <i class="fa fa-map-marker"></i>
			                       Modificar dirección
			                    </span>
			                  </div>
						        	</label>				          
						        </div>
						      	<?php endif ?>
							    	<div class="col-xs-12 option-regular">
						          <label class="d-inline">
						          	<span class="h4">Subtotal productos</span><br>
						          	<p class="mt-2 text-bold h4 mb-0">
						          		$ <span class="subtotal_price"></span>
                    		</p>
                    	</label>
                    </div>						        
							    	<div class="col-xs-12 option-regular shipping-block hide">
						          <label class="d-inline">
						          	<span class="h4 text-success free-shipping-block<?= $freeShipping ? '' : ' hidden' ?>">Envío gratis</span>
												<div class="paid-shipping-block<?= $freeShipping ? ' hidden' : '' ?>">
							          	<span class="h4">Costo de envío</span><br>
							          	<p class="mt-2 text-muted">
							          		<span class="shipping_price text-bold h4 mb-0"></span>
													<?php if($loggedIn): ?>
												    <br><br><span> Entrega <span class="shipping text-uppercase"></span> en 
												    	<?= $userData['User']['street'] ?: $userData['User']['address'] ?> <?= $userData['User']['street_n'] ?: '' ?>, <?= $userData['User']['city'] ?> <?= $userData['User']['province'] ?> (<?= $this->Session->read('cp') ?>) 
												    </span>
												  <?php endif ?>
												  	<br><a href="/carrito#f:.shipment-options.takeaway" class="card-link">
												    	<i class="fa fa-truck"></i> Retirar en sucursal
												    </a>
							          	</p>
							          </div>
						        	</label>
						        	<p class="mt-2 text-muted">El monto mínimo para obtener beneficio <b>envío gratis</b> es de $ <?= $shipping_price ?></p>
						        </div>  
							    	<div class="col-xs-12 option-regular cargo-takeaway hide">
						          <label class="d-inline">
						          	<span class="h4">Retiro en sucursal</span><br>
						          	<p class="mt-2 text-muted"> Elegiste retirarlo en 
						          		<span class="text-bold store_address"></span>
                    			<span class="text-bold store"></span>. 
                    			<?= $data['carrito_takeaway_text'] ?>
                    		</p>
                    	</label>
		                  <div class="row card-row mt-3">
		                    <a href="/carrito#f:.shipment-options.shipping" class="card-link">
		                      <i class="fa fa-truck"></i>
		                       Solicitar envío
		                    </a>
		                  </div>
                    </div>
							    	<div class="col-xs-12 option-regular coupon-block hide">
						          <label class="d-inline">
						          	<span class="h4">Descuento <span class="coupon"></span></span><br>
						          	<p class="mt-2 text-bold text-success h4 mb-0">
						          		$ <span class="coupon_bonus"></span>
						          	</p>
						          </span>
						        </div>
							    	<div class="col-xs-12 option-regular bank-block hide">
						          <label class="d-inline">
						          	<span class="h4">Descuento pago Transferencia</span><br>
						          	<p class="mt-2 text-bold text-success h4 mb-0">
						          		$ <span class="bank_bonus"></span>
						          	</p>
						          </span>
						        </div>
							    	<div class="col-xs-12 option-regular">
						          <label class="d-inline text-theme">
						          	<span class="h4">Total a pagar</span><br>
						          	<p class="mt-2 text-bold total-price text-left h3 mb-0">
						          		$ <span class="total_price"></span>
						          	</p>
						          </span>
						        </div>
						      </div>
									<label class="form-group mt-4">
									  <input type="checkbox" id="regalo" name="regalo"><span class="label-text text-muted">Es para regalo</span><br><br>
									</label>
									<div class="row card-row flex-row justify-content-center mt-3 gap-05">
								  	<a href="/carrito#f:.beneficios-exclusivos" class="card-link coupon-actions-block hide">
								  		<i class="fa fa-tag"></i>
								  		Ingresar cupón
								  	</a>
								  </div>
								</div>
							</div>				
						</div>
					</div>
					<div class="carrito-col">
						<div class="card">
						  <div class="card-body">
						    <h5 class="card-title">
						    	<i class="fa fa-credit-card"></i>
						    	¿Cómo querés pagar tu compra?
						    </h5>
						    <h6 class="card-subtitle">Total $ <span class="total_price"></span>.  Seleccioná un método de pago para realizar esta compra</h6>
						    <div class="row card-row payment_method pl-3 pr-3">
						    	<label for="mercadopago" class="col-xs-12 is-clickable option-rounded<?= !@$config['payment_method'] || @$config['payment_method'] === 'mercadopago' ? ' is-selected': '' ?>" onclick="select_payment(event,this)">
						    		<input type="radio" id="mercadopago" name="payment_method" value="mercadopago" required <?= !@$config['payment_method'] || @$config['payment_method'] === 'mercadopago' ?  'checked': '' ?>/>
					          	<span class="h4">Mercado Pago</span><br>
					          	<p class="mt-2 text-small">Pagá con débito, crédito o rapipago a través de Mercadopago</p>
				        	</label>				          
					      <?php if($data['bank_enable']): ?>
					        <label for="bank" class="col-xs-12 is-clickable option-rounded<?= @$config['payment_method'] === 'bank' ? ' is-selected': '' ?>" onclick="select_payment(event,this)">
					          <input type="radio" class="" id="bank" name="payment_method" value="bank" required  <?= @$config['payment_method'] === 'bank' ?  'checked': '' ?>/>
				          	<span class="h4">Transferencia</span><br>
				          	<p class="mt-2 text-small">Pagá a través de transferencia bancaria con tu home banking</p>
				          </label>
					       <?php endif ?>
				        </div>
						  </div>
						</div>
					<?php if(count($legends)): ?>
						<div class="card mt-4-d">
						  <div class="card-body">
						    <h5 class="card-title">
						    	<i class="fa fa-calendar-o"></i>
						    	¿Querés financiar tu compra?
						    </h5>
						    <h6 class="card-subtitle">Seleccioná la cantidad de cuotas en que te gustaría realizar esta compra</h6>
						    <div class="row card-row payment_dues pl-3 pr-3">
					        <label for="dues_1" class="col-xs-12 is-clickable option-rounded is-selected" onclick="select_dues(event,this)">
					          <input type="radio" class="" id="dues_1" name="payment_dues" value="1" required checked />
				          	<span class="h4"> 1 cuota</span><br>
				          	<p class="mt-2 text-small">1 cuota de $ <?= \price_format($total) ?></p>
				          </label>						    	
						    <?php foreach($legends as $legend): ?>
						    	<?php if($total >= $legend['Legend']['min_sale']):?>
						    	<label for="dues_<?= $legend['Legend']['dues'] ?>" class="col-xs-12 is-clickable option-rounded is-secondary"  data-interest="<?= $legend['Legend']['interest'] ?>" onclick="select_dues(event,this)">
						    		<input type="radio" id="dues_<?= $legend['Legend']['dues'] ?>" name="payment_dues" value="<?= $legend['Legend']['dues'] ?>" required/>
					          	<span class="h4"> <?= $legend['Legend']['dues'] ?> cuotas</span><br>
					          	<p class="mt-2 text-small"><?= 
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
						<div class="mt-4-d checkoutform-container hide">
							<div class="is-rounded pt-3">
						    <h5 class="card-title">
									<i class="fa fa-user"></i>
									Ingresá tus datos para finalizar la compra
						    </h5>
						    <h6 class="card-subtitle">Asegurate de verificar y actualizar tus datos correctos para que tu compra llegue a tu domicilio antes y mejor.</h6>
								<input type="hidden" name="shipping" value=""/>
								<input type="hidden" name="coupon" value=""/>
								<input type="hidden" name="cargo" value=""/>
								<input type="hidden" name="store" value=""/>
								<input type="hidden" name="postal_address" value="<?= $this->Session->read('cp') ?>"/>
								<input type="hidden" name="store_address" value=""/>
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
										<input style="margin-left:1%;width:24%;float:left;" min="0" class="form-control" placeholder="1234" name="street_n" type="number" value="<?= @$userData['User']['street_n'] ?>" required/>
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
		<div class="row mt-4">
			<div class="col-md-12 mt-3 text-center">
				<button type="button" id="submitcheckoutbutton" class="btn cart-btn-green checkout-btn">
					Finalizar compra
				</button>
				<input type="submit" id="submitform" class="hidden-force" />
			</div>
		</div>
	</form>
</div>
<script>
<?php if(!$loggedIn):?>	
$(function(){
	setTimeout(() => {
		$('#particular-login').modal('show')
	}, 1000)
})
<?php endif;?>
</script>
