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
        <div class="col-md-8">
          <h4 class="sub-header">Configuración de Envíos</h4> 
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Tipo de envío'); ?></label>
            <div class="controls">
            <p>
              <input class="form-control" type="radio" name="data[value]" id="default" value="default" <?php if (!empty($setting['Setting']['value'] == 'default')){ echo "checked=checked"; } ?> /> <label  class="is-clickable" for="default">Envío normal</label>
            </p>
            <p>
              <input class="form-control" type="radio" name="data[value]" id="min_price" value="min_price" <?php if (!empty($setting['Setting']['value'] == 'min_price')){ echo "checked=checked"; } ?> /> <label  class="is-clickable" for="min_price">Envío gratuito para compra mínima [<b><?php echo $price['Setting']['value']; ?></b> pesos]</label>
            </p>
            <p>
              <input class="form-control" type="radio" name="data[value]" id="zip_code" value="zip_code" <?php if (!empty($setting['Setting']['value'] == 'zip_code')){ echo "checked=checked"; } ?> /> <label  class="is-clickable" for="zip_code">Envío gratuito para código postal. Monto mínimo permanece activo si el valor es mayor a cero. [<b><?=$amount?></b> códigos postales]</label>
            </p>
          </div>
          <br />     
          <div class="dummy-block<?php echo $setting['Setting']['value'] == 'default' ? ' dummy-block-hidden' : '' ?>">
            <small>Ingrese el monto mínimo. <span class="dummy-sub-block<?php echo $setting['Setting']['value'] != 'zip_code' ? ' dummy-block-hidden' : '' ?>">Ingrese valor cero para deshabilitar monto mínimo. </span></small> 
            <br />
            <input class="form-control" type="number" name="shipping_price_min" value="<?php echo $price['Setting']['value']; ?>"/>
            <br /> 
            <div class="dummy-sub-block<?php echo $setting['Setting']['value'] != 'zip_code' ? ' dummy-block-hidden' : '' ?>">
              <small>Ingrese los codigos postales separados por coma (,) - [Actualmente <strong><?=$amount?></strong> códigos]</small><br />
              <textarea class="form-control" rows="4" name="data[zip_code]"><?php echo $setting['Setting']['extra']; ?></textarea>
            </div>
          </div>
          <br />
          <div class="form-actions">
            <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="icon-ok"></i> Guardar</button>
          </div>
        </div>          
      </div>      
    </form>
  </div>
</div>
<style>
  .dummy-block {
    display: block;
  }
  .dummy-block-hidden {
    display: none;
  }
</style>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[name="data[value]"]').forEach(e => {
      var b = document.querySelector('.dummy-block')
      var c = document.querySelector('.dummy-sub-block')
      e.addEventListener('change', (a) => {
        b.classList.remove('dummy-block-hidden')
        c.classList.add('dummy-block-hidden')
        if (a.target.value === 'default') {
          b.classList.add('dummy-block-hidden')
        }
        if (a.target.value === 'zip_code') {
          c.classList.remove('dummy-block-hidden')
        }
      })
    })
  })
</script>