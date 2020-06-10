<?php
  echo $this->Html->css('sucursales-detail', array('inline' => false));
?>
<?php echo $this->element('admin-menu');?>
<div class="block block-themed">
  <div class="block-title">
    <h4>
    Envios
    </h4>
  </div>

  <div class="block-content">
    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
    <input type="hidden" name="data[id]" value="shipping_type" />
      <div class="row">
        <div class="col-md-4">
          <h4 class="sub-header">Configuración de Envíos</h4> 
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Tipo de envío'); ?></label>
            <div class="controls">
            <p>
                <input type="radio" name="data[value]" value="default" <?php if (!empty($setting['Setting']['value'] == 'default')){ echo "checked=checked"; } ?> /> - Envíos gratis a partir de 3500 pesos, se genera etiqueta en todas las compras
            </p>
            <p>
                <input type="radio" name="data[value]" value="no_label" <?php if (!empty($setting['Setting']['value'] == 'no_label')){ echo "checked=checked"; } ?> /> - En envíos gratis a partir de 3500 pesos, no se genera etiqueta en los códigos postales determinados que se hace envío interno
            </p>
            <p>
                <input type="radio" name="data[value]" value="free" <?php if (!empty($setting['Setting']['value'] == 'free')){ echo "checked=checked"; } ?> /> - Envíos gratis sin monto mínimo, se genera etiqueta en todos los casos.
            </p>
            <p>
                <input type="radio" name="data[value]" value="zip_code" <?php if (!empty($setting['Setting']['value'] == 'zip_code')){ echo "checked=checked"; } ?> /> - Envío gratis sin monto mínimo, no se genera etiqueta en los códigos postales determinados que se hace envío interno.
                <br />
                <small>Ingrese los codigos postales separados por coma (,)</small><br />
                <textarea rows="4" name="data[zip_code]"></textarea>
            </p>
            </div>
          </div>          
      </div>      
      <br />               
      <div class="form-actions">
        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Guardar</button>
      </div>
    </form>
  </div>
</div>