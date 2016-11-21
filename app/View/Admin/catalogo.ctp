<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<div class="block block-themed">
  <div class="block-title">
    <h4><?php echo __('Catálogo') ?></h4>
  </div>
  <div class="block-content">
    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-4">
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Url del video'); ?></label>
            <div class="controls">
              <input type="text" id="" name="page_video" required value="<?php echo $page_video ?>">
            </div>
          </div>
          <br />
        </div>                
        <div class="col-md-4">
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Primer Linea'); ?></label>
            <div class="controls">
              <input type="text" id="" name="catalog_first_line" value="<?php echo $catalog_first_line ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Segunda Linea'); ?></label>
            <div class="controls">
              <input type="text" id="" name="catalog_second_line" value="<?php echo $catalog_second_line ?>">
            </div>
          </div>
        </div>
         <div class="col-md-4">
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Texto'); ?></label>
            <div class="controls">
              <input type="text" id="" name="catalog_text" value="<?php echo $catalog_text ?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Solapa'); ?></label>
            <div class="controls">
              <input type="text" id="" name="catalog_flap" value="<?php echo $catalog_flap ?>">
            </div>
          </div>
        </div>
      </div>
      <h4 class="sub-header">Fotos</h4>
      <div class="row">
        <div class="col-md-5">
          <div class="gallery" data-toggle="lightbox-gallery">
            <div class="row row-items">
              <?php
                if (empty($p['Catalog']['images'])):
              ?>
              <div class="col-md-5 gallery-image">
                <img src="/chatelet/img/placeholders/image_720x450_light.png" alt="image">
              </div>
            <?php
              else:
                $images = explode(';', $p['Catalog']['images']);
              foreach($images as $image):
            ?>
              <div class="col-md-5 gallery-image">
                <img src="<?php echo $this->webroot . 'files/uploads/' . $image; ?>" alt="image">
                <div class="gallery-image-options">
                  <a href="<?php echo $this->webroot . 'files/uploads/' . $image; ?>" class="gallery-link badge badge-info">
                    <i class="gemicon-small-search"></i>
                  </a>
                  <a  href="javascript:void(0)" 
                      class="badge badge-danger deletebutton"
                      data-id="<?=$image?>"                                           
                      data-url-back="<?=$this->here?>"
                      data-delurl="<?=$this->Html->url(array('action'=>'catalogo','deleteimg'))?>"
                      data-msg="<?=__('¿Eliminar imagen?')?>">
                    <i class="gemicon-small-remove-tag"></i>
                  </a>
                </div>
              </div>
            <?php
                endforeach;
              endif;
            ?>
            </div>
          </div>
        </div>
        <div class="col-md-7">
          <div class="control-group">
            <label class="control-label" for="file2">Select multiple files</label>
            <div class="controls">
              <input type="file" class="attached" name="pictures[]" multiple>
            </div>
          </div>
          <br><br>
        <div class="control-group">
            <!--<label class="control-label" for="columns-text">Imagenes</label>-->
            <div class="controls">
              <script id="image_thumb" type="text/x-handlebars-template" data-url="<?php echo $this->webroot . 'files/uploads/' ?>">
                <li style="margin-top:10px;margin-bottom:10px;">  
                  <img src="{{image}}" width="100"/> 
                  <a href="#" class="delete_image" data-input="[name='data[img_url]']" data-file="{{file}}">X</a>
                </li>
              </script>
              <ul id="images">
              </ul>
            </div>
          </div>
        </div>
      </div>      
      <br />               
      <div class="form-actions">
        <input type="hidden" name="id" value="1">
        <button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> Reset</button>
        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Submit</button>
      </div>
    </form>
  </div>
</div>