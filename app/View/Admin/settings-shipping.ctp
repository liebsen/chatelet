<?php
echo $this->Html->css('sucursales-detail', array('inline' => false));
echo $this->Html->script('form_app.js?v=' . $version['ver'], array('inline' => false));
?>
<?php echo $this->element('admin/menu');?>
<div class="block-section">
  <div class="block-tabs">
    <div class="tab-content">
      <form action="" id="form_app" method="post" class="form-inline" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-12 p-0">
            <h4 class="sub-header">Configuración de Envíos</h4> 
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Tipo de envío'); ?></label>
              <hr>
              <div class="controls">
                  <input class="form-control" type="radio" name="data[shipping_type]" id="default" value="default" <?php if (!empty($settings['shipping_type'] == 'default')){ echo "checked=checked"; } ?> /> <label class="is-clickable" for="default">Envío normal</label>

                  <input class="form-control" type="radio" name="data[shipping_type]" id="min_price" value="min_price" <?php if (!empty($settings['shipping_type'] == 'min_price')){ echo "checked=checked"; } ?> /> <label class="is-clickable" for="min_price">Envío gratuito para compra mínima [<?php echo $settings['shipping_price_min']; ?> pesos]</label>

                  <input class="form-control" type="radio" name="data[shipping_type]" id="zip_code" value="zip_code" <?php if (!empty($settings['shipping_type'] == 'zip_code')){ echo "checked=checked"; } ?> /> <label  class="is-clickable" for="zip_code">Envío gratuito para código postal. Monto mínimo permanece activo si el valor es mayor a cero. [<?=count(explode(',',$settings['shipping_zips'])) ?> códigos postales]</label>
                </div>
              </div>
            </div>
            <br />     
            <div class="show-panel<?php echo $settings['shipping_type'] == 'default' ? ' d-disable' : '' ?>">
              <small>Ingrese el monto mínimo. <span class="dummy-sub-block<?php echo $settings['shipping_type'] != 'zip_code' ? ' d-disable' : '' ?>">Ingrese valor cero para deshabilitar monto mínimo. </span></small> 
              <br />
              <input class="form-control" type="number" name="data[shipping_price_min]" value="<?php echo $settings['shipping_price_min']; ?>"/>
              <br /> 
              <div class="show-panel<?php echo $settings['shipping_type'] != 'zip_code' ? ' d-disable' : '' ?>">
                <small>Ingrese los codigos postales separados por coma (,) - [Actualmente <strong><?=$amount?></strong> códigos]</small><br />
                <textarea class="form-control" name="data[shipping_zips]" rows="8"><?php echo $settings['shipping_zips']; ?></textarea>
              </div>
            </div>
            <br />
            <div class="form-actions">
              <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check"></i> <span class="ml-1">Guardar</span></button>
            </div>
          </div>          
        </div>      
      </form>
    </div>
  </div>
</div>
