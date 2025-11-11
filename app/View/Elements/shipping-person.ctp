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
											<!--label for="nombre">Nombre</label-->
											<input type="text" class="form-control" placeholder="Nombre" title="Nombre" id="nombre" name="name" value="<?= (!empty($userData['User']['name']))?$userData['User']['name']:''; ?>" required>
										</div>
										<div class="form-group">
											<!--label for="apellido">Apellido</label-->
											<input type="text" class="form-control" placeholder="Apellidos" title="Apellidos" id="apellido" name="surname" value="<?= (!empty($userData['User']['surname']))?$userData['User']['surname']:''; ?>" required>
										</div>
										<div class="form-group">
											<!--label for="dni">DNI</label-->
											<input type="number" class="form-control" placeholder="DNI" title="DNI" id="dni" name="dni" value="<?= (!empty($userData['User']['dni']))? str_replace('.', '', $userData['User']['dni']):''; ?>" required>
										</div>
										<div class="form-group">
											<!--label for="email">Email</label-->
											<input type="email" class="form-control" placeholder="Email" title="Email" id="email" name="email" value="<?= (!empty($userData['User']['email']))?$userData['User']['email']:''; ?>" required>
										</div>
										<div class="form-group">
											<!--label for="telefono">Teléfono</label-->
											<input type="tel" class="form-control" placeholder="Teléfono" title="Teléfono" id="telefono" name="telephone" value="<?= (!empty($userData['User']['telephone']))?$userData['User']['telephone']:''; ?>" required>
										</div>
										<div class="form-group">
											<!--label for="direccion">Provincia</label-->
											<select class="form-control" title="Provincia" name="provincia" autocomplete="off">
												<option value="">Seleccione una Provincia</option>
												<?php foreach ($provincias as $key => $value): ?>
													<option value="<?php echo $value['provincia']; ?>"<?= isset($userData['User']) && strtoupper($value['provincia']) == strtoupper($userData['User']['province']) ? '  selected' : ''?>><?php echo ucfirst($value['provincia']) ?></option>
												<?php endforeach ?>
											</select>
										</div>
										<div class="form-group">
											<!--label for="direccion">Localidad</label-->
											<input type="text" class="form-control" title="Localidad" placeholder="Localidad" name="localidad" value="<?= isset($userData['User']) ? $userData['User']['city'] : '' ?>" required>
										</div>
										<span class="clearfix"></span>
										<div class="form-group">
											<!--label for="direccion">Calle y Número</label-->
											<input style="width:65%;float:left;" type="text" class="form-control" placeholder="Calle" title="Calle" id="calle" name="street" value="<?= @$userData['User']['street'] ?>" required>
											<input style="margin-left:0.5rem;width:32%;float:left;" min="0" class="form-control" placeholder="Nro." title="Nro." name="street_n" type="number" value="<?= @$userData['User']['street_n'] ?>"/>
										</div>
										<span class="clearfix"></span>
										<div class="form-group">
											<!--label for="direccion">Piso y Departamento</label-->
											<input style="margin-right:1%;width:47%;float:left;" min="0" class="form-control" placeholder="Piso" title="Piso" name="floor" type="number" value="<?=(!empty($userData['User']['floor']))?$userData['User']['floor']:''; ?>"/>
											<input style="margin-left:0.5rem;width:48%;float:left;" title="Depto" class="form-control" placeholder="Depto" name="depto" type="text" value="<?= (!empty($userData['User']['depto']))?$userData['User']['depto']:''; ?>"/>
										</div>
									</div>
								</div>
							</div>