<script>
const carrito = <?php echo json_encode($this->Session->read('Carro'), JSON_PRETTY_PRINT);?>
</script>
<?php
	echo $this->Html->css('checkout', array('inline' => false));
	echo $this->Session->flash();
	echo $this->Html->script('checkout_sale',array('inline' => false));
?>
<div id="main" class="container">
	<form role="form" method="post" id="checkoutform" action="<?php echo $this->Html->url(array(
				'controller' => 'carrito',
				'action' => 'sale'
			)) ?>">

		<div class="row">
			<div class="col-md-12 text-center">
				<?php
					echo $this->Html->link('Volver al carrito', array(
						'controller' => 'carrito',
						'action' => 'index'
					), array(
						'class' => 'cart-btn-green',
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
							<div class="col-12 cargo-shipment hide">
								<div class="card">
								  <div class="card-body">
								    <h5 class="card-title">
								    	<i class="fa fa-truck"></i>
								    	Envía <span class="shipping text-uppercase"></span> </h5>
								    <h6>
								    	<span class="shipping_price"></span>			    	
								    </h6>
								  <?php if($loggedIn): ?>
								    <p class="card-text"><?= $userData['User']['street'] ?: $userData['User']['address'] ?> <?= $userData['User']['street'] ? $userData['User']['street_n'] : '' ?>, <?= $userData['User']['city'] ?> <?= $userData['User']['province'] ?> (<?= $this->Session->read('cp') ?>)</p>
								  <?php endif ?>
								    <a href="/carrito" class="card-link">Modificar</a>
								    <span class="card-link is-clickable" onclick="toggleform()" class="card-link">Modificar dirección</span>
								  </div>
								</div>
							</div>
							<div class="col-12 cargo-takeaway hide">
								<div class="card">
								  <div class="card-body">
								    <h5 class="card-title">
								    	<i class="fa fa-building-o"></i>
								    	Retiro en sucursal
								    </h5>
								    <h6>
								    	<span class="store"></span>
								    	<span class="store_address"></span>			    	
								    </h6>
								    <p class="card-text">
								    	<?= $data['carrito_takeaway_text'] ?>
								    </p>
								    <a href="/carrito" class="card-link">Modificar</a>
								  </div>
								</div>
							</div>

							<div class="col-12 mt-4">
								<div class="card">
								  <div class="card-body">
								    <h5 class="card-title">
								    	<i class="fa fa-credit-card"></i>
								    	¿Cómo querés pagar tu compra?
								    </h5>
								    <h6>Seleccioná un método de pago</h6>
								    <div class="row payment-method">
								    	<div class="col-sm-6 text-center option-rounded">
								    		<input type="radio" class="" id="enabled_1" name="payment_method" value="mercadopago" required />
							          <label for="enabled_1" class="d-inline">
							          	<span class="h4">Online</span><br>
							          	<p class="mt-4 text-small">Pagá a través de Mercadopago con débito, crédito, rapipago y más</p>
							        	</label>				          
							        </div>
							        <div class="col-sm-6 offset-md-1 text-center option-rounded">				          
							          <input type="radio" class="" id="enabled_0" name="payment_method" value="bank" required />
							          <label for="enabled_0" class="d-inline">
							          	<span class="h4">Transferencia</span><br>
							          	<p class="mt-4 text-small">Pagá a través de transferencia bancaria con tu home banking</p>
							          </label>
							        </div>
						        </div>
								  </div>
								</div>
							</div>
						</div>
					</div>
					<div class="carrito-col">
					<?php if($loggedIn): ?>
						<div class="col-12">
							<div class="card">
							  <div class="card-body">
							    <h5 class="card-title">
							    	<i class="fa fa-user"></i>
							    	<?= $userData['User']['name'] ?> <?= $userData['User']['surname'] ?>
							    </h5>
							    <h6>DNI <?= $userData['User']['dni'] ?></h6>
							    <p class="card-text"><?= $userData['User']['email'] ?></p>
							    <span class="card-link is-clickable" onclick="toggleform()" class="card-link">Modificar</span>
							  </div>
							</div>
						</div>
					<?php endif ?>						
						<div class="col-12  mt-4 checkoutform-container<?= !empty($userData['User']['id']) ? ' hide' : '' ?>">
							<div class="row is-rounded">
								<h3 class="">Ingresá tus datos para finalizar la compra</h3>
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
										<input style="width:75%;float:left;" type="text" class="form-control" placeholder="Riobamba" id="calle" name="street" value="<?= (!empty($userData['User']['street']))?$userData['User']['street']:''; ?>" required>
										<input style="margin-left:1%;width:24%;float:left;" min="0" class="form-control" placeholder="1234" name="street_n" type="number" value="<?=(!empty($userData['User']['street_n']))?$userData['User']['street_n']:''; ?>" required/>
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


						<div class="col-12 mt-4 center">
							<label class="form-group">
							  <input type="checkbox" id="regalo" name="regalo"><span class="label-text">Es para regalo</span><br><br>
							</label>
						</div>
					</div>					
				</div>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-md-12 mt-3 text-center">
				<input type="submit" onclick="$('.checkoutform-container').removeClass('hide')" class="cart-btn-green" value="Finalizar compra" />
			</div>
		</div>
	</form>
</div>
<script>
<?php if(!$loggedIn):?>	
$(function(){
	$('#particular-login').modal('show')
})
<?php endif;?>
</script>
