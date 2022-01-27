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
            <div class="controls">
              <?php
                $enabled = (isset($coupon) && $coupon['Coupon']['enabled'] === '1') ? 'checked' : '';
                $disabled = (isset($coupon) && $coupon['Coupon']['enabled'] === '0') ? 'checked' : '';
              ?>
              <label for="enabled_1">Activo</label> <input type="radio" id="enabled_1" name="data[enabled]" value="1" <?php echo $enabled; ?> /> &nbsp; 
              <label for="enabled_0">Inactivo</label> <input type="radio" id="enabled_0" name="data[enabled]" value="0" <?php echo $disabled; ?> />
            </div>
          </div>        
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Código'); ?></label>
            <div class="controls">
              <input type="text" id="" name="data[code]" value="<?php echo (isset($coupon)) ? $coupon['Coupon']['code'] : ''; ?>" required>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Info'); ?></label>
            <div class="controls">
              <textarea id="" name="data[title]" required><?php echo (isset($coupon)) ? $coupon['Coupon']['title'] : ''; ?></textarea>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Tipo de cupón'); ?></label>
            <div class="controls">
              <?php
                $percentage = (isset($coupon) && $coupon['Coupon']['type_coupon'] == 'percentage') ? 'checked' : '';
                $nominal = (isset($coupon) && $coupon['Coupon']['type_coupon'] == 'nominal') ? 'checked' : '';
              ?>
              <label for="type_0">Porcentual</label> <input type="radio" id="type_0" name="data[type_coupon]" value="percentage" <?php echo $percentage; ?> /> &nbsp; 
              <label for="type_1">Nominal</label> <input type="radio" id="type_1" name="data[type_coupon]" value="nominal" <?php echo $nominal; ?> />
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Descuento del cupón'); ?></label>
            <div class="controls">
              <input type="number" id="" name="data[discount]" value="<?php echo (isset($coupon)) ? $coupon['Coupon']['discount'] : ''; ?>" required>
            </div>
          </div>
        </div> 
        <div class="col-md-6">
          <h4 class="sub-header">Validez</h4>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Fecha desde'); ?></label>
            <div class="controls">
              <input type="text" class="datepicker form-control" id="" name="data[date_from]" value="<?php echo (isset($coupon)) ? $coupon['Coupon']['date_from'] : ''; ?>">
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Fecha hasta'); ?></label>
            <div class="controls">
              <input type="text" class="datepicker form-control" id="" name="data[date_until]" value="<?php echo (isset($coupon)) ? $coupon['Coupon']['date_until'] : ''; ?>">
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Hora desde'); ?></label>
            <div class="controls">
              <input type="text" class="form-control" id="" name="data[hour_from]" value="<?php echo (isset($coupon)) ? $coupon['Coupon']['hour_from'] : ''; ?>">
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Hora hasta'); ?></label>
            <div class="controls">
              <input type="text" class="form-control" id="" name="data[hour_until]" value="<?php echo (isset($coupon)) ? $coupon['Coupon']['hour_until'] : ''; ?>">
            </div>
          </div>
          <br />
          <div class="control-group">
            <input type="hidden" id="weekdays" name="data[weekdays]" value="<?= isset($coupon) ? $coupon['Coupon']['weekdays'] : '' ?>" />
            <label class="control-label" for="columns-text"><?php echo __('Días de semana'); ?></label>
            <div class="controls">
              <?php for($i=0; $i < count($weekdays); $i++):?>
                <input type="checkbox" class="weekdays" name="weekdays" value="<?= $i ?>" id="w<?= $i ?>" <?= strpos($coupon['Coupon']['weekdays'], (string) $i) !== false ? ' checked' : '' ?>/> <label for="w<?= $i ?>"> &nbsp;<?= $weekdays[$i] ?></label><br>
              <?php endfor ?>
            </div>
          </div>
          <br />          
        </div>             
      </div>      
      <br />               
      <div class="form-actions">
        <button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> Reset</button>
        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Submit</button>
      </div>
    </form>
  </div>
</div>