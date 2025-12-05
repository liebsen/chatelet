<?php
  echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
  echo $this->Html->css('bootstrap-datepicker', array('inline' => false));
?>

<div class="block">
  <!--div class="block-title">
    <h4>CBU/Alias y Descuentos</h4>
  </div-->
  <div class="block-content">
    <form action="" method="post" class="form-inline">
      <div class="row">
        <div class="col-md-6">
          <h4 class="sub-header">Activar pagos CBU/Alias en la tienda</h4>
          <div class="control-group">
            <div class="controls text-center switch-scale">
              <?php
                $enabled = $settings['bank_enable'] == 1 ? 'checked' : '';
                $disabled = $settings['bank_enable'] == 0 ? 'checked' : '';
              ?>
              <label for="enabled_1">Sí</label>
              <input type="radio" class="form-control" id="enabled_1" name="data[bank_enable]" value="1" <?php echo $enabled; ?> /> &nbsp;
              <label for="enabled_0">No</label>
              <input type="radio" class="form-control" id="enabled_0" name="data[bank_enable]" value="0" <?php echo $disabled; ?> />
            </div>
            <span class="text-muted">Indica si están habilitados los pagos CBU/Alias desde la tienda.</span>
          </div>
          <br>
          <h4 class="sub-header">Descuento por pago CBU/Alias</h4>
          <div class="row">
            <div class="col-md-6">
              <div class="control-group">
                <div class="controls text-center switch-scale">
                  <?php
                    $enabled = $settings['bank_discount_enable'] == 1 ? 'checked' : '';
                    $disabled = $settings['bank_discount_enable'] == 0 ? 'checked' : '';
                  ?>
                  <label for="enabled_11">Sí</label>
                  <input type="radio" class="form-control" id="enabled_11" name="data[bank_discount_enable]" value="1" <?php echo $enabled; ?> /> &nbsp;
                  <label for="enabled_10">No</label>
                  <input type="radio" class="form-control" id="enabled_10" name="data[bank_discount_enable]" value="0" <?php echo $disabled; ?> />
                </div>
                <span class="text-muted">Indica si existe descuento por los pagos CBU/Alias desde la tienda.</span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="control-group">
                <label class="control-label" for="columns-text"><?php echo __('Descuento (%)'); ?></label>
                <div class="controls">
                  <input type="number" max="100" min="0" size="4" name="bank_discount" class="form-control" value="<?= @$settings['bank_discount'] ?>" <?= $disabled ? 'disabled': '' ?>/>
                </div>
                <span class="text-muted">Porcentaje de descuento para pagos con CBU/Alias. (Ej: 10%, 20%, etc)</span>              
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <h4 class="sub-header">Información bancaria</h4>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Datos bancarios'); ?></label>
            <div class="controls">
              <input name="bank_explain_title" class="form-control w-100" value="<?= @$settings['bank_explain_title'] ?>"/>
            </div>
            <span class="text-muted">Título antes de mostrar los datos bancarios. (Ej: Datos para completar tu compra)</span>              
          </div>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Desarrolla Datos bancarios'); ?></label>
            <div class="controls">
              <textarea name="bank_explain_text" class="form-control w-100"><?= @$settings['bank_explain_text'] ?></textarea>
            </div>
            <span class="text-muted">Indica los datos de cuenta bancaria para que los clientes puedan pagar via trasnferencia. Ej: CBU, Alias, etc... </span>
          </div>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Instrucciones de la operación'); ?></label>
            <div class="controls">
              <input name="bank_instructions_title" class="form-control w-100" value="<?= @$settings['bank_instructions_title'] ?>"/>
            </div>
            <span class="text-muted">Título antes de mostrar los datos bancarios. (Ej: Datos para completar tu compra)</span>              
          </div>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('WhatsApp para enviar comprobante'); ?></label>
            <div class="controls">
              <input type="number" name="bank_whatsapp" class="form-control w-100" value="<?= @$settings['bank_whatsapp'] ?>"/>
            </div>
            <span class="text-muted">Poné tu número de WhatsApp para que te puedan enviar el comprobante. (Ej: 541147022997)</span>            
          </div> 
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Desarrolla Instrucciones de la operación'); ?></label>
            <div class="controls">
              <textarea name="bank_instructions_text" class="form-control w-100"><?= @$settings['bank_instructions_text'] ?></textarea>
            </div>
            <span class="text-muted">Indica las instrucciones complementarias para enviar los comprobantes. Ej: enviar comprobante por whatsapp al siguiente número...</span>
          </div>
          <!--div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Monto total de la operación'); ?></label>
            <div class="controls">
              <input name="bank_total_text" class="form-control w-100" value="<?= @$settings['bank_total_text'] ?>"/>
            </div>
            <span class="text-muted">Texto que que se muestra antes de informar sobre el monto total de la operación. (Ej: Monto a transferir para esta operación)</span>             
          </div-->  
        </div> 
      </div>
      <br />               
      <div class="form-actions">
        <a href="/admin/cupones" class="btn btn-info"><i class="icon-repeat"></i> Atrás</a>
        <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="icon-ok"></i> Guardar</button>
      </div>
    </form>
  </div>
</div>