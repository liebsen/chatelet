<?php echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php echo $this->Html->script('custom-tabs.js?v=' . $version['ver'], array('inline' => false)); ?>
<?php echo $this->Html->script('jquery.growl.js?v=' . $version['ver'], array('inline' => false)); ?>
<?php echo $this->Html->script('marketing.js?v=' . $version['ver'], array('inline' => false)); ?>
<?php echo $this->Html->script('application-form.js?v=' . $version['ver'], array('inline' => false)); ?>
<?php echo $this->Html->css('jquery.growl.css?v=' . $version['ver']) ?>
	<?php echo $this->element('admin-menu');?>

	<div class="block">
		<div class="block-content">
			<form action="" id="form_app" method="post" class="form-inline" enctype="multipart/form-data">
		    <div class="custom-tabs block-tabs">
		      <!--ul class="nav nav-tabs" id="myTab" role="tablist">
		        <li class="active text-center">
		          <a href="#charts">
		            Análisis
		          </a>
		        </li>
		        <li class="text-center">
		          <a href="#sales">
		            Compras
		          </a>
		        </li>
		        <li class="text-center">
		          <a href="#emails">
		            Emails
		          </a>
		        </li>
		        <li class="text-center">
		          <a href="#schedule">
		            Calendario
		          </a>
		        </li>
		      </ul-->

		      <div class="tab-content">
		        <div class="tab-pane pane-products active">
		        	<div class="row">
		        		<div class="col-md-12">
					        <h4 class="sub-header">Analíticas de la tienda</h4>
					        <p>El objetivo de este componente es analizar qué productos son los mas elegidos a la hora de comprar</p>
									<div class="form-group">
										<label class="control-label" for="columns-text"><?php echo __('Activo'); ?></label>
										<input type="checkbox" name="data[mailchimp_on]" value="1" id="toggle" class="toggle-checkbox"<?= $settings['mailchimp_on'] == '1' ? ' checked' : '' ?>>
										<label for="toggle" class="toggle-label"></label>
									</div>		
				          <hr>	        
					        <div class="control-group">
					          <label class="control-label" for="columns-text"><?php echo __('APP Key'); ?></label>
					          <div class="controls">
					            <input type="text" maxlength="100" name="data[mailchimp_appkey]" class="form-control" value="<?php echo @$settings['mailchimp_appkey'] ?>"/>
					          </div>
					          <span class="text-muted">Ingresa la APP Key de Mailchimp para esta aplicación</span>
					        </div>
					        <div class="control-group">
					          <label class="control-label" for="columns-text"><?php echo __('Server prefix'); ?></label>
					          <div class="controls">
					            <input type="text" maxlength="100" name="data[mailchimp_prefix]" class="form-control" value="<?php echo @$settings['mailchimp_prefix'] ?>"/>
					          </div>
					          <span class="text-muted">Ingresa Server prefix de Mailchimp para esta aplicación (ej:us12)</span>
					        </div>
								</div>
							</div>
						</div>

						<div class="tab-pane pane-sales">
							<div class="row">
								<div class="col-md-12">
									<h4 class="sub-header">Compras</h4>
									<p>El objetivo de este componente es analizar qué productos son los mas elegidos a la hora de comprar</p>
								</div>
							</div>
						</div>
						<div class="tab-pane pane-emails">
		        	<div class="row">
		        		<div class="col-md-12">
					        <h4 class="sub-header">Compone tus emails</h4>
					        <p>Estos son los emails que has creado</p>
					      <?php foreach($emails as $id => $item): ?>
									<div class="d-flex flex-start gap-05">
										<div class="controls flex-1" style="min-width: 8rem;">
											<label class="control-label" for="columns-text"><?php echo __(ucfirst($item)); ?></label>
											<input type="checkbox" id="toggle_<?php echo $id ?>" name="data[mc_<?php echo $id ?>_on]" value="1" id="toggle" class="toggle-checkbox"<?= $settings['mc_'.$id.'_on'] == '1' ? ' checked' : '' ?>>
											<label for="toggle_<?php echo $id ?>" class="toggle-label"></label>
										</div>
					          <div class="controls">
					          	<select class="form-control mc-select" name="data[mc_<?php echo $id ?>]" data-selected="<?php echo @$settings['mc_'.$id] ?>" data-type="<?= $id == 'store' ? 'store' : 'list' ?>"><option>...</option></select>
					          </div>
					        </div>
					        <hr>
					      <?php endforeach ?>
						    </div>
						  </div>
		    		</div>
		    	</div>
			    <br />      
			    <div class="form-actions">
			      <a href="/admin/cupones" class="btn btn-info"><i class="fa fa-chevron-left mr-1"></i> Atrás</a>
			      <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario" disabled><i class="fa fa-check mr-1"></i> Guardar</button>
			    </div>
			  </div>
			</form>
		</div>
	</div>

<style type="text/css">		
	.iframe {
	  overflow: hidden;
	  resize: both;
	}
	iframe {
	  height: 100%;
	  width: 100%;
	  border: none;
	}		
</style>
