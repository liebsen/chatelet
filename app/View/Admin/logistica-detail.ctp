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
      <div class="row">
        <div class="col">
          <h4 class="sub-header">Información Principal</h4>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Estado'); ?></label>
            <div class="controls">
              <?php
                $enabled = (isset($logistic) && $logistic['Logistic']['enabled'] === '1') ? 'checked' : '';
                $disabled = (isset($logistic) && $logistic['Logistic']['enabled'] === '0') ? 'checked' : '';
              ?>
              <label for="enabled_1">Activo</label> <input type="radio" id="enabled_1" name="data[enabled]" value="1" <?php echo $enabled; ?> /> &nbsp; 
              <label for="enabled_0">Inactivo</label> <input type="radio" id="enabled_0" name="data[enabled]" value="0" <?php echo $disabled; ?> />
            </div>
          </div>        
          <div class="control-group">
            <label class="control-label" for="title"><?php echo __('Nombre'); ?></label>
            <div class="controls">
              <input type="text" id="title" name="data[title]" value="<?php echo (isset($logistic)) ? $logistic['Logistic']['title'] : ''; ?>" required>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="code"><?php echo __('Código'); ?></label>
            <div class="controls">
              <input type="text" id="code" name="data[code]" value="<?php echo (isset($logistic)) ? $logistic['Logistic']['code'] : ''; ?>" required>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="info"><?php echo __('Info'); ?></label>
            <div class="controls">
              <textarea id="info" name="data[info]" required><?php echo (isset($logistic)) ? $logistic['Logistic']['info'] : ''; ?></textarea>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="zips"><?php echo __('Códigos postales'); ?></label>
            <div class="controls">
              <textarea id="zips" name="data[zips]" required><?php echo (isset($logistic)) ? $logistic['Logistic']['zips'] : ''; ?></textarea>
            </div>
          </div>
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