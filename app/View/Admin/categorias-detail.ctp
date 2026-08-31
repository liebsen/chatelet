<?php
  echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
  #echo $this->Html->script('category', array('inline' => false));
  echo $this->Html->script('form_app.js?v=' . $version['ver'], array('inline' => false));
  echo $this->Html->script('category_sizes.js?v=' . $version['ver'], array('inline' => false));
  echo $this->element('admin/menu');
?>

<div class="block-section">
  <div class="block-tabs">
    <!--div class="block-title">
      <h4><?php 
        echo (isset($category)) ? __('Editar Categoria') : __('Agregar Categoria');
      ?></h4>
    </div-->
    <div class="tab-content">
      <form action="" id="form_app" method="post" class="form-inline" enctype="multipart/form-data">
      	<input type="hidden" name="cb" value="category_sizes_update" data-exclude="1">
        <?php
          if (isset($this->request->pass[1])) {
            echo '<input type="hidden" name="data[id]" value="'. htmlspecialchars($this->request->pass[1]) .'" />';
          }
        ?>				<?php echo $this->element('admin/category-preview')?>

        <div class="row">
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="toggle"><?php echo __('Visible'); ?></label>
              <div class="form-group">
                <input type="checkbox" name="data[visible]" value="1" id="toggle" class="toggle-checkbox"<?= $category['Category']['visible'] == '1' ? ' checked' : '' ?>>
                <label for="toggle" class="toggle-label"></label>
              </div>
            </div>
	          <div class="control-group">
	            <label class="control-label" for="columns-text"><?php echo __('Nombre'); ?></label>
	            <div class="controls">
	              <input class="form-control w-100" type="text" id="" name="data[name]" value="<?=$category['Category']['name'] ?? ''; ?>" required>
	            </div>
	          </div>
	          <hr>


            <div class="form-box bg-info-outline">
              <h4 class="sub-header"><?=__('Descuentos')?></h4>
              <p><?=__('Establece descuentos')?></p>    
	            <div class="control-group">
	              <label class="control-label" for="columns-text"><?php echo __('Aplica descuentos por Tarjeta'); ?></label>
	              <div class="form-group">
	                <input type="checkbox" name="data[mp_discount_enable]" value="1" id="toggle-mp_discount" class="toggle-checkbox toggle-block" data-block=".mp-discount" data-class="d-none" <?= $category['Category']['mp_discount_enable'] == '1' ? ' checked' : '' ?>>
	                <label for="toggle-mp_discount" class="toggle-label"></label>
	              </div>
	            </div>

	            <div class="control-group mp-discount <?= empty($category['Category']['mp_discount_enable']) ? 'd-none' : '' ?>">
	              <label class="control-label" for="columns-text"><?php echo __('Descuento por Tarjeta'); ?></label>
	              <div class="controls">
	                <input  class="form-control w-100" type="number" name="data[mp_discount]" value="<?= !empty($category) ? $category['Category']['mp_discount'] : '0' ?>">
	              </div>
	              <small class="text-muted">Seleccioná el porcentaje de descuento. Si lo dejas en blanco se aplicará el descuento general de Tarjeta si hubiera.</small>
	            </div>

	            <div class="control-group">
	              <label class="control-label" for="columns-text"><?php echo __('Activar descuentos por Banco'); ?></label>
	              <div class="form-group">
	                <input type="checkbox" name="data[bank_discount_enable]" value="1" id="toggle-bank_discount" class="toggle-checkbox toggle-block" data-block=".bank-discount" data-class="d-none" <?= $category['Category']['bank_discount_enable'] == '1' ? ' checked' : '' ?>>
	                <label for="toggle-bank_discount" class="toggle-label"></label>
	              </div>
	            </div>
	            <div class="control-group bank-discount <?= empty($category['Category']['bank_discount_enable']) ? 'd-none' : '' ?>">
	              <label class="control-label" for="columns-text"><?php echo __('Descuento por Banco'); ?></label>
	              <div class="controls">
	                <input  class="form-control w-100" type="number" name="data[bank_discount]" value="<?= !empty($category) ? $category['Category']['bank_discount'] : '0' ?>">
	              </div>
	              <small class="text-muted">Seleccioná el porcentaje de descuento. Si lo dejas en blanco se aplicará el descuento general de Transferencia si hubiera.</small>
	            </div>
	          </div>
            <div class="form-box bg-info-outline<?=empty($category['Category']['id']) ? ' d-disable' : ''?>">
              <h4 class="sub-header"><?=__('Imágenes')?></h4>
              <p><?=__('Carga tus imágenes para esta categoría')?></p>
              <div class="control-group">
                <label class="control-label" for=""><?=__('Imagen principal')?></label>
                <?php if(!empty($category['Category']['img_url'])):?>
                  <a href="javascript:void(0)" class="<?=empty($category['Category']['id'])?'':'btn-preview'?>">
                  	<img class="img-rounded" src="<?php echo $settings['upload_url'].$category['Category']['img_url']?>" width="300">
                	</a>
                <?php endif ?>
                <div class="controls">
                  <input  class="form-control" type="file" class="attached" name="image">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for=""><?=__('Banner')?></label>
                <?php if(!empty($category['Category']['banner_url'])):?>
                  <img src="<?php echo $settings['upload_url'].$category['Category']['banner_url']?>" width="300">
                <?php endif ?>
                <div class="controls">
                  <input class="form-control" type="file" class="attached" name="banner">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for=""><?=__('Seleccione una imagen de Talles')?></label>
                <?php if(!empty($category['Category']['size'])):?>
                  
                  <img src="<?php echo $settings['upload_url'].$category['Category']['size']?>" width="300">
                <?php endif ?>
                <div class="controls">
                  <input  class="form-control" type="file" class="attached" name="size">
                </div>
              </div>
            </div>

          </div>
          <div class="col-md-6">
            <div class="form-box bg-info-outline">
              <h4 class="sub-header"><?=__('Talles')?></h4>
              <p><?=__('Indica talle original y su conversión correspondiente (ej: 7 => S)')?></p>            
            <?php foreach($sizes as $s => $size):?>
              <div class="control-group flex-nowrap flex-row gap-05">
                <select class="form-control" disabled>
                	<option value="" selected><?=sprintf('%03d', $size['CategorySize']['code'])?></option>
              	</select>
                <input type="text" class="form-control" value="<?=$size['CategorySize']['name']?>" disabled>
                <button class="btn btn-delete-size btn-danger form-control flex-1" data-id="<?=$size['CategorySize']['id']?>"><i class="fa fa-trash-o"></i></button>
             	</div>
            <?php endforeach ?>
              <div class="size-create-item">
              	<div class="control-group flex-nowrap flex-row gap-05">
	                <select class="form-control" name="sizes[code][]" data-change="1">
	                	<option value="">Código de talle</option>
	                <?php for($i=7; $i<21; $i++):?>
	                	<option value="<?=$i?>"><?=sprintf('%03d', $i)?></option>
	                <?php endfor?>
	              	</select>
	                <input type="text" class="form-control" name="sizes[name][]" placeholder="Nombre talle" value="" data-change="1">
	                <button class="btn btn-remove-size btn-danger form-control flex-1"><i class="fa fa-trash-o"></i></button>
	              </div>
             	</div>            
	            <div class="sizes-create-area"></div>
	            <button class="btn btn-success btn-create-size"><i class="gi gi-circle_plus"></i></button>
            </div>
          </div>                
        </div>      
                       
        <div class="form-actions">
          <a href="/admin/categorias" class="btn btn-info preview-toggle"><i class="fa fa-chevron-left mr-1"></i> Atrás</a>
          <button type="reset" class="btn btn-danger preview-toggle" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="fa fa-close"></i> <span class="ml-1">Restaurar</span></button>
          <button type="button" class="btn btn-warning btn-preview<?=empty($category['Category']['id'])?'  d-none':''?>" title="Previsualizar categoría"><i class="gi gi-font"></i> <span class="ml-1">Diseñar</span></button>
          <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check"></i> <span class="ml-1">Guardar</span></button>
        </div>
      </form>
    </div>
  </div>
</div>