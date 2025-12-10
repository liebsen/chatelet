    <div class="wrapper-fluid">
      <div class="row m-0">
        <div class="col-xs-12">
          <div class="row">
            <?php foreach($categories as $category): ?>
            <div class="category-item p-0 col-xs-12 col-md-<?= !empty($category['Category']['colsize']) ? $category['Category']['colsize'] : 'auto' ?>" style="background-image: url('<?php echo $settings['upload_url'].$category['Category']['img_url']?>')">
              <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($category['Category']['name'])))); ?>" class="pd1 text-center">
                <div class="d-flex justify-content-center align-items-center cat-image p-3 w-100">  
                    <span class="p-1 text-catalog text-uppercase">
                      <?php echo 
                        $this->App->cat_title(
                          strlen($category['Category']['alternate_toggle']) ?  
                            $category['Category']['alternate_name'] : 
                            $category['Category']['name']
                          ) ?>
                    </span>
                  </div>
              </a>
            </div>
            <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>