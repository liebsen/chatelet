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
                  <span class="category-toolbox">
                    <div class="control-group">
                      <div class="controls">
                        <select class="form-control select-grid" name="data[colsize]">
                          <option value="6"<?= empty($category['Category']['colsize']) ? ' selected' : '' ?>>Auto</option>
                          <!--option value="2"<?= @$category['Category']['colsize'] == '2' ? ' selected' : '' ?>>16.66%</option-->
                          <option value="20"<?= @$category['Category']['colsize'] == '20' ? ' selected' : '' ?>>20%</option>
                          <option value="3"<?= @$category['Category']['colsize'] == '3' ? ' selected' : '' ?>>25%</option>
                          <option value="4"<?= @$category['Category']['colsize'] == '4' ? ' selected' : '' ?>>33%</option>
                          <option value="40"<?= @$category['Category']['colsize'] == '40' ? ' selected' : '' ?>>40%</option>
                          <option value="6"<?= @$category['Category']['colsize'] == '6' ? ' selected' : '' ?>>50%</option>
                          <option value="60"<?= @$category['Category']['colsize'] == '60' ? ' selected' : '' ?>>60%</option>
                          <option value="77"<?= @$category['Category']['colsize'] == '77' ? ' selected' : '' ?>>70%</option>
                          <option value="80"<?= @$category['Category']['colsize'] == '80' ? ' selected' : '' ?>>80%</option>
                          <option value="12"<?= @$category['Category']['colsize'] == '12' ? ' selected' : '' ?>>100%</option>
                        </select>              
                      </div>
                    </div>
                  </span>
                </span>
              </span>
            </div>
          <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>