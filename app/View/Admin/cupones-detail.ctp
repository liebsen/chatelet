<?php
  echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
  echo $this->Html->script('cupones-detail', array('inline' => false));
  // echo $this->Html->css('cupones-detail', array('inline' => false));
  echo $this->Html->css('bootstrap-datepicker', array('inline' => false));
  $weekdays = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
  ?>
<?php echo $this->element('admin-menu');?>
<div class="block block-themed">
  <div class="block-title">
    <h4>
    <?php
      echo (isset($coupon)) ? __('Editar Cupón') : __('Agregar Cupón');
    ?>
    </h4>
  </div>

  <div class="block-content">
    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
      <?php
        if (isset($this->request->pass[1])) {
          echo '<input type="hidden" name="data[id]" value="'. htmlspecialchars($this->request->pass[1]) .'" />';
        }
      ?>
      <div class="row">
        <div class="col-md-6">
          <h4 class="sub-header">Información Principal</h4>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Estado'); ?></label>
            <div class="controls text-center switch-scale">
              <?php
                $enabled = (isset($coupon) && $coupon['Coupon']['enabled'] === '1') || !isset($coupon) ? 'checked' : '';
                $disabled = (isset($coupon) && $coupon['Coupon']['enabled'] === '0') ? 'checked' : '';
              ?>
              <label for="enabled_1">Sí</label> <input type="radio" class="form-control" id="enabled_1" name="data[enabled]" value="1" <?php echo $enabled; ?> /> &nbsp; 
              <label for="enabled_0">No</label> <input type="radio" class="form-control" id="enabled_0" name="data[enabled]" value="0" <?php echo $disabled; ?> />
            </div>
            <small class="text-muted">Estado principal de este Cupón</small>
          </div>        
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Código'); ?></label>
            <div class="controls">
              <input type="text" maxlength="16" class="form-control" id="" name="data[code]" value="<?php echo (isset($coupon)) ? $coupon['Coupon']['code'] : ''; ?>" <?= isset($coupon) ? 'disabled' : 'required' ?>>
            </div>
             <small class="text-danger">El código es el título del cupón para el cliente. Este valor solo puede editarse una vez.</small>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Info'); ?></label>
            <div class="controls">
              <textarea id="" class="form-control" name="data[info]" rows="5" required><?php echo (isset($coupon)) ? $coupon['Coupon']['info'] : ''; ?></textarea>
            </div>
            <small class="text-muted">Describí brevemente de que se trata este cupón.</small>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Tipo de cupón'); ?></label>
            <div class="controls">
              <?php
                $percentage = (isset($coupon) && $coupon['Coupon']['coupon_type'] == 'percentage') || !isset($coupon) ? 'checked' : '';
                $nominal = (isset($coupon) && $coupon['Coupon']['coupon_type'] == 'nominal') ? 'checked' : '';
              ?>
              <label for="type_0">Porcentual</label> <input type="radio"  class="form-control" id="type_0" name="data[coupon_type]" value="percentage" <?php echo $percentage; ?> /> &nbsp; 
              <label for="type_1">Nominal</label> <input type="radio"  class="form-control" id="type_1" name="data[coupon_type]" value="nominal" <?php echo $nominal; ?> />
            </div>
            <small class="text-muted">El tipo de cupón puede ser porcentual en que usaremos un valor de 0-100, o nominal indicando el monto a beneficiar expresado en peso argentino ARS.</small>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Valor de descuento'); ?></label>
            <div class="controls">
              <input type="number" class="form-control" id="" name="data[discount]" value="<?php echo (isset($coupon)) ? $coupon['Coupon']['discount'] : ''; ?>" required>
            </div>
            <small class="text-muted">El valor de descuento será variable de acuerdo al monto si es Porcentual ó fijo si es Nominal.<br>Moneda actual: ARS</small>
          </div>
        </div> 
        <div class="col-md-6">
          <h4 class="sub-header">Validez</h4>
          <br />
          <div class="control-group">
            <!--input type="hidden" id="coupon_payment" name="data[coupon_payment][]" value="<?= isset($coupon) ? $coupon['Coupon']['coupon_payment'] : '' ?>" /-->
            <label class="control-label" for="columns-text"><?php echo __('Pagando con'); ?></label>
            <div class="controls">
              <?php $selected = isset($coupon) && $coupon['Coupon']['coupon_payment'] ? $coupon['Coupon']['coupon_payment'] : '';?>
                <input type="checkbox" class="coupon_payment" name="coupon_payment[]" value="bank" id="coupon_payment_bank" <?= strpos($selected, 'bank') !== false ? ' checked' : '' ?>/> <label for="coupon_payment_bank"> &nbsp;Transferencia</label><br>
                <input type="checkbox" class="coupon_payment" name="coupon_payment[]" value="mercadopago" id="coupon_payment_mp" <?= strpos($selected, 'mercadopago') !== false ? ' checked' : '' ?>/> <label for="coupon_payment_mp"> &nbsp;Mercadopago</label><br>
            </div>
            <small class="text-muted">Seleccioná el método de pago válido para este cupón</small>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Valor mínimo de compra'); ?></label>
            <div class="controls">
              <input type="number" class="form-control" id="" name="data[min_amount]" value="<?php echo (isset($coupon)) ? $coupon['Coupon']['min_amount'] : ''; ?>" required>
            </div>
            <small class="text-muted">El valor mínimo de la compra para que sea efectivo el cupón</small>
          </div>
          <br />          
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Fecha desde'); ?></label>
            <div class="controls">
              <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy" id="" name="data[date_from]" value="<?php echo (isset($coupon)) ? $coupon['Coupon']['date_from'] : ''; ?>">
            </div>
            <small class="text-muted">Seleccioná desde qué fecha el cupón debería estar disponible.</small>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Fecha hasta'); ?></label>
            <div class="controls">
              <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy" id="" name="data[date_until]" value="<?php echo (isset($coupon)) ? $coupon['Coupon']['date_until'] : ''; ?>">
            </div>
            <small class="text-muted">Seleccioná hasta qué fecha el cupón debería estar disponible.</small>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Hora desde'); ?></label>
            <div class="controls">
              <select class="form-control" name="data[hour_from]">
                <option value="" selected>Sin horario</option>
              <?php for($i=5; $i < 24; $i++) :?>
                <option value="<?= $i ?>:00:00"<?php echo (isset($coupon) && $coupon['Coupon']['hour_from'] === "{$i}:00:00") ? ' selected' : '' ?>><?= $i ?>:00</option>
              <?php endfor ?>
              </select>              
            </div>
            <small class="text-muted">Seleccioná desde qué horario el cupón debería estar disponible.</small>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Hora hasta'); ?></label>
            <div class="controls">
              <select class="form-control" name="data[hour_until]">
                <option value="" selected>Sin horario</option>
              <?php for($i=5; $i < 24; $i++) :?>
                <option value="<?= $i ?>:00:00"<?php echo (isset($coupon) && $coupon['Coupon']['hour_until'] === "{$i}:00:00") ? ' selected' : '' ?>><?= $i ?>:00</option>
              <?php endfor ?>
              </select>              
            </div>
            <small class="text-muted">Seleccioná hasta qué horario el cupón debería estar disponible.</small>
          </div>
          <br />
          <div class="control-group">
            <input type="hidden" id="weekdays" name="data[weekdays]" value="<?= isset($coupon) ? $coupon['Coupon']['weekdays'] : '' ?>" />
            <label class="control-label" for="columns-text"><?php echo __('Días de semana'); ?></label>
            <div class="controls">
              <?php $selected = isset($coupon) && $coupon['Coupon']['weekdays']? $coupon['Coupon']['weekdays'] : '12345'; for($i=0; $i < count($weekdays); $i++):?>
                <input type="checkbox" class="weekdays" name="weekdays" value="<?= $i ?>" id="w<?= $i ?>" <?= strpos($selected, (string) $i) !== false ? ' checked' : '' ?>/> <label for="w<?= $i ?>"> &nbsp;<?= $weekdays[$i] ?></label><br>
              <?php endfor ?>
            </div>
            <small class="text-muted">Seleccioná los días de la semana en que el cupón debería estar disponible.</small>
          </div>
          <br />          
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