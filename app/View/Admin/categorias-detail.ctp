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
        echo (isset($cat)) ? __('Editar Categoria') : __('Agregar Categoria');
      ?></h4>
    </div-->
    <div class="tab-content">
      <form action="" id="form_app" method="post" class="form-inline" enctype="multipart/form-data">
      	<input type="hidden" name="cb" value="category_sizes_update" data-exclude="1">
        <?php
          if (isset($this->request->pass[1])) {
            echo '<input type="hidden" name="data[id]" value="'. htmlspecialchars($this->request->pass[1]) .'" />';
          }
        ?>
        <div class="row">
          <div class="col-md-6">
            <h4 class="sub-header">Datos básicos</h4>
            <div class="control-group">
              <label class="control-label" for="toggle"><?php echo __('Visible'); ?></label>
              <div class="form-group">
                <input type="checkbox" name="data[visible]" value="1" id="toggle" class="toggle-checkbox"<?= $cat['Category']['visible'] == '1' ? ' checked' : '' ?>>
                <label for="toggle" class="toggle-label"></label>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="toggle2"><?php echo __('Mostrar Texto'); ?></label>
              <div class="form-group">
                <input type="checkbox" name="data[alternate_toggle]" value="1" id="toggle2" class="toggle-checkbox  toggle-block" data-block=".texts-block" data-class="d-none"<?= $cat['Category']['alternate_toggle'] == '1' ? ' checked' : '' ?>>
                <label for="toggle2" class="toggle-label"></label>
              </div>
            </div>

            <div class="form-box bg-info-outline texts-block<?= $cat['Category']['alternate_toggle'] == '1' ? '' : ' d-none' ?>">
              <h4 class="sub-header"><?=__('Textos')?></h4>            
	            <div class="control-group">
	              <label class="control-label" for="columns-text"><?php echo __('Nombre Principal'); ?></label>
	              <div class="controls">
	                <input class="form-control w-100" type="text" id="" name="data[name]" value="<?php echo (isset($cat)) ? $cat['Category']['name'] : ''; ?>" required>
	              </div>
	            </div>
	            <div class="control-group">
	              <label class="control-label" for="columns-text"><?php echo __('Descripción'); ?></label>
	              <div class="controls">
	                <textarea name="data[text]" class="form-control w-100" rows="8"><?= @$cat['Category']['text'] ?></textarea>
	              </div>
	              <small class="text-muted">Descripción de categoría</small>
	            </div>
              <div class="control-group">
                <label class="control-label" for="text_size"><?php echo __('Tamaño texto descripción (px)'); ?></label>
                <div class="controls">
                  <select class="form-control" id="text_size" name="data[text_size]">
                  	<option value="">Selecciona un tamaño para el texto</option>
                  	<?php for($n = 9; $n < 31; $n++):?>
                    <option value="<?=$n?>"<?= @$cat['Category']['text_size'] == $n ? ' selected' : '' ?>><?=$n?>px</option>
                  	<?php endfor ?>
                  </select>              
                </div>
                <small class="text-muted">Seleccioná la posición para las imágenes de los productos. Selecciona <b>Arriba</b> para ver rostros, <a>Abajo</a> para ver los zapatos</small>
              </div>
              <div class="control-group">
                <label class="control-label" for="text_weight"><?php echo __('Peso de texto descripción'); ?></label>
                <div class="controls">
                  <select class="form-control" id="text_weight" name="data[text_weight]">
                  	<option value="">Selecciona un peso para el texto</option>
                    <option value="300"<?= @$cat['Category']['text_weight'] == '300' ? ' selected' : '' ?>>300</option>
                    <option value="400"<?= @$cat['Category']['text_weight'] == '400' ? ' selected' : '' ?>>400</option>
                    <option value="500"<?= @$cat['Category']['text_weight'] == '500' ? ' selected' : '' ?>>500</option>
                    <option value="600"<?= @$cat['Category']['text_weight'] == '600' ? ' selected' : '' ?>>600</option>
                    <option value="700"<?= @$cat['Category']['text_weight'] == '700' ? ' selected' : '' ?>>700</option>
                    <option value="800"<?= @$cat['Category']['text_weight'] == '800' ? ' selected' : '' ?>>800</option>
                    <option value="900"<?= @$cat['Category']['text_weight'] == '900' ? ' selected' : '' ?>>900</option>
                    <option value="1000"<?= @$cat['Category']['text_weight'] == '1000' ? ' selected' : '' ?>>1000</option>
                  </select>              
                </div>
                <small class="text-muted">Seleccioná la posición para las imágenes de los productos. Selecciona <b>Arriba</b> para ver rostros, <a>Abajo</a> para ver los zapatos</small>
              </div>
							<div class="control-group">
							  <label class="control-label" for="text_color"><?php echo __('Color Texto'); ?></label>
							  <div class="controls">
							  	<input type="color" id="text_color" name="data[text_color]" value="<?= @$cat['Category']['text_color'] ?>">
							  </div>
	              <small class="text-muted">Seleccioná color de texto para esta categoría. <span class="text-info is-clickable" onclick="$('#text_color').val('')">Resetear</span></small>
							</div>
						</div>

            <div class="form-box bg-info-outline">
              <h4 class="sub-header"><?=__('Propiedades')?></h4>
              <p><?=__('Selecciona como deseas ver tu categoría')?></p>            
              <!--div class="control-group">
                <label class="control-label" for="alternatename"><?php echo __('Activar Nombre Alternativo'); ?></label>
                <div class="form-group">
                  <input type="checkbox" id="alternatename" name="data[alternate_toggle]" value="1" id="toggle" class="toggle-checkbox toggle-block" data-block=".show-alternate" data-class="d-none" <?= $cat['Category']['alternate_toggle'] == '1' ? ' checked' : '' ?>>
                  <label for="alternatename" class="toggle-label"></label>
                </div>
                <div class="control-group show-alternate<?= $cat['Category']['alternate_toggle'] == '1' ? '' : ' d-none' ?>">
	                <label class="control-label" for="alternatename"><?php echo __('Nombre Alternativo'); ?></label>
                  <div class="controls alternate_name_block">
                    <input class="form-control w-100" type="text" id="alternate_name_target" name="data[alternate_name]" value="<?php echo (isset($cat)) ? $cat['Category']['alternate_name'] : ''; ?>">
                  </div>
                </div>
              </div-->
              
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
                <label class="control-label" for="columns-text"><?php echo __('Alineación del texto'); ?></label>
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
                <label class="control-label" for="columns-text"><?php echo __('Ordenar'); ?></label>
                <div class="controls">
                  <input  class="form-control w-100" type="number" name="data[ordernum]" value="<?= !empty($cat) ? $cat['Category']['ordernum'] : '100' ?>">
                </div>
                <small class="text-muted">Seleccioná el orden de prioridad para esta categoría</small>
              </div>
	            <div class="control-group">
	              <label class="control-label" for="ribbon_color"><?php echo __('Color Burbuja'); ?></label>
	              <div class="controls">
	                <input type="color" id="ribbon_color" name="data[ribbon_color]" value="<?=@$cat['Category']['ribbon_color']??'#333' ?>">
	              </div>
	              <small class="text-muted">Seleccioná color de burbuja para esta categoría. <span class="text-info is-clickable" onclick="$('#ribbon_color').val('')">Resetear</span></small>
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

            <div class="form-box bg-info-outline">
              <h4 class="sub-header"><?=__('Descuentos')?></h4>
              <p><?=__('Establece descuentos')?></p>    
	            <div class="control-group">
	              <label class="control-label" for="columns-text"><?php echo __('Aplica descuentos por Tarjeta'); ?></label>
	              <div class="form-group">
	                <input type="checkbox" name="data[mp_discount_enable]" value="1" id="toggle-mp_discount" class="toggle-checkbox toggle-block" data-block=".mp-discount" data-class="d-none" <?= $cat['Category']['mp_discount_enable'] == '1' ? ' checked' : '' ?>>
	                <label for="toggle-mp_discount" class="toggle-label"></label>
	              </div>
	            </div>

	            <div class="control-group mp-discount <?= empty($cat['Category']['mp_discount_enable']) ? 'd-none' : '' ?>">
	              <label class="control-label" for="columns-text"><?php echo __('Descuento por Tarjeta'); ?></label>
	              <div class="controls">
	                <input  class="form-control w-100" type="number" name="data[mp_discount]" value="<?= !empty($cat) ? $cat['Category']['mp_discount'] : '0' ?>">
	              </div>
	              <small class="text-muted">Seleccioná el porcentaje de descuento. Si lo dejas en blanco se aplicará el descuento general de Tarjeta si hubiera.</small>
	            </div>

	            <div class="control-group">
	              <label class="control-label" for="columns-text"><?php echo __('Activar descuentos por Banco'); ?></label>
	              <div class="form-group">
	                <input type="checkbox" name="data[bank_discount_enable]" value="1" id="toggle-bank_discount" class="toggle-checkbox toggle-block" data-block=".bank-discount" data-class="d-none" <?= $cat['Category']['bank_discount_enable'] == '1' ? ' checked' : '' ?>>
	                <label for="toggle-bank_discount" class="toggle-label"></label>
	              </div>
	            </div>
	            <div class="control-group bank-discount <?= empty($cat['Category']['bank_discount_enable']) ? 'd-none' : '' ?>">
	              <label class="control-label" for="columns-text"><?php echo __('Descuento por Banco'); ?></label>
	              <div class="controls">
	                <input  class="form-control w-100" type="number" name="data[bank_discount]" value="<?= !empty($cat) ? $cat['Category']['bank_discount'] : '0' ?>">
	              </div>
	              <small class="text-muted">Seleccioná el porcentaje de descuento. Si lo dejas en blanco se aplicará el descuento general de Transferencia si hubiera.</small>
	            </div>
	          </div>

            <div class="form-box bg-info-outline<?=empty($cat['Category']['id']) ? ' d-disable' : ''?>">
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
</div>