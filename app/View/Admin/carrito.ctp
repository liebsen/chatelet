<?php
  echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
  // echo $this->Html->script('cupones-detail', array('inline' => false));
  // echo $this->Html->css('cupones-detail', array('inline' => false));
  echo $this->Html->css('bootstrap-datepicker', array('inline' => false));
  ?>
<?php // echo $this->Html->script('admin-sales', array('inline' => false)); ?>
<?php // echo $this->element('admin-menu');?>
<div class="block block-themed">
  <div class="block-title">
    <h4>Configuración de carrito</h4>
    </h4>
  </div>

  <div class="block-content">
    <form action="" method="post" class="form-inline">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <h4 class="sub-header">Información Principal</h4>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Mostrar texto en carrito cuando no se alcance el precio de envío gratis'); ?></label>

              <div class="controls">
                <?php
                  $enabled = $data['display_text_shipping_min_price'] == 1 ? 'checked' : '';
                  $disabled = $data['display_text_shipping_min_price'] == 0 ? 'checked' : '';
                ?>
                <label for="enabled_1">Activo</label>
                <input type="radio" class="form-control" id="enabled_1" name="data[display_text_shipping_min_price]" value="1" <?php echo $enabled; ?> /> &nbsp;
                <label for="enabled_0">Inactivo</label>
                <input type="radio" class="form-control" id="enabled_0" name="data[display_text_shipping_min_price]" value="0" <?php echo $disabled; ?> />
              </div>
              <small class="text-muted">Indica si debe mostrarse un mensaje para alentar al cliente a obtener un envío gratis agregando más productos a su carrito.</small>
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
          <div class="col-md-6">
            <h4 class="sub-header">Información bancaria</h4>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Datos bancarios'); ?></label>
              <div class="controls">
                <input name="onlinebanking_explain_title" class="form-control w-100" value="<?= @$data['onlinebanking_explain_title'] ?>"/>
              </div>
              <span class="text-muted">Título antes de mostrar los datos bancarios. (Ej: Datos para completar tu compra)</span>              
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Desarrolla Datos bancarios'); ?></label>
              <div class="controls">
                <textarea name="onlinebanking_explain_text" class="form-control w-100"><?= @$data['onlinebanking_explain_text'] ?></textarea>
              </div>
              <span class="text-muted">Indica los datos de cuenta bancaria para que los clientes puedan pagar via trasnferencia. Ej: CBU, Alias, etc... </span>
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Instrucciones de la operación'); ?></label>
              <div class="controls">
                <input name="onlinebanking_instructions_title" class="form-control w-100" value="<?= @$data['onlinebanking_instructions_title'] ?>"/>
              </div>
              <span class="text-muted">Título antes de mostrar los datos bancarios. (Ej: Datos para completar tu compra)</span>              
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('WhatsApp para enviar comprobante'); ?></label>
              <div class="controls">
                <input type="number" name="onlinebanking_whatsapp" class="form-control w-100" value="<?= @$data['onlinebanking_whatsapp'] ?>"/>
              </div>
              <span class="text-muted">Poné tu número de WhatsApp para que te puedan enviar el comprobante. (Ej: 541147022997)</span>            
            </div> 
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Desarrolla Instrucciones de la operación'); ?></label>
              <div class="controls">
                <textarea name="onlinebanking_instructions_text" class="form-control w-100"><?= @$data['onlinebanking_instructions_text'] ?></textarea>
              </div>
              <span class="text-muted">Indica las instrucciones complementarias para enviar los comprobantes. Ej: enviar comprobante por whatsapp al siguiente número...</span>
            </div>
            <!--div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Monto total de la operación'); ?></label>
              <div class="controls">
                <input name="onlinebanking_total_text" class="form-control w-100" value="<?= @$data['onlinebanking_total_text'] ?>"/>
              </div>
              <span class="text-muted">Texto que que se muestra antes de informar sobre el monto total de la operación. (Ej: Monto a transferir para esta operación)</span>             
            </div-->             
          </div>
        </div>
      </div>  
      <br />               
      <div class="form-actions">
        <a href="/admin/cupones" class="btn btn-info"><i class="icon-repeat"></i> Atrás</a>
        <button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> Resetear</button>
        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Guardar</button>
      </div>
    </form>
  </div>
</div>