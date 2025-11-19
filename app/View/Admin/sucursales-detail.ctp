<?php
  echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
  echo $this->Html->script('sucursales-detail', array('inline' => false));
  echo $this->Html->css('sucursales-detail', array('inline' => false));
?>
<?php echo $this->element('admin-menu');?>
<div class="block block-themed">
  <div class="block-title">
    <h4>
    <?php
      echo (isset($store)) ? __('Editar Sucursal') : __('Agregar Sucursal');
    ?>
    </h4>
  </div>

  <div class="block-content">
    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
      <?php
        if (isset($this->request->pass[1])) {
          echo '<input class="form-control" type="hidden" name="data[id]" value="'. htmlspecialchars($this->request->pass[1]) .'" />';
        }
      ?>
      <div class="row">
        <div class="col-md-4">
          <h4 class="sub-header">Información Principal</h4>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Nombre'); ?></label>
            <div class="controls">
              <input class="form-control" type="text" id="" name="data[name]" value="<?php echo (isset($store)) ? $store['Store']['name'] : ''; ?>" required>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Dirección'); ?></label>
            <div class="controls">
              <input class="form-control" type="text" id="" name="data[address]" value="<?php echo (isset($store)) ? $store['Store']['address'] : ''; ?>" required>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Teléfono'); ?></label>
            <div class="controls">
              <input class="form-control" type="text" id="" name="data[phone]" value="<?php echo (isset($store)) ? $store['Store']['phone'] : ''; ?>" required>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Whatsapp'); ?></label>
            <div class="controls">
              <input class="form-control" type="text" id="" name="data[whatsapp]" value="<?php echo (isset($store)) ? $store['Store']['whatsapp'] : ''; ?>" required>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('¿Por mayor?'); ?></label>
            <div class="controls">
              <?php
                $por_mayor = (isset($store) && $store['Store']['por_mayor'] == 1) ? 'checked' : '';
                $por_menor = (isset($store) && $store['Store']['por_mayor'] == 0) ? 'checked' : '';
              ?>
              Sí <input class="form-control" type="radio" name="data[por_mayor]" value="1" <?php echo $por_mayor; ?> /> - 
              No <input class="form-control" type="radio" name="data[por_mayor]" value="0" <?php echo $por_menor; ?> />
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Takeaway'); ?></label>
            <div class="controls">
              <?php
                $takeaway1 = (isset($store) && $store['Store']['takeaway'] == 1) ? 'checked' : '';
                $takeaway2 = (isset($store) && $store['Store']['takeaway'] == 0) ? 'checked' : '';
              ?>
              Sí <input class="form-control" type="radio" name="data[takeaway]" value="1" <?php echo $takeaway1; ?> /> - 
              No <input class="form-control" type="radio" name="data[takeaway]" value="0" <?php echo $takeaway2; ?> />
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Numero de local'); ?></label>
            <div class="controls">
              <input class="form-control" type="number" id="" name="data[local]" value="<?php echo (isset($store)) ? $store['Store']['local'] : ''; ?>" required>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Latitud'); ?></label>
            <div class="controls">
              <input class="form-control" type="text" id="lat" name="data[lat]" value="<?php echo (isset($store)) ? $store['Store']['lat'] : ''; ?>">
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Latitud'); ?></label>
            <div class="controls">
              <input class="form-control" type="text" id="lng" name="data[lng]" value="<?php echo (isset($store)) ? $store['Store']['lng'] : ''; ?>">
            </div>
          </div>
          <br />
        </div> 
        <div class="col-md-8">
          <h4 class="sub-header">Ubicación</h4>
          <div id="panel" style="display: none;">
            <input class="form-control" id="address" type="text" placeholder="Dirección, Ciudad, País">
            <input class="form-control" id="geocode" type="button" value="Localizar">
          </div>
          <div id="map-canvas"></div>
        </div>             
      </div>      
      <br />               
      <div class="form-actions">
        <button type="reset" class="btn btn-danger" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="icon-repeat"></i> Restaurar</button>
        <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="icon-ok"></i> Guardar</button>
      </div>
    </form>
  </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA80jEAk4PzzCEBDXc8prj7LCB1Q3U3g_o&v=3.exp&language=es"></script>