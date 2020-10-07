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
                <input type="radio" name="data[value]" value="default" <?php if (!empty($setting['Setting']['value'] == 'default')){ echo "checked=checked"; } ?> /> - Envíos gratis a partir de <b><?php echo $price['Setting']['value']; ?></b> pesos, se genera etiqueta en todas las compras
            </p>
            <p>
                <input type="radio" name="data[value]" value="no_label" <?php if (!empty($setting['Setting']['value'] == 'no_label')){ echo "checked=checked"; } ?> /> - En envíos gratis a partir de <b><?php echo $price['Setting']['value']; ?></b> pesos, no se genera etiqueta en los códigos postales determinados que se hace envío interno
            </p>
            <p>
                <input type="radio" name="data[value]" value="free" <?php if (!empty($setting['Setting']['value'] == 'free')){ echo "checked=checked"; } ?> /> - Envíos gratis sin monto mínimo, se genera etiqueta en todos los casos.
            </p>
            <p>
                <input type="radio" name="data[value]" value="zip_code" <?php if (!empty($setting['Setting']['value'] == 'zip_code')){ echo "checked=checked"; } ?> /> - Envío gratis sin monto mínimo, no se genera etiqueta en los códigos postales determinados que se hace envío interno.
            </p>
            </div><br />       
                <small>Ingrese el monto mínimo</small> 
                  <br />
                  <input type="number" name="shipping_price_min" value="<?php echo $price['Setting']['value']; ?>"/>
                  <br /> 
                <small>Ingrese los codigos postales separados por coma (,) - [Actualmente <strong><?=$amount?></strong> códigos]</small><br />
                <textarea rows="4" name="data[zip_code]"><?php echo $setting['Setting']['extra']; ?></textarea>
                <br />

      <div class="form-actions">
        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Guardar</button>
      </div>
          </div>          
      </div>      
      
    </form>
  </div>
</div>