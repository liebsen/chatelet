<?php
  echo $this->Html->css('sucursales-detail', array('inline' => false));
?>
<?php echo $this->element('admin-menu');?>
<div class="block-tabs">
  <div class="tab-content">
    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-12">
          <h4 class="sub-header">Configuración de Envíos</h4> 
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Tipo de envío'); ?></label>
            <div class="controls">
              <div class="d-flex flex-start gap-1">
                <input class="form-control" type="radio" name="data[shipping_type]" id="default" value="default" <?php if (!empty($settings['shipping_type'] == 'default')){ echo "checked=checked"; } ?> /> <label class="is-clickable flex-1" for="default">Envío normal</label>
              </div>
              <div class="d-flex flex-start gap-1">
                <input class="form-control" type="radio" name="data[shipping_type]" id="min_price" value="min_price" <?php if (!empty($settings['shipping_type'] == 'min_price')){ echo "checked=checked"; } ?> /> <label class="is-clickable flex-1" for="min_price">Envío gratuito para compra mínima [<b><?php echo $settings['shipping_price_min']; ?></b> pesos]</label>
              </div>
              <div class="d-flex flex-start gap-1">
                <input class="form-control" type="radio" name="data[shipping_type]" id="zip_code" value="zip_code" <?php if (!empty($settings['shipping_type'] == 'zip_code')){ echo "checked=checked"; } ?> /> <label  class="is-clickable flex-1" for="zip_code">Envío gratuito para código postal. Monto mínimo permanece activo si el valor es mayor a cero. [<b><?=count(explode(',',$settings['shipping_zips'])) ?></b> códigos postales]</label>
              </div>
            </div>
          </div>
          <br />     
          <div class="show-panel<?php echo $settings['shipping_type'] == 'default' ? ' show-inactive' : '' ?>">
            <small>Ingrese el monto mínimo. <span class="dummy-sub-block<?php echo $settings['shipping_type'] != 'zip_code' ? ' show-inactive' : '' ?>">Ingrese valor cero para deshabilitar monto mínimo. </span></small> 
            <br />
            <input class="form-control" type="number" name="data[shipping_price_min]" value="<?php echo $settings['shipping_price_min']; ?>"/>
            <br /> 
            <div class="show-panel<?php echo $settings['shipping_type'] != 'zip_code' ? ' show-inactive' : '' ?>">
              <small>Ingrese los codigos postales separados por coma (,) - [Actualmente <strong><?=$amount?></strong> códigos]</small><br />
              <textarea class="form-control" name="data[shipping_zips]" rows="8"><?php echo $settings['shipping_zips']; ?></textarea>
            </div>
          </div>
          <br />
          <div class="form-actions">
            <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
          </div>
        </div>          
      </div>      
    </form>
  </div>
</div>
