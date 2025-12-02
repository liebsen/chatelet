<?php
  echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
  echo $this->Html->css('lookbook-detail', array('inline' => false));
  echo $this->Html->script('lookbook-detail', array('inline' => false));
?>
<?php echo $this->element('admin-menu');?>
<div class="block">
  <div class="block-title">
    <h4>
    <?php
      echo __('Agregar Look Book');
    ?>
    </h4>
  </div>



  <div class="block-content">
    <form action=""  method="post" class="form-inline" enctype="multipart/form-data" >
     
      <div class="row">
        <div class="col-md-6">
          <h4 class="sub-header">Foto</h4>
              
          <div class="control-group">
            <label class="control-label" for=""></label>
            <div class="controls">
              <?php echo $this->element('lookbook_images') ?>
            </div>
          </div>
          <br />
         

        </div>
        <div class="col-md-6">
          <div class="control-group">
            <h4 class="sub-header"><?php echo __('Productos relacionados'); ?></h4>
            
        <div class="controls">
              <ul id="producto" class="list-group">
                <?php 
                  $options = ''; 
                  foreach($prods as &$prop){  
                  
                      $options.= "<option value='{$prop['Product']['id']}'>|Art.{$prop['Product']['article']}|{$prop['Product']['name']}</option>";
                  } 
                  echo  '<li class="list-group-item">'.
                          '<div class="colorSelector" style="opacity:0">'.
                            '<div style="background-color: #ffffff"></div>'.
                          '</div>'.
                          '<select class="code_sel" name="props[0][id]">'.$options.'</select>'.
                          '<div class="right">'.
                            '<a class="btn btn-danger remove-item">Borrar</a>'.
                          '</div>'.
                        '</li>';
                ?>
              </ul>
             
              <button type="button" class="add-item" data-type="producto">Agregar</button>
            </div>
          </div>
          <br />          
     
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

