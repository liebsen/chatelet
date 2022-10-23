<?php
	echo $this->Html->css('checkout.css?v=' . Configure::read('DIST_VERSION'), array('inline' => false));
	echo $this->Session->flash();
	echo $this->Html->script('checkout_sale.js?v=' . Configure::read('DIST_VERSION'),array('inline' => false));
?>
<script>
	const carrito_items = <?php echo json_encode($this->Session->read('Carro'), JSON_PRETTY_PRINT);?>;
	const bank = {enable: <?= isset($data['bank_enable']) ? $data['bank_enable'] : 0 ?>,discount_enable: <?= isset($data['bank_discount_enable']) ? $data['bank_discount_enable'] : 0 ?>,discount: <?= isset($data['bank_discount']) ? $data['bank_discount'] : 0 ?>}
</script>
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
							    	Revisá el resumen de tu compra.
							    </h6>
							    <div class="row card-row">
							    	<?php if($loggedIn): ?>
							    	<div class="col-xs-12 is-clickable option-regular">
						          <label class="d-inline">
						          	<span class="h4">Cliente</span><br>
						          	<p class="mt-2"><?= $userData['User']['name'] ?> <?= $userData['User']['surname'] ?> (DNI <?= $userData['User']['dni'] ?>)</p>
										    <span class="card-link is-clickable" onclick="$('input[name=street]').focus()" class="cargo-shipment hide">
										    	<i class="fa fa-map-marker"></i>
										    	Modificar dirección
										    </span>
						        	</label>				          
						        </div>
						      	<?php endif ?>
							    	<div class="col-xs-12 option-regular">
						          <label class="d-inline">
						          	<span class="h4">Subtotal productos</span><br>
						          	<p class="mt-2 text-bold h4 mb-0">
						          		$<span class="subtotal_price"></span>
                    		</p>
                    	</label>
                    </div>						        
							    	<div class="col-xs-12 option-regular shipping-block hide">
						          <label class="d-inline">
											<?php if($freeShipping): ?>
						          	<span class="h4 text-success">Envío gratis</span>
											<?php else: ?>
						          	<span class="h4">Costo de envío</span><br>
						          	<p class="mt-2">
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
						          <?php endif ?>
						        	</label>				          
						        </div>  
							    	<div class="col-xs-12 option-regular cargo-takeaway hide">
						          <label class="d-inline">
						          	<span class="h4">Retiro en sucursal</span><br>
						          	<p class="mt-2"> Elegiste retirarlo en 
						          		<span class="text-bold store_address"></span>
                    			<span class="text-bold store"></span>. 
                    			<?= $data['carrito_takeaway_text'] ?>
											    <a href="/carrito#f:.shipment-options.shipping" class="card-link">
											    	<i class="fa fa-truck"></i> Solicitar envío 
											    </a>
                    		</p>
                    	</label>
                    </div>
							    	<div class="col-xs-12 option-regular coupon-block hide">
						          <label class="d-inline">
						          	<span class="h4">Descuento <span class="coupon"></span></span><br>
						          	<p class="mt-2 text-bold text-success h4 mb-0">
						          		$<span class="coupon_bonus"></span>
						          	</p>
						          </span>
						        </div>
							    	<div class="col-xs-12 option-regular bank-block hide">
						          <label class="d-inline">
						          	<span class="h4">Descuento CBU/Alias</span><br>
						          	<p class="mt-2 text-bold text-success h4 mb-0">
						          		$<span class="bank_bonus"></span>
						          	</p>
						          </span>
						        </div>
							    	<div class="col-xs-12 option-regular">
						          <label class="d-inline text-muted">
						          	<span class="h4">Total a pagar</span><br>
						          	<p class="mt-2 text-bold h3 mb-0">
						          		$<span class="total_price"></span>
						          	</p>
						          </span>
						        </div>
						      </div>
									<label class="form-group mt-4">
									  <input type="checkbox" id="regalo" name="regalo"><span class="label-text">Es para regalo</span><br><br>
									</label>
									<div class="row card-row">
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
						    <h6 class="card-subtitle">Total $<span class="total_price"></span>.  Seleccioná un método de pago</h6>
						    <div class="row card-row payment-method">
						    	<label for="mercadopago" class="col-xs-12 is-clickable option-rounded<?= !$data['bank_enable'] ? ' is-selected': '' ?>" onclick="select_payment(this)">
						    		<input type="radio" id="mercadopago" name="payment_method" value="mercadopago" required <?= !$data['bank_enable'] ? 'checked': '' ?>/>
					          	<span class="h4">Mercado Pago</span><br>
					          	<p class="mt-2 text-small">Pagá con débito, crédito, rapipago través de Mercadopago</p>
				        	</label>				          
					      <?php if($data['bank_enable']): ?>
					        <label for="bank" class="col-xs-12 is-clickable option-rounded" onclick="select_payment(this)">
					          <input type="radio" class="" id="bank" name="payment_method" value="bank" required />
				          	<span class="h4">CBU/Alias</span><br>
				          	<p class="mt-2 text-small">Pagá a través de transferencia bancaria con tu home banking</p>
				          </label>
					       <?php endif ?>
				        </div>
						  </div>
						</div>
						<div class="mt-4-d checkoutform-container">
							<div class="is-rounded">
								<h3 class="">Ingresá tus datos para finalizar la compra</h3>
								<input type="hidden" name="shipping" value=""/>
								<input type="hidden" name="coupon" value=""/>
								<input type="hidden" name="cargo" value=""/>
								<input type="hidden" name="store" value=""/>
								<input type="hidden" name="postal_address" value="<?= $this->Session->read('cp') ?>"/>
								<input type="hidden" name="store_address" value=""/>
								<div class="is-rounded-content">
									<div class="form-group">
										<label class="ml-2" for="nombre">Nombre</label>
										<input type="text" class="form-control" id="nombre" name="name" value="<?= (!empty($userData['User']['name']))?$userData['User']['name']:''; ?>" required>
									</div>
									<div class="form-group">
										<label class="ml-2" for="apellido">Apellido</label>
										<input type="text" class="form-control" id="apellido" name="surname" value="<?= (!empty($userData['User']['surname']))?$userData['User']['surname']:''; ?>" required>
									</div>
									<div class="form-group">
										<label class="ml-2" for="dni">DNI</label>
										<input type="number" class="form-control" id="dni" name="dni" value="<?= (!empty($userData['User']['dni']))? str_replace('.', '', $userData['User']['dni']):''; ?>" required>
									</div>
									<div class="form-group">
										<label class="ml-2" for="email">Email</label>
										<input type="email" class="form-control" id="email" name="email" value="<?= (!empty($userData['User']['email']))?$userData['User']['email']:''; ?>" required>
									</div>
									<div class="form-group">
										<label class="ml-2" for="telefono">Teléfono</label>
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
										<label class="ml-2" for="direccion">Localidad</label>
										<input type="text" class="form-control" name="localidad" value="<?= isset($userData['User']) ? $userData['User']['city'] : '' ?>" required>
									</div>
									<span class="clearfix"></span>
									<div class="form-group">
										<label class="ml-2" for="direccion">Calle y Número</label>
										<input style="width:75%;float:left;" type="text" class="form-control" placeholder="Riobamba" id="calle" name="street" value="<?= (!empty($userData['User']['street']))?$userData['User']['street']: !empty($userData['User']['address'])?$userData['User']['address']: ''; ?>" required>
										<input style="margin-left:1%;width:24%;float:left;" min="0" class="form-control" placeholder="1234" name="street_n" type="number" value="<?=(!empty($userData['User']['street_n']))?$userData['User']['street_n']:''; ?>" required/>
									</div>
									<span class="clearfix"></span>
									<div class="form-group">
										<label class="ml-2" for="direccion">Piso y Departamento</label>
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
				<input type="submit" onclick="$('.checkoutform-container').removeClass('hide')" class="btn cart-btn-green checkout-btn" value="Finalizar compra" />
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
