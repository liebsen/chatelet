<?php $mc_lists = \get_mc_lists() ?>
<?php echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php echo $this->Html->script('custom-tabs.js?v=' . Configure::read('APP_VERSION'), array('inline' => false)); ?>
<?php echo $this->Html->script('jquery.growl.js?v=' . Configure::read('APP_VERSION'), array('inline' => false)); ?>
<?php echo $this->Html->script('mailchimp.js?v=' . Configure::read('APP_VERSION'), array('inline' => false)); ?>
<?php echo $this->Html->script('application-form.js?v=' . Configure::read('APP_VERSION'), array('inline' => false)); ?>
<?php echo $this->Html->css('jquery.growl.css?v=' . Configure::read('APP_VERSION')) ?>

	<form action="" id="form_app" method="post" class="form-inline" enctype="multipart/form-data">
    <div class="custom-tabs block-tabs">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="active text-center">
          <a href="#keys">
            APP Keys
          </a>
        </li>
        <li class="text-center">
          <a href="#lists">
            Listas
          </a>
        </li>
      </ul>
      <div class="tab-content p-7">
        <div class="tab-pane pane-keys active">
        	<div class="row">
        		<div class="col-md-6">
			        <h4 class="sub-header">Mailchimp APP Keys</h4>
			        <p>Aquí podrás darle acceso a la tienda hacia Mailchimp. Estos datos se generan desde la plataforma de <a href="https://us12.admin.mailchimp.com/account/api/">Mailchimp</a>.</p>
			        <div class="control-group">
			          <label class="control-label d-flex justify-content-start align-items-center gap-05" for="mailchimp_on">
			          	<input type="checkbox" id="mailchimp_on" name="data[mailchimp_on]" <?php echo $settings['mailchimp_on'] == 'on' ? ' checked' : '' ?>>
			          	Activo
			          </label>
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

				<div class="tab-pane pane-lists">
	        <h4 class="sub-header">Manejo de listas</h4>
	        <p>Proporciona el código público del sitio para todos los servicios. </p>
		      <?php foreach($mc_lists as $item): ?>
		        <div class="control-group">
		          <label class="control-label d-flex justify-content-start align-items-center gap-05" for="<?php echo $item ?>_on">
		          	<input type="checkbox" id="<?php echo $item ?>_on" name="data[mc_<?php echo $item ?>_on]" <?php echo $settings['mc_'.$item.'_on'] == 'on' ? ' checked' : '' ?>>
		          	<?php echo __(ucfirst($item)); ?>
		          </label>
		          <div class="controls">
		          	<select class="form-control mc-select" name="data[mc_<?php echo $item ?>]" data-selected="<?php echo @$settings['mc_'.$item] ?>" data-type="<?= $item == 'store' ? 'store' : 'list' ?>"><option>...</option></select>
		          </div>
		          <span class="text-muted">Ingresá el ID correspondiente para la acción <?php echo __($item); ?></span>
		        </div>
		      	<br>
		      <?php endforeach ?>
    		</div>
    	</div>
	    <br />      
	    <div class="form-actions">
	      <a href="/admin/cupones" class="btn btn-info"><i class="fa fa-chevron-left mr-1"></i> Atrás</a>
	      <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario" disabled><i class="fa fa-check mr-1"></i> Guardar</button>
	    </div>
	  </div>
	</form>

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
