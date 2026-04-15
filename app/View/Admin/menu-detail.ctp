<?php
  echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
?>
<?php echo $this->element('admin/menu');?>
<div class="block">
  <!--div class="block-title">
    <h4><?php 
      echo (isset($item)) ? __('Editar Menu') : __('Agregar Menu');
    ?></h4>
  </div-->

  <div class="tab-content">
    <form action="" method="post" class="form-inline">
      <?php
        if (isset($this->request->pass[1])) {
          echo '<input type="hidden" name="data[id]" value="'. htmlspecialchars($this->request->pass[1]) .'" />';
        }
      ?>
      <div class="row">
        <div class="col-md-6">
          <h4 class="sub-header">Información Principal</h4>
          <p>¿Deseas activar este menu?</p>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Estado'); ?></label>
            <div class="form-group">
              <input type="checkbox" name="data[enabled]" value="1" id="toggle" class="toggle-checkbox"<?= @$item['Menu']['enabled'] == '1' ? ' checked' : '' ?>>
              <label for="toggle" class="toggle-label"></label>
            </div>
            <!--small class="text-muted">Estado principal de este Menu</small-->
          </div>            
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Título'); ?></label>
            <div class="controls">
              <input class="form-control w-100" type="text" id="" name="data[title]" value="<?php echo (isset($item)) ? $item['Menu']['title'] : ''; ?>" required>
              <small class="text-muted">Nombre del menú</small>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Texto'); ?></label>
            <div class="controls">
              <textarea class="form-control" name="data[text]"><?php echo (isset($item)) ? $item['Menu']['text'] : ''; ?></textarea>
              <small class="text-muted">Descripción del menú que se mostrara en dispositivos de escritorio cuando se pose el mouse encima.</small>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Enlace'); ?></label>
            <div class="controls">
              <input class="form-control w-100" type="text" id="" name="data[href]" value="<?php echo (isset($item)) ? $item['Menu']['href'] : ''; ?>">
            </div>
            <small class="text-muted">Indica la URL que el menú debe seguir.</small>
          </div>          
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Categoría'); ?></label>
            <div class="controls">
              <select class="form-control" name="category_id">
                <option value="">Seleccione una categoría</option>
              <?php foreach($cats as $cat): ?>
                <option value="<?= $cat['Category']['id'] ?>"<?= isset($item) ? ($item['Menu']['category_id'] === $cat['Category']['id'] ? ' selected': '') : '' ?>><?= $cat['Category']['name'] ?></option>
              <?php endforeach ?>
              </select>
            </div>
            <small class="text-muted">Seleccioná la categoría que seguirá este menú. (No aplica en caso de tener Enlace activo)</small>
          </div>


          <br />
          <!--div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Enlace'); ?></label>
            <div class="controls">
              <input class="form-control" type="text" id="" name="data[href]" value="<?php echo (isset($item)) ? $item['Menu']['href'] : ''; ?>" required>
            </div>
          </div-->
          <br />
        </div>
        <div class="col-md-6">
          <h4 class="sub-header">Comportamiento</h4>
          <p>Indica como se debe comportar la interacción.</p>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Abrir enlace en otra pestaña'); ?></label>
            <div class="form-group">
              <input type="checkbox" name="data[target_blank]" value="1" id="toggle_target_blank" class="toggle-checkbox"<?= @$item['Menu']['target_blank'] == '1' ? ' checked' : '' ?>>
              <label for="toggle_target_blank" class="toggle-label"></label>
            </div>
          </div>          
          <br />       
          <!--div class="control-group">
            <label class="control-label" for=""><?=__('Seleccione una imagen de Menu')?></label>
            <div class="controls">
              <input class="form-control" type="file" class="attached" name="image">
            </div>
          </div-->
          <br /> 
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Ordenar'); ?></label>
            <div class="controls">
              <input class="form-control w-100" type="number" name="data[ordernum]" value="<?=  !empty($item) ? $item['Menu']['ordernum'] : '100' ?>">
            </div>
            <small class="text-muted">Seleccioná el orden de prioridad para esta banner</small>
          </div>
          <br />
        </div>  
        <br />              
      </div>      
      <br />               
      <div class="form-actions">
        <a href="/admin/menu" class="btn btn-info"><i class="fa fa-chevron-left"></i> <span class="ml-1">Atrás</span></a>
        <button type="reset" class="btn btn-danger" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="fa fa-close"></i> <span class="ml-1">Restaurar</span></button>
        <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check"></i> <span class="ml-1">Guardar</span></button>
      </div>
    </form>
  </div>
</div>