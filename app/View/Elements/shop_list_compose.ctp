    <div class="wrapper-fluid">
      <div class="row m-0">
        <div class="col-xs-12 draggable-table">
          <div class="row category-item-container">
          <?php foreach($categories as $category): ?>
            <div class="category-item p-0 col-xs-12 col-md-<?= !empty($category['Category']['colsize']) ? $category['Category']['colsize'] : 'auto' ?> <?= $category['Category']['visible'] == '1' ? '' : 'bg-danger'?>" data-id="<?=@$category['Category']['id'] ?>" data-order="<?= $category['Category']['ordernum'] ?>">
              <span class="category-item-image posnum-<?=@$category['Category']['posnum'] ?>" style="background-image: url('<?php echo $settings['upload_url'].$category['Category']['img_url']?>')">
                <span class="category-image ci-<?= !empty($category['Category']['alignnum']) ? $category['Category']['alignnum'] : '0' ?> p-3 w-100">  
                  <span class="p-1 text-catalog text-uppercase">
                    <?php echo 
                      $this->App->cat_title(
                        strlen($category['Category']['alternate_toggle']) ?  
                          $category['Category']['alternate_name'] : 
                          $category['Category']['name']
                        ) ?>
                  </span>
                  <span class="category-toolbox">
                    <div class="toolbox-tr control-group d-flex justify-content-center align-items-center gap-05">
                      <select class="form-control update-alignnum" name="data[alignnum]" title="Posición del texto">
                        <option value="0"<?= empty($category['Category']['alignnum']) ? ' selected' : '' ?>>Centro</option>
                        <option value="1"<?= @$category['Category']['alignnum'] == '1' ? ' selected' : '' ?>>Izquierda</option>
                        <option value="2"<?= @$category['Category']['alignnum'] == '2' ? ' selected' : '' ?>>Derecha</option>
                        <option value="3"<?= @$category['Category']['alignnum'] == '3' ? ' selected' : '' ?>>Arriba</option>
                        <option value="4"<?= @$category['Category']['alignnum'] == '4' ? ' selected' : '' ?>>Abajo</option>
                        <option value="5"<?= @$category['Category']['alignnum'] == '5' ? ' selected' : '' ?>>Arriba/Izquierda</option>
                        <option value="6"<?= @$category['Category']['alignnum'] == '6' ? ' selected' : '' ?>>Arriba/Derecha</option>
                        <option value="7"<?= @$category['Category']['alignnum'] == '7' ? ' selected' : '' ?>>Abajo/Izquierda</option>
                        <option value="8"<?= @$category['Category']['alignnum'] == '8' ? ' selected' : '' ?>>Abajo/Derecha</option>
                      </select>
                      <select class="form-control update-colsize" name="data[colsize]" style="width: 70px" title="Ancho de columna">
                        <option value="6"<?= empty($category['Category']['colsize']) ? ' selected' : '' ?>>Auto</option>
                        <!--option value="2"<?= @$category['Category']['colsize'] == '2' ? ' selected' : '' ?>>16.66%</option-->
                        <option value="20"<?= @$category['Category']['colsize'] == '20' ? ' selected' : '' ?>>20%</option>
                        <option value="3"<?= @$category['Category']['colsize'] == '3' ? ' selected' : '' ?>>25%</option>
                        <option value="4"<?= @$category['Category']['colsize'] == '4' ? ' selected' : '' ?>>33%</option>
                        <option value="40"<?= @$category['Category']['colsize'] == '40' ? ' selected' : '' ?>>40%</option>
                        <option value="6"<?= @$category['Category']['colsize'] == '6' ? ' selected' : '' ?>>50%</option>
                        <option value="60"<?= @$category['Category']['colsize'] == '60' ? ' selected' : '' ?>>60%</option>
                        <option value="8"<?= @$category['Category']['colsize'] == '8' ? ' selected' : '' ?>>66%</option>
                        <option value="9"<?= @$category['Category']['colsize'] == '9' ? ' selected' : '' ?>>75%</option>
                        <option value="80"<?= @$category['Category']['colsize'] == '80' ? ' selected' : '' ?>>80%</option>
                        <option value="12"<?= @$category['Category']['colsize'] == '12' ? ' selected' : '' ?>>100%</option>
                      </select>              
                    </div>
                    <div class="toolbox-bl control-group d-flex justify-content-center align-items-center gap-05">
                      <select class="form-control update-posnum" name="data[posnum]" title="Posición de imagen">
                        <option value="0"<?= empty($category['Category']['posnum']) ? ' selected' : '' ?>>Centro</option>
                        <option value="1"<?= @$category['Category']['posnum'] == '1' ? ' selected' : '' ?>>Izquierda</option>
                        <option value="2"<?= @$category['Category']['posnum'] == '2' ? ' selected' : '' ?>>Derecha</option>
                        <option value="3"<?= @$category['Category']['posnum'] == '3' ? ' selected' : '' ?>>Arriba</option>
                        <option value="4"<?= @$category['Category']['posnum'] == '4' ? ' selected' : '' ?>>Abajo</option>
                        <option value="5"<?= @$category['Category']['posnum'] == '5' ? ' selected' : '' ?>>Arriba/Izquierda</option>
                        <option value="6"<?= @$category['Category']['posnum'] == '6' ? ' selected' : '' ?>>Arriba/Derecha</option>
                        <option value="7"<?= @$category['Category']['posnum'] == '7' ? ' selected' : '' ?>>Abajo/Izquierda</option>
                        <option value="8"<?= @$category['Category']['posnum'] == '8' ? ' selected' : '' ?>>Abajo/Derecha</option>
                      </select>
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