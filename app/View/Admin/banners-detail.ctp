<?php
  echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
?>
<?php echo $this->Html->script('application-form.js?v=' . $version['ver'], array('inline' => false)); ?>
<?php echo $this->element('admin/menu');?>
<div class="block-section">
<div class="block-tabs">
  <div class="tab-content">
    <form action="" id="form_app" method="post" class="form-inline" enctype="multipart/form-data">
      <?php
        if (isset($this->request->pass[1])) {
          echo '<input type="hidden" name="data[id]" value="'. htmlspecialchars(@$this->request->pass[1]) .'" />';
        }
      ?>
      <div class="row">
        <div class="col-md-6">
          <h4 class="sub-header"><?php echo __('Estado') ?></h4>
          <div class="form-group flex-end flex-between gap-05">
            <div class="controls flex-1">
              <label class="control-label" for="columns-text"><?php echo __('Activo'); ?></label>
              <input type="checkbox" name="data[enabled]" value="1" id="toggle" class="toggle-checkbox"<?= @$item['Banner']['enabled'] == '1' ? ' checked' : '' ?>>
              <label for="toggle" class="toggle-label"></label>
            </div>
          </div>
          <h4 class="sub-header">Información Principal</h4>
          <!--div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Título'); ?></label>
            <div class="controls">
              <input class="form-control" type="text" id="" name="data[title]" value="<?php echo (isset($item)) ? $item['Banner']['title'] : ''; ?>" required>
            </div>
          </div-->

          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Texto'); ?></label>
            <div class="controls">
              <textarea class="form-control w-100" name="data[text]"><?php echo (isset($item)) ? $item['Banner']['text'] : ''; ?></textarea>
            </div>
          </div>          
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Enlace'); ?></label>
            <div class="controls">
              <input class="form-control w-100" type="text" id="" name="data[href]" value="<?php echo (isset($item)) ? $item['Banner']['href'] : ''; ?>" required>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for=""><?=__('Seleccione una imagen de Banner')?></label>
            <div class="controls">
              <input class="form-control" type="file" class="attached" name="image">
            </div>
          </div>          
        </div>
        <div class="col-md-6">
          <h4 class="sub-header"><?php echo __('Comportamiento') ?></h4>
          <div class="form-group">
            <div class="controls">
              <label class="control-label text-left" for="columns-text"><?php echo __('Abrir enlace en otra pestaña'); ?></label>
              <input type="checkbox" name="data[target_blank]" value="1" id="toggle_target_blank" class="toggle-checkbox"<?= @$item['Banner']['target_blank'] == '1' ? ' checked' : '' ?>>
              <label for="toggle_target_blank" class="toggle-label"></label>
            </div>        
          </div>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Ordenar'); ?></label>
            <div class="controls">
              <input class="form-control w-100" type="number" name="data[ordernum]" value="<?=  !empty($item) ? $item['Banner']['ordernum'] : '100' ?>">
            </div>
            <small class="text-muted">Seleccioná el orden de prioridad para esta banner</small>
          </div>
          <br />
        </div>  
        <br />              
      </div>      
      <br />               
      <div class="form-actions">
        <a href="/admin/banners" class="btn btn-info"><i class="fa fa-chevron-left mr-1"></i> Atrás</a>
        <button type="reset" class="btn btn-danger" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="fa fa-close"></i> <span class="ml-1">Restaurar</span></button>
        <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario" disabled><i class="fa fa-check"></i> <span class="ml-1">Guardar</span></button>
      </div>
    </form>
  </div>
</div>
</div>