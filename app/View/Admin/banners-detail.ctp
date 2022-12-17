<?php
  echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
?>
<?php echo $this->element('admin-menu');?>
<div class="block block-themed">
  <div class="block-title">
    <h4><?php 
      echo (isset($item)) ? __('Editar Banner') : __('Agregar Banner');
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
          <h4 class="sub-header">Información Principal</h4>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Título'); ?></label>
            <div class="controls">
              <input class="form-control" type="text" id="" name="data[title]" value="<?php echo (isset($item)) ? $item['Banner']['title'] : ''; ?>" required>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Texto'); ?></label>
            <div class="controls">
              <textarea class="form-control" name="data[text]" required><?php echo (isset($item)) ? $item['Banner']['text'] : ''; ?></textarea>
            </div>
          </div>          
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Enlace'); ?></label>
            <div class="controls">
              <input class="form-control" type="text" id="" name="data[href]" value="<?php echo (isset($item)) ? $item['Banner']['href'] : ''; ?>" required>
            </div>
          </div>
          <br />
        </div>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Abrir enlace en otra pestaña'); ?></label>
            <div class="controls">
              <input type="checkbox" name="data[blank]" class="form-control" <?=(!empty($p['Home']['display_popup_form']))?'checked':''?>>
            </div>
          </div>          
          <br />       
          <div class="control-group">
            <label class="control-label" for=""><?=__('Seleccione una imagen de Banner')?></label>
            <div class="controls">
              <input class="form-control" type="file" class="attached" name="image">
            </div>
          </div>
          <br /> 
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Ordenar'); ?></label>
            <div class="controls">
              <input class="form-control" type="number" name="data[ordernum]" value="<?=  !empty($item) ? $item['Banner']['ordernum'] : '100' ?>">
            </div>
            <small class="text-muted">Seleccioná el orden de prioridad para esta banner</small>
          </div>
          <br />
        </div>  
        <br />              
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