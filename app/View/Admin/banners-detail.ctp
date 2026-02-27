<?php
  echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
?>
<?php echo $this->element('admin-menu');?>
<div class="block">
  <div class="block-title">
    <h4><?php 
      echo (isset($item)) ? __('Editar Banner') : __('Agregar Banner');
    ?></h4>
  </div>

  <div class="block-content">
    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
      <?php
        if (isset($this->request->pass[1])) {
          echo '<input type="hidden" name="data[id]" value="'. htmlspecialchars(@$this->request->pass[1]) .'" />';
        }
      ?>
      <div class="row">
        <div class="col-md-6">
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
          <h4 class="sub-header"><?php echo __('Estado') ?></h4>
          <div class="control-group">
            <!--label class="control-label" for="columns-text"><?php echo __('Estado'); ?></label-->
            <div class="controls text-center switch-scale">
              <?php
                $enabled = (isset($item) && @$item['Banner']['enabled'] === '1') || !isset($item) ? 'checked' : '';
                $disabled = (isset($item) && @$item['Banner']['enabled'] === '0') ? 'checked' : '';
              ?>
              <span>
                <input type="radio" class="form-control" id="enabled_1" name="data[enabled]" value="1" <?php echo $enabled; ?> /> 
                <label for="enabled_1">Activo</label>
              </span>
              <span>
                <input type="radio" class="form-control" id="enabled_0" name="data[enabled]" value="0" <?php echo $disabled; ?> />
                <label for="enabled_0">Inactivo</label>
              </span>
            </div>
            <!--small class="text-muted">Estado principal de este Banner</small-->
          </div>          

          <div class="control-group">
            <label class="control-label" for="target_blank"><input type="checkbox" name="data[target_blank]" id="target_blank" class="form-control"<?= @$item['Banner']['target_blank'] === 'on' ? ' checked' : '' ?>> <?php echo __('Abrir enlace en otra pestaña'); ?>  </label>
          </div>          
          <br />       
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
        <button type="reset" class="btn btn-danger" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="fa fa-close mr-1"></i> Restaurar</button>
        <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
      </div>
    </form>
  </div>
</div>