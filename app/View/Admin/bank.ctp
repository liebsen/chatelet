<?php
  echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
  echo $this->Html->css('bootstrap-datepicker', array('inline' => false));
  echo $this->Html->script('admin-bank.js?v=' . $version['ver'], array('inline' => false));
  echo $this->element('admin/menu'); 
?>

<div class="block-tabs">
  <!--div class="block-title">
    <h4>CBU/Alias y Descuentos</h4>
  </div-->
  <div class="tab-content">
    <form action="" method="post" class="form-inline">
      <div class="row">
        <div class="col-md-6">
          <h4 class="sub-header">Activar pagos CBU/Alias en la tienda</h4>
          <div class="controls">
            <label class="control-label">Activo</label>
            <input type="checkbox" name="data[bank_enable]" value="1" id="toggle" class="toggle-checkbox"<?=@$settings['bank_enable'] == '1' ? ' checked' : '' ?>>
            <label for="toggle" class="toggle-label"></label>
          </div>
          <hr>
          <div class="show-panel <?= !$settings['bank_enable'] == 1 ? 'show-inactive' : '' ?>">
            <div class="controls">
              <label class="control-label">Descuento</label>
              <input type="checkbox" name="data[bank_discount_enable]" value="1" id="toggle2" class="toggle-checkbox"<?=@$settings['bank_discount_enable'] == '1' ? ' checked' : '' ?>>
              <label for="toggle2" class="toggle-label"></label>
            </div>
            <div class="control-group target2" style="display: <?=@$settings['bank_discount_enable'] == '1' ? 'block' : 'none' ?>">
              <label class="control-label" for="columns-text"><?php echo __('Descuento (%)'); ?></label>
              <div class="controls">
                <input type="number" max="100" min="0" size="4" name="bank_discount" class="form-control" value="<?= @$settings['bank_discount'] ?>" <?= $disabled ? 'disabled': '' ?>/>
              </div>
              <small class="text-muted">Porcentaje de descuento para pagos con CBU/Alias. (Ej: 10%, 20%, etc)</small>
            </div> 
            <hr>          
            <div class="controls">
              <label class="control-label">Envío gratis</label>
              <input type="checkbox" name="data[bank_free_shipping]" value="1" id="toggle3" class="toggle-checkbox"<?=@$settings['bank_free_shipping'] == '1' ? ' checked' : '' ?>>
              <label for="toggle3" class="toggle-label"></label>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="show-panel <?= !$settings['bank_enable'] == 1 ? 'show-inactive' : '' ?>">
            <h4 class="sub-header">Información bancaria</h4>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Datos bancarios'); ?></label>
              <div class="controls">
                <input name="bank_explain_title" class="form-control w-100" value="<?= @$settings['bank_explain_title'] ?>"/>
              </div>
              <small class="text-muted">Título antes de mostrar los datos bancarios. (Ej: Datos para completar tu compra)</small>              
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Desarrolla Datos bancarios'); ?></label>
              <div class="controls">
                <textarea name="bank_explain_text" class="form-control w-100" rows="8"><?= @$settings['bank_explain_text'] ?></textarea>
              </div>
              <small class="text-muted">Indica los datos de cuenta bancaria para que los clientes puedan pagar via trasnferencia. Ej: CBU, Alias, etc... </small>
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Instrucciones de la operación'); ?></label>
              <div class="controls">
                <input name="bank_instructions_title" class="form-control w-100" value="<?= @$settings['bank_instructions_title'] ?>"/>
              </div>
              <small class="text-muted">Título antes de mostrar los datos bancarios. (Ej: Datos para completar tu compra)</small>     
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('WhatsApp para enviar comprobante'); ?></label>
              <div class="controls">
                <input type="number" name="bank_whatsapp" class="form-control w-100" value="<?= @$settings['bank_whatsapp'] ?>"/>
              </div>
              <small class="text-muted">Poné tu número de WhatsApp para que te puedan enviar el comprobante. (Ej: 541147022997)</small>            
            </div> 
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Desarrolla Instrucciones de la operación'); ?></label>
              <div class="controls">
                <textarea name="bank_instructions_text" class="form-control w-100" rows="8"><?= @$settings['bank_instructions_text'] ?></textarea>
              </div>
              <small class="text-muted">Indica las instrucciones complementarias para enviar los comprobantes. Ej: enviar comprobante por whatsapp al siguiente número...</small>
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
      </div>
      <div class="form-actions">
        <a href="/admin/cupones" class="btn btn-info"><i class="fa fa-chevron-left mr-1"></i> <span>Atrás</span></a>
        <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> <span>Guardar</span></button>
      </div>
    </form>
  </div>
</div>