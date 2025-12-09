<?php
  echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
  echo $this->Html->css('productos-detail', array('inline' => false));
  if($this->request->params['pass'][0]=="add"){
    echo $this->Html->script('productos-detail-add', array('inline' => false));
  } else {
    echo $this->Html->script('productos-detail', array('inline' => false));
  }  
  /* ColorPicker */
  echo $this->Html->css('colorpicker', array('inline' => false));
  echo $this->Html->script('colorpicker', array('inline' => false));
?>
<?php echo $this->element('admin-menu');?>
<div class="block">
  <div class="block-title">
    <h4>
    <?php
      echo (isset($prod)) ? __('Editar Producto') : __('Agregar Producto');
    ?>
    </h4>
  </div>

  <div class="hide" id="colors_select_base">
    <select class="code_sel" name="">
      <?php foreach ($colors as $color): ?>
        <?php  
          echo "<option value='{$color['code']}'>{$color['code']} / {$color['desc']}</option>";
        ?>
      <?php endforeach ?>
    </select>
  </div>

  <div class="block-content">
    <form action="" id="productos-detail" method="post" class="form-inline" enctype="multipart/form-data" data-article-url="<?php echo Router::url(array( 'action' => 'check_article' )) ?>">
      <?php
        if (isset($this->request->pass[1])) {
          echo '<input type="hidden" id="product_id" name="data[id]" value="'. htmlspecialchars($this->request->pass[1]) .'" />';
        }
      ?>
      <div class="row">
        <div class="col-md-6">
          <h4 class="sub-header">Información Principal</h4>
          <div class="control-group">
            <label class="control-label" for="columns-text">
            <?php echo __('Código de lista de precios'); ?></label>
            <div class="controls">  
             <?php if(!empty($list_code)){ ?>  
              <input type="number" name="list_code" id="lis_cod" value="<?php echo @$list_code ?>"/>
             <?php }else{ ?>
              <input type="text" id="lis_cod" />
             <?php } ?>
            </div>
          </div>
          <br />
          <div class="control-group">  
            <label class="control-label" for="columns-text">
            <?php echo __('Código de lista de precios con Descuento'); ?></label>
            <div class="controls">  
             <?php if(!empty($list_code)){ ?>  
              <input type="number" name="list_code_desc" id="lis_cod2" value="<?php echo @$list_code_desc ?>"/>
             <?php }else{ ?>
              <input type="text" id="lis_cod2" />
             <?php } ?>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Código de producto'); ?></label>
            <div class="controls">
              <input type="text" id="prod_cod" value="<?php echo (isset($prod)) ? $prod['Product']['cod_chatelet'] : ''; ?>">
              <button type="button" id="buscar" class="btn btn-sm btn-default" data-url="<?php echo $this->Html->url(array('controller' => 'admin', 'action' => 'get_product')) ?>">Buscar</button>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Mostrar Descuento? (0 o vacio para ignorar)'); ?></label>
            <small>Este descuento no se mostrará actualizado hasta ejecutar el boton "Sincronizar Descuentos"</small>
            <div class="controls">
              <input type="text" id="" name="discount_label" value="<?php echo (isset($prod)) ? $prod['Product']['discount_label'] : ''; ?>">
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Nombre'); ?></label>
            <div class="controls">
              <input type="text" id="" name="name" value="<?php echo (isset($prod)) ? $prod['Product']['name'] : ''; ?>" required>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Descripción'); ?></label>
            <div class="controls">
              <textarea name="desc" rows=5><?php echo (isset($prod)) ? $prod['Product']['desc'] : ''; ?></textarea>
              <!--input type="text" id="" name="desc" value="<?php echo (isset($prod)) ? $prod['Product']['desc'] : ''; ?>" -->
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Precio actual'); ?></label>
            <div class="controls">
              <input type="text" id="" name="price" value="<?php echo (isset($prod)) ? $prod['Product']['price'] : ''; ?>" required>
            </div>
          </div>
           <br/>
            <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Precio descuento'); ?></label>
            <div class="controls">
              <input type="text" id="" name="discount" value="<?php echo (isset($prod)) ? $prod['Product']['discount'] : ''; ?>" required>
            </div>
          </div>
          <br/>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Porcentaje descuento con mercadopago'); ?></label>
            <div class="controls">
              <input class="form-control" type="number" id="" name="mp_discount" value="<?php echo (isset($prod)) ? $prod['Product']['mp_discount'] : ''; ?>" required>
            </div>
          </div>
          <br/>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Porcentaje descuento con transferencia'); ?></label>
            <div class="controls">
              <input class="form-control" type="number" id="" name="bank_discount" value="<?php echo (isset($prod)) ? $prod['Product']['bank_discount'] : ''; ?>" required>
            </div>
          </div>
          <br/>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Color de burbuja de descuento'); ?></label>
            <div class="controls">
              <input class="form-control" type="color" id="" name="bubble_color" value="<?php echo (isset($prod)) ? $prod['Product']['bubble_color'] : ''; ?>" required>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Promoción'); ?></label>
            <div class="controls">
              <select class="form-control" name="promo">
                <option value="">No</option>
                <option value="2x1"<?= $prod['Product']['promo'] === '2x1' ? ' selected' : '' ?>>2x1</option>
                <option value="3x2"<?= $prod['Product']['promo'] === '3x2' ? ' selected' : '' ?>>3x2</option>
              </select>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Visible'); ?></label>
            <div class="controls">
              <select class="form-control" name="visible">
                <option value="1"<?= $prod['Product']['visible'] ? ' selected' : '' ?>>Sí</option>
                <option value="0"<?= !$prod['Product']['visible'] ? ' selected' : '' ?>>No</option>
              </select>
            </div>
          </div>
          <br />

          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Ordenar'); ?></label>
            <div class="controls">
              <input type="number" name="data[ordernum]" value="<?= @$cat['Category']['ordernum']?>">
            </div>
            <small class="text-muted">Seleccioná el orden de prioridad este producto</small>
          </div>
          <br>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Número de artículo'); ?></label>
            <div class="controls">
              <input type="text" id="" name="article" value="<?php echo (isset($prod)) ? $prod['Product']['article'] : ''; ?>" required>
            </div>
          </div>
          
          <br />
          <div class="control-group">
            <label class="control-label" for=""><?=__('Colores')?></label>
            <div class="controls">
              <ul id="color" class="list-group">
                <?php
                  if (isset($props)) {
                    foreach ($props as $index => $prop) {
                      $type = $prop['ProductProperty']['type'];
                      $alias = str_replace(' ', '_', $prop['ProductProperty']['alias']);
                      $variable = $prop['ProductProperty']['variable'];
                      $id = $prop['ProductProperty']['id'];
                      $product_id = $prop['ProductProperty']['product_id'];
                      $imagesArr = (!empty($prop['ProductProperty']['images']))?explode(';',$prop['ProductProperty']['images']):array();
                      $images = '';
                      foreach($imagesArr as $img){
                        if(!empty($img)){
                          $images = $images . '<li><img src="'.$settings['upload-url'].'thumb_'.$img.'" width="100px"><a href="#" class="delete_image_color" data-alias="'.$alias.'" data-file="'.$img.'" data-url="'.Router::url('/admin/deleteImageColor').'" data-id="'.$prop['ProductProperty']['id'].'">X</a></li>';
                        }
                      }
                      $options = '';
                      foreach($colors as &$color){
                        if($color['code'] == $prop['ProductProperty']['code'])
                          $options.= "<option value='{$color['code']}' selected>{$color['code']} / {$color['desc']}</option>";
                        else
                          $options.= "<option value='{$color['code']}'>{$color['code']} / {$color['desc']}</option>";
                      }

                      if ($type == 'color') {
                        echo '<li class="list-group-item">'.
                              '<div class="colorSelector" style="opacity:0">'.
                                '<div style="background-color: '. $variable .';"></div>'.
                              '</div>'.
                             '<input type="hidden" name="props['. $index .'][variable]" value="'. $variable .'" class="variable" required var/>'.
                             '<input type="hidden" name="props['. $index .'][id]" value="'. $id .'" />'.
                             '<input type="hidden" name="props['. $index .'][type]" value="'. $type .'"/>'.
                             '<input type="hidden" name="props['. $index .'][product_id]" value="'. $product_id .'" />'.
                             '<select class="code_sel" name="props['. $index .'][code]">'.$options.'</select>'.
                             '<span class="alias_cont"><input type="text" name="props['. $index .'][alias]" value="'.$prop['ProductProperty']['alias'].'" class="changed variable" required placeholder="AA, 02, etc..."/></span>'.
                              '<div class="right">'.
                                '<a class="btn btn-danger remove-item" data-count="'.$index.'">Borrar</a>'.
                              '</div>'.
                              '<input type="file" class="upload_color_image" id="ColorImage'.$alias.'" name="color_image" data-alias="'.$alias.'" data-url="'.Router::url('/admin/uploadImageColor').'" data-count="'.$index.'">'.
                              '<progress id="progress'.$alias.'" hidden></progress>'.
                              '<ul id="ListUploaded" class="list-inline">'.$images.'</ul>'.
                            '</li>';
                      }
                    }
                  }
                ?>
              </ul>
              <button type="button" class="add-item" data-type="color">Agregar</button>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for=""><?=__('Talles')?></label>
            <div class="controls">
              <ul id="size" class="list-group">
                <?php
                  if (isset($props)) {
                    foreach ($props as $index => $prop) {
                      $type = $prop['ProductProperty']['type'];
                      $variable = $prop['ProductProperty']['variable'];
                      $id = $prop['ProductProperty']['id'];
                      $product_id = $prop['ProductProperty']['product_id'];
                      if ($type == 'size') {
                        echo '<li class="list-group-item">'.
                             '<input type="text" name="props['. $index .'][variable]" value="'. $variable .'" var required />'.
                             '<input type="hidden" name="props['. $index .'][id]" value="'. $id .'" />'.
                             '<input type="hidden" name="props['. $index .'][type]" value="'. $type .'" />'.
                             '<input type="hidden" name="props['. $index .'][product_id]" value="'. $product_id .'" />'.
                          '<div class="right">'.
                            '<a class="btn btn-danger remove-item" data-count="'.$index.'">Borrar</a>'.
                          '</div>'.
                        '</li>';
                      }
                    }
                  }
                ?>
              </ul>
              <button type="button" class="add-item" data-type="size">Agregar</button>
            </div>
          </div>
          <br />
        </div>
        <div class="col-md-6">
          <div class="control-group">
            <h4 class="sub-header"><?php echo __('Categoría'); ?></h4>
            <div class="controls">
              <?php echo $this->element('treeview');?>
            </div>
          </div>
          <br />          
          <h4>Imagen principal</h4>
          <div class="control-group">
            <label class="control-label" for=""></label>
            <div class="controls">
              <input type="file" class="attached" name="image">
            </div>
          </div>
          <br />
          <?php echo $this->element('product_images') ?>
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