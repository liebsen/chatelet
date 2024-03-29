<?php
  echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
?>
<?php echo $this->element('admin-menu');?>
<div class="block block-themed">
  <div class="block-title">
    <h4><?php 
      echo (isset($cat)) ? __('Editar Categoria') : __('Agregar Categoria');
    ?></h4>
  </div>

  <div class="block-content">
    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
      <?php
        if (isset($this->request->pass[1])) {
          echo '<input type="hidden" name="data[id]" value="'. htmlspecialchars($this->request->pass[1]) .'" />';
        }
      ?>
      <div class="row-fluid">
        <div class="span6">
          <h4 class="sub-header">Información Principal</h4>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Nombre'); ?></label>
            <div class="controls">
              <input class="form-control" type="text" id="" name="data[name]" value="<?php echo (isset($cat)) ? $cat['Category']['name'] : ''; ?>" required>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Ancho de columna'); ?></label>
            <div class="controls">
              <select class="form-control" name="data[colsize]">
                <option value="6"<?= empty($cat['Category']['colsize']) ? ' selected' : '' ?>>Auto</option>
                <!--option value="2"<?= @$cat['Category']['colsize'] == '2' ? ' selected' : '' ?>>16.66%</option-->
                <option value="20"<?= @$cat['Category']['colsize'] == '20' ? ' selected' : '' ?>>20%</option>
                <option value="3"<?= @$cat['Category']['colsize'] == '3' ? ' selected' : '' ?>>25%</option>
                <option value="4"<?= @$cat['Category']['colsize'] == '4' ? ' selected' : '' ?>>33%</option>
                <option value="40"<?= @$cat['Category']['colsize'] == '40' ? ' selected' : '' ?>>40%</option>
                <option value="6"<?= @$cat['Category']['colsize'] == '6' ? ' selected' : '' ?>>50%</option>
                <option value="60"<?= @$cat['Category']['colsize'] == '60' ? ' selected' : '' ?>>60%</option>
                <option value="80"<?= @$cat['Category']['colsize'] == '80' ? ' selected' : '' ?>>80%</option>
                <option value="12"<?= @$cat['Category']['colsize'] == '12' ? ' selected' : '' ?>>100%</option>
              </select>              
            </div>
            <small class="text-muted">Seleccioná el ancho de columna para esta categoría (solo para dispositivos de escritorio y smart-tv).</small>
          </div>
          <br />
        
          <div class="control-group">
            <label class="control-label" for=""><?=__('Seleccione una imagen de banner para esta categoría')?></label>
            <?php if(!empty($cat['Category']['banner_url'])):?>
              <hr>
              <img src="<?php echo Configure::read('uploadUrl').$cat['Category']['banner_url']?>" width="300">
            <?php endif ?>
            <div class="controls">
              <input  class="form-control" type="file" class="attached" name="banner">
            </div>
          </div>

          <br />       
          <div class="control-group">
            <label class="control-label" for=""><?=__('Seleccione una imagen de listado para esta categoría')?></label>
            <?php if(!empty($cat['Category']['img_url'])):?>
              <hr>
              <img src="<?php echo Configure::read('uploadUrl').$cat['Category']['img_url']?>" width="300">
            <?php endif ?>
            <div class="controls">
              <input  class="form-control" type="file" class="attached" name="image">
            </div>
          </div>
          <br /> 
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Posición de la imagen para todos los productos. '); ?></label>
            <div class="controls">
              <select class="form-control" name="data[posnum]">
                <option value="1"<?= empty($cat['Category']['posnum']) ? ' selected' : '' ?>>Auto</option>
                <option value="2"<?= @$cat['Category']['posnum'] == '2' ? ' selected' : '' ?>>Arriba</option>
                <option value="3"<?= @$cat['Category']['posnum'] == '3' ? ' selected' : '' ?>>Abajo</option>
              </select>              
            </div>
            <small class="text-muted">Seleccioná la posición para las imágenes de los productos. (ej: sombreros, chals: arriba, pantalones, zapatos: abajo, blusa: auto, ... </small>
          </div>
          <br />            
          <div class="control-group">
            <label class="control-label" for=""><?=__('Seleccione una imagen de Talles')?></label>
            <?php if(!empty($cat['Category']['size'])):?>
              <hr>
              <img src="<?php echo Configure::read('uploadUrl').$cat['Category']['size']?>" width="300">
            <?php endif ?>
            <div class="controls">
              <input  class="form-control" type="file" class="attached" name="size">
            </div>
          </div>
          <br />

          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Ordenar'); ?></label>
            <div class="controls">
              <input  class="form-control" type="number" name="data[ordernum]" value="<?= !empty($cat) ? $cat['Category']['ordernum'] : '100' ?>">
            </div>
            <small class="text-muted">Seleccioná el orden de prioridad para esta categoría</small>
          </div>

        </div>                
      </div>      
      <br />               
      <div class="form-actions">
        <a href="/admin/categorias" class="btn btn-info"><i class="icon-repeat"></i> Atrás</a>
        <button type="reset" class="btn btn-danger" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="icon-repeat"></i> Restaurar</button>
        <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="icon-ok"></i> Guardar</button>
      </div>
    </form>
  </div>
</div>