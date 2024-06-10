<?php
  echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
  echo $this->Html->css('bootstrap-datepicker', array('inline' => false));
?>
<div class="block block-themed">
  <div class="block-title">
    <h4>Configuración de carrito</h4>
  </div>

  <div class="block-content">
    <form action="" method="post" class="form-inline">
      <div class="row">
        <div class="col-md-6">
          <h4 class="sub-header">Información Principal</h4>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Mostrar texto en carrito cuando no se alcance el precio de envío gratis'); ?></label>

            <div class="controls text-center switch-scale">
              <?php
                $enabled = $data['display_text_shipping_min_price'] == 1 ? 'checked' : '';
                $disabled = $data['display_text_shipping_min_price'] == 0 ? 'checked' : '';
              ?>
              <label for="enabled_1">Sí</label>
              <input type="radio" class="form-control" id="enabled_1" name="data[display_text_shipping_min_price]" value="1" <?php echo $enabled; ?> /> &nbsp;
              <label for="enabled_0">No</label>
              <input type="radio" class="form-control" id="enabled_0" name="data[display_text_shipping_min_price]" value="0" <?php echo $disabled; ?> />
            </div>
            <span class="text-muted">Indica si debe mostrarse un mensaje para alentar al cliente a obtener un envío gratis agregando más productos a su carrito.</span>
          </div>            
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Carrito envío gratis'); ?></label>
            <div class="controls">
              <textarea name="text_shipping_min_price" class="form-control w-100"><?= @$data['text_shipping_min_price'] ?></textarea>
            </div>
            <span class="text-muted">texto que se muestra en el carrito cuando el usuario no alcanza el mínimo de compra para envío gratis. Podés usar variables como <br>
<strong>{{precio_min_envio_gratis}}</strong> Monto de compra para envío gratis <br>
<strong>{{resto_min_envio_gratis}}</strong> Monto que falta para alcanzar el mínimo de envío gratos <br>
<strong>{{total}}</strong> Total del carrito. </span>
          </div>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Carrito takeaway'); ?></label>
            <div class="controls">
              <textarea name="carrito_takeaway_text" class="form-control w-100"><?= @$data['carrito_takeaway_text'] ?></textarea>
            </div>
            <span class="text-muted">texto que se muestra en el carrito cuando el usuario selecciona método de entrega takeaway.</span>
          </div>  
        </div> 
        <div class="col-md-6"></div>
      </div>
      <br />               
      <div class="form-actions">
        <a href="/admin/cupones" class="btn btn-info"><i class="icon-repeat"></i> Atrás</a>
        <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="icon-ok"></i> Guardar</button>
      </div>
    </form>
  </div>
</div>