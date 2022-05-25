<?php
  // echo $this->Html->script('cupones-detail', array('inline' => false));
  // echo $this->Html->css('cupones-detail', array('inline' => false));
?>
<?php echo $this->element('admin-menu');?>
<div class="block block-themed">
  <div class="block-title">
    <h4>
    <?php
      echo (isset($logistic)) ? __('Editar Logística') : __('Agregar Logística');
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
      <div class="container">
        <div class="row">
          <div class="col">
            <h4 class="sub-header">Información Principal</h4>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Estado'); ?></label>
              <div class="controls">
                <?php
                  $enabled = (isset($logistic) && $logistic['Logistic']['enabled'] == 1) ? 'checked' : '';
                  $disabled = (isset($logistic) && $logistic['Logistic']['enabled'] == 0) ? 'checked' : '';
                ?>
                <label for="enabled_1">Activo</label>
                <input type="radio" class="form-control" id="enabled_1" name="data[enabled]" value="1" <?php echo $enabled; ?> /> &nbsp;
                <label for="enabled_0">Inactivo</label>
                <input type="radio" class="form-control" id="enabled_0" name="data[enabled]" value="0" <?php echo $disabled; ?> />
              </div>
              <small class="text-muted">Indica el estado de esta logística. En caso de inactivo el cliente no podrá utilizar esta opción.</small>
            </div>        
            <div class="control-group">
              <label class="control-label" for="code"><?php echo __('Código'); ?></label>
              <div class="controls">
                <input type="text" class="form-control" id="code" name="data[code]" value="<?php echo (isset($logistic)) ? $logistic['Logistic']['code'] : ''; ?>" <?= isset($logistic) ? 'disabled' : 'required' ?>>
              </div>
              <small class="text-danger">Indica el código de logística. Si no estás seguro consultá con el programador. Este valor solo puede editarse una vez.</small>
            </div>
            <br />
            <div class="control-group">
              <label class="control-label" for="title"><?php echo __('Nombre'); ?></label>
              <div class="controls">
                <input type="text" class="form-control" id="title" name="data[title]" value="<?php echo (isset($logistic)) ? $logistic['Logistic']['title'] : ''; ?>" required>
              </div>
              <small class="text-muted">Indica el título de esta logística. Es probable que aparezca en algún correo que enviemos al cliente para informarle del código de seguimiento o eventualmente otro estado envío.</small>
            </div>
            <br />
            <div class="control-group">
              <label class="control-label" for="info"><?php echo __('Info'); ?></label>
              <div class="controls">
                <textarea id="info"  class="form-control" name="data[info]" rows="5"><?php echo (isset($logistic)) ? $logistic['Logistic']['info'] : ''; ?></textarea>
              </div>
              <small class="text-muted">Agrega mas información sobre esta logística que merezca ser informada al cliente.</small>
            </div>
            <br />
            <div class="control-group">
              <label class="control-label" for="zips"><?php echo __('Códigos postales'); ?></label>
              <div class="controls">
                <textarea id="zips" class="form-control" name="data[zips]" rows="10"><?php echo (isset($logistic)) ? $logistic['Logistic']['zips'] : ''; ?></textarea>
              </div>
              <small class="text-muted">Establece si es de alcance local. Indica los códigos postales que abarca la zona de cobertura de esta logística. Si se deja en blanco se entiende que abarca todo el país.</small>
            </div>
            <br />
            <div class="control-group">
              <label class="control-label" for="zips"><?php echo __('Tarifa'); ?></label>
              <div class="controls">
                <textarea id="zips" class="form-control" name="data[zips]" rows="10"><?php echo (isset($logistic)) ? $logistic['Logistic']['zips'] : ''; ?></textarea>
              </div>
              <small class="text-muted">En caso de logística de alcance local indica la tarifa por envío.</small>
            </div>
          </div>             
        </div>  
      </div>    
      <br />               
      <div class="form-actions">
        <a href="/admin/logistica" class="btn btn-info"><i class="icon-repeat"></i> Back</a>
        <button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> Reset</button>
        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Submit</button>
      </div>
    </form>
  </div>
</div>