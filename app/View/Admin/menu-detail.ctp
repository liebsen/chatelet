<?php
  echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
?>
<?php echo $this->element('admin-menu');?>
<div class="block block-themed">
  <div class="block-title">
    <h4><?php 
      echo (isset($item)) ? __('Editar Menu') : __('Agregar Menu');
    ?></h4>
  </div>

  <div class="block-content">
    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
      <?php
        if (isset($this->request->pass[1])) {
          echo '<input type="hidden" name="data[id]" value="'. htmlspecialchars($this->request->pass[1]) .'" />';
        }
      ?>
      <div class="row">
        <div class="col-md-6">
          <div class="control-group">
            <!--label class="control-label" for="columns-text"><?php echo __('Estado'); ?></label-->
            <div class="controls text-center switch-scale">
              <?php
                $enabled = (isset($item) && $item['Menu']['enabled'] === '1') || !isset($item) ? 'checked' : '';
                $disabled = (isset($item) && $item['Menu']['enabled'] === '0') ? 'checked' : '';
              ?>
              <label for="enabled_1">Activo</label> <input type="radio" class="form-control" id="enabled_1" name="data[enabled]" value="1" <?php echo $enabled; ?> /> &nbsp; 
              <label for="enabled_0">Inactivo</label> <input type="radio" class="form-control" id="enabled_0" name="data[enabled]" value="0" <?php echo $disabled; ?> />
            </div>
            <!--small class="text-muted">Estado principal de este Menu</small-->
          </div>          
          <h4 class="sub-header">Información Principal</h4>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Título'); ?></label>
            <div class="controls">
              <input class="form-control" type="text" id="" name="data[title]" value="<?php echo (isset($item)) ? $item['Menu']['title'] : ''; ?>" required>
            </div>
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
          </div>

          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Texto'); ?></label>
            <div class="controls">
              <textarea class="form-control" name="data[text]" required><?php echo (isset($item)) ? $item['Menu']['text'] : ''; ?></textarea>
            </div>
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
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Abrir enlace en otra pestaña'); ?></label>
            <div class="controls">
              <input type="checkbox" name="data[target_blank]" class="form-control"<?= $item['Menu']['target_blank'] === 'on' ? ' checked' : '' ?>>
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
              <input class="form-control" type="number" name="data[ordernum]" value="<?=  !empty($item) ? $item['Menu']['ordernum'] : '100' ?>">
            </div>
            <small class="text-muted">Seleccioná el orden de prioridad para esta banner</small>
          </div>
          <br />
        </div>  
        <br />              
      </div>      
      <br />               
      <div class="form-actions">
        <a href="/admin/menu" class="btn btn-info"><i class="icon-repeat"></i> Atrás</a>
        <button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> Reset</button>
        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Submit</button>
      </div>
    </form>
  </div>
</div>