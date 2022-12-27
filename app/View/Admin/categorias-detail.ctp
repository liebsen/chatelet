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
            <label class="control-label" for=""><?=__('Seleccione una imagen de Categoría')?></label>
            <?php if(!empty($cat['Category']['img_url'])):?>
              <hr>
              <img src="<?php echo Configure::read('imageUrlBase').$cat['Category']['img_url']?>" width="300">
            <?php endif ?>
            <div class="controls">
              <input  class="form-control" type="file" class="attached" name="image">
            </div>
          </div>
          <br /> 
          <div class="control-group">
            <label class="control-label" for=""><?=__('Seleccione una imagen de Talles')?></label>
            <?php if(!empty($cat['Category']['size'])):?>
              <hr>
              <img src="<?php echo Configure::read('imageUrlBase').$cat['Category']['size']?>" width="300">
            <?php endif ?>
            <div class="controls">
              <input  class="form-control" type="file" class="attached" name="size">
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Ancho de columna'); ?></label>
            <div class="controls">
              <select class="form-control" name="data[colsize]">
                <option value="6"<?= empty($cat['Category']['colsize']) ? ' selected' : '' ?>>Auto</option>
                <option value="2"<?= @$cat['Category']['colsize'] == '2' ? ' selected' : '' ?>>20%</option>
                <option value="3"<?= @$cat['Category']['colsize'] == '3' ? ' selected' : '' ?>>25%</option>
                <option value="4"<?= @$cat['Category']['colsize'] == '4' ? ' selected' : '' ?>>33%</option>
                <option value="6"<?= @$cat['Category']['colsize'] == '6' ? ' selected' : '' ?>>50%</option>
                <option value="12"<?= @$cat['Category']['colsize'] == '12' ? ' selected' : '' ?>>100%</option>
              </select>              
            </div>
            <small class="text-muted">Seleccioná el ancho de columna para esta categoría (solo para dispositivos de escritorio y smart-tv).</small>
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
        <button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> Reset</button>
        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Submit</button>
      </div>
    </form>
  </div>
</div>