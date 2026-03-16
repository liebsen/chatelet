<?php
  echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
  echo $this->Html->css('bootstrap-datepicker', array('inline' => false));
  echo $this->Html->script('admin-carrito', array('inline' => false));
  echo $this->element('admin-menu'); 
?>

<div class="block">
  <!--div class="block-title">
    <h4>Configuración de carrito</h4>
  </div-->

  <div class="block-content">
    <form action="" method="post" class="form-inline">
      <div class="row">
        <div class="col-md-6">
          <h4 class="sub-header">Información Principal</h4>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Mostrar texto en carrito cuando no se alcance el precio de envío gratis'); ?></label>
            <div class="form-group">
              <input type="checkbox" name="data[display_text_shipping_min_price]" value="1" id="toggle2" class="toggle-checkbox"<?=@$settings['display_text_shipping_min_price'] == '1' ? ' checked' : '' ?>>
              <label for="toggle2" class="toggle-label"></label>
            </div>     
            <small class="text-theme">Indica si debe mostrarse un mensaje para alentar al cliente a obtener un envío gratis agregando más productos a su carrito.</small>
          </div>            
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Carrito envío gratis'); ?></label>
            <div class="controls">
              <span class="text-theme">texto que se muestra en el carrito cuando el usuario no alcanza el mínimo de compra para envío gratis</span>
              <textarea name="text_shipping_min_price" id="text_shipping_min_price" class="form-control w-100" rows="5"><?= @$settings['text_shipping_min_price'] ?></textarea>
            </div>
            <h6 class="text-theme">Tabla de variables disponibles</h6>
            <table class="table table-striped">
              <tr class="is-clickable btn-append-editor" data-text="{{precio_min_envio_gratis}}">
                <th>
                  <small class="text-lowercase">
                    <i class="fa fa-key text-warning"></i> precio_min_envio_gratis
                  </small>
                </th>
                <td>
                  <small>
                    <i class="gi gi-chat text-muted"></i> Monto de compra para envío gratis
                  </small>
                </td>
              </tr>
              <tr class="is-clickable btn-append-editor" data-text="{{resto_min_envio_gratis}}">
                <th>
                  <small class="text-lowercase">
                    <i class="fa fa-key text-warning"></i> resto_min_envio_gratis
                  </small>
                </th>
                <td>
                  <small>
                    <i class="gi gi-chat text-muted"></i> Monto que falta para alcanzar el mínimo de envío gratos
                  </small>
                </td>
              </tr>
              <tr class="is-clickable btn-append-editor" data-text="{{total}}">
                <th>
                  <small class="text-lowercase">
                    <i class="fa fa-key text-warning"></i> total
                  </small>
                </th>
                <td>
                  <small>
                    <i class="gi gi-chat text-muted"></i> Total del carrito
                  </small>
                </td>
              </tr>
            </table>
          </div>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Carrito takeaway'); ?></label>
            <div class="controls">
              <textarea name="carrito_takeaway_text" class="form-control w-100" rows="5"><?= @$settings['carrito_takeaway_text'] ?></textarea>
            </div>
            <span class="text-theme">texto que se muestra en el carrito cuando el usuario selecciona método de entrega takeaway.</span>
          </div>  
        </div> 
        <div class="col-md-6">
          <h4 class="sub-header">Duración (horas)</h4>
          <div class="control-group">
            <span class="text-theme">La tienda revisa cuando el carrito fue actualizado por última vez, así podemos evitar procesar información desactualizada. Establece las horas de vida que cada carrito tendrá.</span>

            <input type="text" name="carrito_life_hours" class="form-control w-100" value="<?= @$settings['carrito_life_hours'] ?>" />
          </div>
        </div>
      </div>
      <br />               
      <div class="form-actions">
        <a href="/admin/cupones" class="btn btn-info"><i class="fa fa-chevron-left mr-1"></i> Atrás</a>
        <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
      </div>
    </form>
  </div>
</div>