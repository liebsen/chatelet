<?php #echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php 
echo $this->Html->script('form_app.js?v=' . $version['ver'], array('inline' => false)); 
echo $this->element('admin/menu');
?>
<?php #echo $this->Html->script('newsletter-config.js?v=' . $version['ver'], array('inline' => false)); ?>
	<form action="" method="post" id="form_app" class="form-inline">
	  <input type="hidden" name="x_coord" id="x_coord">
	  <input type="hidden" name="y_coord" id="y_coord">			
		<div class="row">
      <div class="col-md-6">
        <h4 class="sub-header">Configuración de Banners</h4>
				<p>Establece coniguración para Banners.</p>
        <div class="control-group">
          <label class="control-label" for="columns-text"><?php echo __('Tiempo de intevalo'); ?></label>
          <div class="controls">
            <input type="number" max="100" min="0" name="data[banners_interval]" class="form-control" placeholder="10" value="<?= @$settings['banners_interval'] ?? 10 ?>"/>
          </div>
          <small class="text-muted">Tiempo de intervalo en segundos.</small>
        </div>
      </div>
		</div>
    <br />               
    <div class="form-actions">
      <a href="/admin/cupones" class="btn btn-info"><i class="fa fa-chevron-left"></i> <span class="ml-1">Atrás</span></a>
      <button type="submit" class="btn btn-success track-coords" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check"></i> <span class="ml-1">Guardar</span></button>
    </div>
  </form>
