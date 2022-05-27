<?php
  echo $this->Html->script('logistic-detail', array('inline' => false));
  echo $this->Html->css('logistic-detail', array('inline' => false));
?>
<?php echo $this->element('admin-menu');?>
<div class="block block-themed">
  <div class="block-title">
    <h4>
    <?php
      echo (isset($logistic)) ? __('Editar Logística') : __('Agregar Logística');
    ?>
    </h4>
  </div>

  <div class="block-content">
    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
      <?php
        if (isset($this->request->pass[1])) {
          echo '<input type="hidden" name="data[id]" value="'. htmlspecialchars($this->request->pass[1]) .'" />';
        }
      ?>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <h4 class="sub-header">Información Principal</h4>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Estado'); ?></label>
              <div class="controls">
                <?php
                  $enabled = (isset($logistic) && $logistic['Logistic']['enabled'] == 1) ? 'checked' : '';
                  $disabled = (isset($logistic) && $logistic['Logistic']['enabled'] == 0) ? 'checked' : '';
                ?>
                <label for="enabled_1">Activo</label>
                <input type="radio" class="form-control" id="enabled_1" name="data[enabled]" value="1" <?php echo $enabled; ?> /> &nbsp;
                <label for="enabled_0">Inactivo</label>
                <input type="radio" class="form-control" id="enabled_0" name="data[enabled]" value="0" <?php echo $disabled; ?> />
              </div>
              <small class="text-muted">Indica el estado de esta logística. En caso de inactivo el cliente no podrá utilizar esta opción.</small>
            </div>
            <div class="control-group">
              <label class="control-label" for="code"><?php echo __('Código'); ?></label>
              <div class="controls">
                <input type="text" class="form-control" id="code" name="data[code]" value="<?php echo (isset($logistic)) ? $logistic['Logistic']['code'] : ''; ?>" <?= isset($logistic) ? 'disabled' : 'required' ?>>
              </div>
              <small class="text-danger">Indica el código de logística. Si no estás seguro consultá con el programador. Este valor solo puede editarse una vez.</small>
            </div>
            <br />       

            <div class="control-group">
              <label class="control-label" for="title"><?php echo __('Nombre'); ?></label>
              <div class="controls">
                <input type="text" class="form-control" id="title" name="data[title]" value="<?php echo (isset($logistic)) ? $logistic['Logistic']['title'] : ''; ?>" required>
              </div>
              <small class="text-muted">Indica el título de esta logística. Es probable que aparezca en algún correo que enviemos al cliente para informarle del código de seguimiento o eventualmente otro estado envío.</small>
            </div>
          </div>
          <div class="col-md-6">
            <h4 class="sub-header">Mas datos</h4>
            <div class="control-group">
              <label class="control-label" for="info"><?php echo __('Info'); ?></label>
              <div class="controls">
                <textarea id="info"  class="form-control" name="data[info]" rows="5"><?php echo (isset($logistic)) ? $logistic['Logistic']['info'] : ''; ?></textarea>
              </div>
              <small class="text-muted">Agrega mas información sobre esta logística que merezca ser informada al cliente.</small>
            </div>
            <br />
            <div class="control-group">
              <label class="control-label" for=""><?=__('Seleccione una imagen de Logística')?></label>
            <?php if(isset($logistic) && $logistic['Logistic']['image']) :?>
              <br>
              <div class="img-thumbnail">
                <img src="<?= $logistic['Logistic']['image'] ?>" height=60 />
              </div>
              <br>
            <?php endif ?>
              <div class="controls">
                <input type="file" class="attached" name="image">
              </div>
            </div>
            <br />
          </div>             
        </div>  
      </div>    
      <br />
      <div class="form-actions">
        <a href="/admin/logistica" class="btn btn-info"><i class="icon-repeat"></i> Atrás</a>
        <button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> Resetear</button>
        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Guardar</button>
      </div>
    </form>
  <?php if(isset($logistic_prices) &&  $logistic['Logistic']['local_prices']) :?>
    <hr>
    <h4 class="sub-header">Tarifas</h4>
    <button class="btn btn-success" type="button" onclick="edit_logistic_price()">Agregar</button>
    <table class="table table-striped">
      <thead>
        <tr>
          <th><?php echo __('Códigos postales'); ?></th>
          <th><?php echo __('Tarifa'); ?></th>
          <th><?php echo __('Observaciones'); ?></th>
          <th></th>
        </tr>
      </thead>
      <tbody id="table_prices">
      <?php foreach($logistic_prices as $price) :?>
        <tr id="prices_<?= $price['LogisticsPrices']['id'] ?>">
          <td>
            <p class="zips">
              <?php echo $price['LogisticsPrices']['zips'] ?>
            </p>
          </td>
          <td>
            <p class="price">
              <?php echo $price['LogisticsPrices']['price'] ?>
            </p>
          </td>
          <td>
            <p class="info">
              <?php echo $price['LogisticsPrices']['info'] ?>
            </p>
          </td>
          <td>
            <div class="controls">
              <button class="btn btn-success" type="button" onclick="edit_logistic_price(<?php echo $price['LogisticsPrices']['id'] ?>)">
                <i class="gi gi-pencil"></i>
              </button>
              <button class="btn btn-danger" type="button" onclick="remove_logistic_price(<?php echo $price['LogisticsPrices']['id'] ?>)">
                <i class="gi gi-remove"></i>
              </button>
            </div>
          </td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <div class="logistic-price-form hide">
      <h4 class="sub-header">Editar tarifa de logística</h4>
      <form id="add_logistic_price" onsubmit="return save_logistic_price()">
        <input type="hidden" name="id" id="id" value="">
        <input type="hidden" name="logistic_id" value="<?= $logistic['Logistic']['id'] ?>">
        <div class="form-group">
          <label class="control-label" for="info"><?php echo __('Códigos postales'); ?></label>
          <div class="controls">
            <textarea id="zips" class="form-control" name="zips" rows="5" placeholder="Indique códigos postales válidos" required></textarea>
          </div>
          <small class="text-muted">Indica los códigos postales <strong>separados por un espacio</strong> que abarca la zona de cobertura de esta logística.</small>
        </div>
        <div class="form-group">
          <label class="control-label" for="info"><?php echo __('Tarifa'); ?></label>
          <div class="controls">
            <input type="number" class="form-control" id="price" step="1" name="price" value="" placeholder="500" required>
          </div>
          <small class="text-muted">En caso de logística de alcance local indica la tarifa por envío expresada en peso argentino ARS.</small>
        </div>
        <div class="form-group">
          <label class="control-label" for="info"><?php echo __('Información adicional'); ?></label>
          <div class="controls">
            <textarea id="info" class="form-control" name="info" rows="5" placeholder="Indique información adicional"></textarea>
          </div>
          <small class="text-muted">Indique información adicional, tiempos de entrega, condiciones especiales, etc.</small>            
        </div>
        <div class="form-group">
          <button class="btn btn-info" type="button" onclick="$('.logistic-price-form').addClass('hide')">Cancelar</button>
          <button class="btn btn-success" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" type="submit">Guardar</button>
        </div>
      </form>
    </div>
    <?php endif ?>
  </div>
</div>