<?php
  $this->Html->script('ckeditor/ckeditor', array('block' => 'script'));
  $this->Html->script('sucursales-detail', array('block' => 'script'));
  $this->Html->css('sucursales-detail', array('block' => 'css'));
  $this->Html->script('form_app.js?v=' . $version['ver'], array('block' => 'script'));
  echo $this->element('admin/menu');
?>
<div class="block-section">
  <div class="block-tabs">

    <div class="tab-content">
      <form action="" id="form_app" method="post" class="form-inline" enctype="multipart/form-data">
        <?php
          if (isset($this->request->pass[1])) {
            echo '<input class="form-control" type="hidden" name="data[id]" value="'. htmlspecialchars($this->request->pass[1]) .'" />';
          }
        ?>
        <div class="row">
          <div class="col-md-6">
            <h4 class="sub-header">Información Principal</h4>
            <div class="controls">
              <label class="control-label text-left" for="toggle_mayor"><?php echo __('¿Por mayor?'); ?></label>
              <input type="checkbox" name="data[por_mayor]" value="1" id="toggle_mayor" class="toggle-checkbox"<?= @$store['Store']['por_mayor'] == '1' ? ' checked' : '' ?>>
              <label for="toggle_mayor" class="toggle-label"></label>
            </div>        
            <div class="controls">
              <label class="control-label text-left" for="toggle_takeaway"><?php echo __('¿Takeaway?'); ?></label>
              <input type="checkbox" name="data[takeaway]" value="1" id="toggle_takeaway" class="toggle-checkbox"<?= @$store['Store']['takeaway'] == '1' ? ' checked' : '' ?>>
              <label for="toggle_takeaway" class="toggle-label"></label>
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Nombre'); ?></label>
              <div class="controls">
                <input class="form-control w-100" type="text" id="" name="data[name]" value="<?php echo (isset($store)) ? $store['Store']['name'] : ''; ?>" required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Dirección'); ?></label>
              <div class="controls">
                <input class="form-control w-100" type="text" id="" name="data[address]" value="<?php echo (isset($store)) ? $store['Store']['address'] : ''; ?>" required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Teléfono'); ?></label>
              <div class="controls">
                <input class="form-control w-100" type="text" id="" name="data[phone]" value="<?php echo (isset($store)) ? $store['Store']['phone'] : ''; ?>" required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Whatsapp'); ?></label>
              <div class="controls">
                <input class="form-control w-100" type="text" id="" name="data[whatsapp]" value="<?php echo (isset($store)) ? $store['Store']['whatsapp'] : ''; ?>" required>
              </div>
            </div>
    
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Numero de local'); ?></label>
              <div class="controls">
                <input class="form-control w-100" type="number" id="" name="data[local]" value="<?php echo (isset($store)) ? $store['Store']['local'] : ''; ?>" required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Latitud'); ?></label>
              <div class="controls">
                <input class="form-control w-100" type="text" id="lat" name="data[lat]" value="<?php echo (isset($store)) ? $store['Store']['lat'] : ''; ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Latitud'); ?></label>
              <div class="controls">
                <input class="form-control w-100" type="text" id="lng" name="data[lng]" value="<?php echo (isset($store)) ? $store['Store']['lng'] : ''; ?>">
              </div>
            </div>
          </div> 
          <div class="col-md-6">
            <h4 class="sub-header">Ubicación</h4>
            <div id="panel" style="display: none;">
              <input class="form-control" id="address" type="text" placeholder="Dirección, Ciudad, País">
              <input class="form-control" id="geocode" type="button" value="Localizar">
            </div>
            <div id="map-canvas"></div>
          </div>             
        </div>      
        <div class="form-actions">
          <button type="reset" class="btn btn-danger" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="fa fa-close"></i> <span class="ml-1">Restaurar</span></button>
          <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario" disabled><i class="fa fa-check"></i> <span class="ml-1">Guardar</span></button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA80jEAk4PzzCEBDXc8prj7LCB1Q3U3g_o&v=3.exp&language=es"></script>