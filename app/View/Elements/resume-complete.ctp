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
								</div>
							</div>