				      <div class="row">
				        <div class="col-md-12">
				        	<select class="form-control" id="notification_tag">
				        		<option value="">Elige una notificación para continuar</option>
				        		<?php foreach($notification_tags as $key => $tag): ?>
				        			<option value="<?=$key?>"><?=$tag?></option>
				        		<?php endforeach ?> 
				        	</select>
				        	<hr>
				        </div>
				        <div class="col-md-12 w-100">
				        	<div class="notification-controls d-none w-100">
					        	<div class="form-group  w-100">
											<p class="text-theme">Notifica al cliente con el estado de su compra.</p>
					        		<textarea class="form-control" id="notification_value" rows="8"></textarea>
											<p class="text-theme">Tabla de variables disponibles</p>
											<table class="table text-sm">
<?php foreach($notification_templates as $id => $name): ?>
										<tr class="is-clickable btn-append-editor" data-text="{{<?= $id ?>}}">
											<th>
												<small class="text-lowercase">
													<i class="fa fa-key text-warning"></i> <?= $id ?>
												</small>
											</th>
											<td>
												<small>
													<i class="gi gi-chat text-muted"></i> <?= $name ?>
												</small>
											</td>
										</tr>
<?php endforeach ?>
											</table>
					        	</div>
					        </div>
				        </div>
				    	</div>