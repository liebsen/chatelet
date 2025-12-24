    <div class="wrapper-fluid">
      <div class="row m-0">
        <div class="col-xs-12 draggable-table">
          <div class="row category-item-container">
          <?php foreach($categories as $category): ?>
          <?php 
            $justify = 'center';
            $align = 'center';
            if($category['Category']['alignnum'] == 1) {
              $justify = 'start';
            }
            if($category['Category']['alignnum'] == 2) {
              $justify = 'end';
            }
          ?>
            <div class="category-item p-0 col-xs-12 col-md-<?= !empty($category['Category']['colsize']) ? $category['Category']['colsize'] : 'auto' ?> <?= $category['Category']['visible'] == '1' ? '' : 'bg-danger'?>" data-id="<?= $category['Category']['id'] ?>" data-order="<?= $category['Category']['ordernum'] ?>">
              <span class="category-item-image" style="background-image: url('<?php echo $settings['upload_url'].$category['Category']['img_url']?>')">
                <span class="category-image d-flex justify-content-<?php echo $justify ?> align-items-<?php echo $align ?> p-3 w-100">  
                  <span class="p-1 text-catalog text-uppercase text-<?php echo $justify ?>">
                    <?php echo 
                      $this->App->cat_title(
                        strlen($category['Category']['alternate_toggle']) ?  
                          $category['Category']['alternate_name'] : 
                          $category['Category']['name']
                        ) ?>
                  </span>
                </span>
              </span>
            </div>
          <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>