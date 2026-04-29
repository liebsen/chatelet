<?php echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php echo $this->Html->script('custom-tabs.js?v=' . $version['ver'], array('inline' => false)); ?>
<?php echo $this->Html->script('jquery.growl.js?v=' . $version['ver'], array('inline' => false)); ?>
<?php echo $this->Html->script('application-form.js?v=' . $version['ver'], array('inline' => false)); ?>
<?php echo $this->Html->css('jquery.growl.css?v=' . $version['ver']) ?>
	
	<div class="block">
		<div class="block-content">
			<form action="" id="form_app" method="post" class="form-inline" enctype="multipart/form-data">
		    <div class="custom-tabs block-tabs">
		      <ul class="nav nav-tabs" id="myTab" role="tablist">
		        <li class="active text-center">
		          <a href="#keys">
		            Configuración
		          </a>
		        </li>
		      </ul>
		      <div class="tab-content">
		        <div class="tab-pane pane-keys active">
		        	<div class="row">
		        		<div class="col-md-12">
					        <h4 class="sub-header">Entradas de configuración de la tienda</h4>
					        <p>Aquí podrás editar todas las entradas de configuración de la tienda. Te recomendamos que crees un respaldo de datos antes de modificar algo.</p>
					      <?php foreach($items as $item): ?>
									<div class="form-group">
										<label class="control-label" for="columns-text"><?php echo __(ucfirst($item['Setting']['id'])); ?></label>
									</div>
									<div class="d-flex flex-center gap-05">
									<?php if(substr($item['Setting']['id'], -3) == '_on') :?>
										<div class="controls flex-1 mt-1">
											<input type="checkbox" id="toggle_<?php echo $item['Setting']['id'] ?>" name="data[<?php echo $item['Setting']['id'] ?>]" value="1" id="toggle" class="toggle-checkbox"<?= $item['Setting']['value'] == '1' ? ' checked' : '' ?>>
											<label for="toggle_<?php echo $item['Setting']['id'] ?>" class="toggle-label"></label>
										</div>
									<?php elseif(substr($item['Setting']['id'], -5) == '_text') :?>
					          <div class="controls">
					            <textarea maxlength="100" name="data[<?php echo $item['Setting']['id'] ?>]" class="form-control" placeholder="Modifica el valor para la entrada de configuración <?php echo __($item['Setting']['id']); ?>" rows="8"><?php echo @$item['Setting']['value'] ?></textarea>
					          </div>
									<?php else: ?>
					          <div class="controls">
					            <input type="text" maxlength="100" name="data[<?php echo $item['Setting']['id'] ?>]" class="form-control" value="<?php echo @$item['Setting']['value'] ?>" placeholder="Modifica el valor para la entrada de configuración <?php echo __($item['Setting']['id']); ?>"/>
					          </div>
					        <?php endif ?>
					        </div>
					      	<hr>
					      <?php endforeach ?>
								</div>
							</div>
						</div>
					</div>
			    <div class="form-actions">
			      <a href="/admin/cupones" class="btn btn-info"><i class="fa fa-chevron-left mr-1"></i> Atrás</a>
			      <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario" disabled><i class="fa fa-check"></i> <span class="ml-1">Guardar</span></button>
			    </div>
			  </div>
			</form>
		</div>
	</div>
