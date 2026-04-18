<?php
  echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
  #echo $this->Html->script('category', array('inline' => false));
  echo $this->element('admin/menu');
?>
<div class="block-tabs">
  <!--div class="block-title">
    <h4><?php 
      echo (isset($cat)) ? __('Editar Categoria') : __('Agregar Categoria');
    ?></h4>
  </div-->
  <div class="tab-content">
    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
      <?php
        if (isset($this->request->pass[1])) {
          echo '<input type="hidden" name="data[id]" value="'. htmlspecialchars($this->request->pass[1]) .'" />';
        }
      ?>
      <div class="row">
        <div class="col-md-6">
          <h4 class="sub-header">Nombre</h4>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Nombre Principal'); ?></label>
            <div class="controls">
              <input class="form-control w-100" type="text" id="" name="data[name]" value="<?php echo (isset($cat)) ? $cat['Category']['name'] : ''; ?>" required>
            </div>
          </div>
          <div class="form-box bg-info-outline">
            <h4 class="sub-header"><?=__('Propiedades')?></h4>
            <p><?=__('Selecciona como deseas ver tu categoría')?></p>            
            <div class="control-group">
              <label class="control-label" for="alternatename"><?php echo __('Nombre Alternativo'); ?></label>
              <div class="form-group">
                <input type="checkbox" id="alternatename" name="data[alternate_toggle]" value="1" id="toggle" class="toggle-checkbox toggle-block" data-block=".show-alternate" <?= $cat['Category']['alternate_toggle'] == '1' ? ' checked' : '' ?>>
                <label for="alternatename" class="toggle-label"></label>
                <!--input type="checkbox" id="alternatename" name="data[alternate_toggle]" value="1" <?php echo (isset($cat)) && $cat['Category']['alternate_toggle'] == 1 ? 'checked' : ''; ?>/-->
              </div>
              <div class="form-group show-alternate<?= $cat['Category']['alternate_toggle'] == '1' ? '' : ' d-disable' ?>">
                <a class="d-none" id="alternatename_restore">Cancelar</a>
                <div class="controls alternate_name_block<?php echo (isset($cat)) && !$cat['Category']['alternate_toggle'] ? ' d-none' : ''; ?>">
                  <input class="form-control w-100" type="text" id="alternate_name_target" name="data[alternate_name]" value="<?php echo (isset($cat)) ? $cat['Category']['alternate_name'] : ''; ?>">
                </div>
              </div>
            </div>
            
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
                  <option value="8"<?= @$cat['Category']['colsize'] == '8' ? ' selected' : '' ?>>66%</option>
                  <option value="9"<?= @$cat['Category']['colsize'] == '9' ? ' selected' : '' ?>>75%</option>
                  <option value="80"<?= @$cat['Category']['colsize'] == '80' ? ' selected' : '' ?>>80%</option>
                  <option value="12"<?= @$cat['Category']['colsize'] == '12' ? ' selected' : '' ?>>100%</option>
                </select>              
              </div>
              <small class="text-muted">Seleccioná el ancho de columna para esta categoría (solo para dispositivos de escritorio y smart-tv).</small>
            </div>

            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Posición de la imagen para todos los productos. '); ?></label>
              <div class="controls">
                <select class="form-control" name="data[posnum]">
                  <option value="1"<?= empty($cat['Category']['posnum']) ? ' selected' : '' ?>>Auto</option>
                  <option value="2"<?= @$cat['Category']['posnum'] == '2' ? ' selected' : '' ?>>Arriba</option>
                  <option value="3"<?= @$cat['Category']['posnum'] == '3' ? ' selected' : '' ?>>Abajo</option>
                </select>              
              </div>
              <small class="text-muted">Seleccioná la posición para las imágenes de los productos. Selecciona <b>Arriba</b> para ver rostros, <a>Abajo</a> para ver los zapatos</small>
            </div>

            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Alineación del texto dentro de la imagen'); ?></label>
              <div class="controls">
                <select class="form-control" name="data[alignnum]">
                  <option value="0"<?= empty($cat['Category']['alignnum']) ? ' selected' : '' ?>>Centro</option>
                  <option value="1"<?= @$cat['Category']['alignnum'] == '1' ? ' selected' : '' ?>>Izquierda</option>
                  <option value="2"<?= @$cat['Category']['alignnum'] == '2' ? ' selected' : '' ?>>Derecha</option>
                  <option value="3"<?= @$cat['Category']['alignnum'] == '3' ? ' selected' : '' ?>>Arriba</option>
                  <option value="4"<?= @$cat['Category']['alignnum'] == '4' ? ' selected' : '' ?>>Abajo</option>
                  <option value="5"<?= @$cat['Category']['alignnum'] == '5' ? ' selected' : '' ?>>Arriba/Izquierda</option>
                  <option value="6"<?= @$cat['Category']['alignnum'] == '6' ? ' selected' : '' ?>>Arriba/Derecha</option>
                  <option value="7"<?= @$cat['Category']['alignnum'] == '7' ? ' selected' : '' ?>>Abajo/Izquierda</option>
                  <option value="8"<?= @$cat['Category']['alignnum'] == '8' ? ' selected' : '' ?>>Abajo/Derecha</option>
                </select>              
              </div>
              <small class="text-muted">Seleccioná la posición para el texto dentro de las imágenes del shop.</small>
            </div>

            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Color Burbuja'); ?></label>
              <div class="controls">
                <input type="color" id="ribbon_color" name="data[ribbon_color]" value="<?= !empty($cat) ? $cat['Category']['ribbon_color'] : '' ?>">
              </div>
              <small class="text-muted">Seleccioná color de burbuja para esta categoría. <span class="text-info is-clickable" onclick="$('#ribbon_color').val('')">Resetear</span></small>
            </div>

            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Ordenar'); ?></label>
              <div class="controls">
                <input  class="form-control w-100" type="number" name="data[ordernum]" value="<?= !empty($cat) ? $cat['Category']['ordernum'] : '100' ?>">
              </div>
              <small class="text-muted">Seleccioná el orden de prioridad para esta categoría</small>
            </div>
          </div>
        </div>
        <div class="col-md-6"> 
          <h4 class="sub-header">Estado</h4>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Visible'); ?></label>
            <div class="form-group">
              <input type="checkbox" name="data[visible]" value="1" id="toggle" class="toggle-checkbox"<?= $item['Category']['visible'] == '1' ? ' checked' : '' ?>>
              <label for="toggle" class="toggle-label"></label>
            </div>
          </div>
          <div class="form-box bg-info-outline">
            <h4 class="sub-header"><?=__('Imágenes')?></h4>
            <p><?=__('Carga tus imágenes para esta categoría')?></p>
            <div class="control-group">
              <label class="control-label" for=""><?=__('Seleccione una imagen de banner para esta categoría')?></label>
              <?php if(!empty($cat['Category']['banner_url'])):?>
                
                <img src="<?php echo $settings['upload_url'].$cat['Category']['banner_url']?>" width="300">
              <?php endif ?>
              <div class="controls">
                <input class="form-control" type="file" class="attached" name="banner">
              </div>
            </div>

                   
            <div class="control-group">
              <label class="control-label" for=""><?=__('Seleccione una imagen de listado para esta categoría')?></label>
              <?php if(!empty($cat['Category']['img_url'])):?>
                
                <img src="<?php echo $settings['upload_url'].$cat['Category']['img_url']?>" width="300">
              <?php endif ?>
              <div class="controls">
                <input  class="form-control" type="file" class="attached" name="image">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for=""><?=__('Seleccione una imagen de Talles')?></label>
              <?php if(!empty($cat['Category']['size'])):?>
                
                <img src="<?php echo $settings['upload_url'].$cat['Category']['size']?>" width="300">
              <?php endif ?>
              <div class="controls">
                <input  class="form-control" type="file" class="attached" name="size">
              </div>
            </div>
          </div>
        </div>                
      </div>      
                     
      <div class="form-actions">
        <a href="/admin/categorias" class="btn btn-info"><i class="fa fa-chevron-left mr-1"></i> Atrás</a>
        <button type="reset" class="btn btn-danger" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="fa fa-close"></i> <span class="ml-1">Restaurar</span></button>
        <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check"></i> <span class="ml-1">Guardar</span></button>
      </div>
    </form>
  </div>
</div>