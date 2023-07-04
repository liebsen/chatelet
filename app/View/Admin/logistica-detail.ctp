<?php
  echo $this->Html->script('logistica-detail', array('inline' => false));
  echo $this->Html->css('logistica-detail', array('inline' => false));
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
              <div class="controls text-center switch-scale switch-custom">
                <?php
                  $enabled = (isset($logistic) && $logistic['Logistic']['enabled'] == 1 || !isset($logistic)) ? 'checked' : '';
                  $disabled = (isset($logistic) && $logistic['Logistic']['enabled'] == 0) ? 'checked' : '';
                ?>
                <label for="enabled_1">Sí</label>
                <input type="radio" class="form-control" id="enabled_1" name="data[enabled]" value="1" <?php echo $enabled; ?> /> &nbsp;
                <label for="enabled_0">No</label>
                <input type="radio" class="form-control" id="enabled_0" name="data[enabled]" value="0" <?php echo $disabled; ?> />
              </div>
              <small class="text-muted">Indica el estado de esta logística. En caso de inactivo el cliente no podrá utilizar esta opción.</small>
            </div>
            <br>
            <div class="control-group">
              <label class="control-label" for="code"><?php echo __('Código'); ?></label>
              <div class="controls">
                <input type="text" class="form-control" id="code" name="data[code]" value="<?php echo (isset($logistic)) ? $logistic['Logistic']['code'] : ''; ?>" <?= isset($logistic) ? 'disabled' : 'readonly' ?>>
              </div>
              <small class="text-danger">Indica el código de logística. Si no estás seguro consultá con el programador. Este valor solo puede editarse una vez.</small>
            </div>
            <br />       
            <div class="control-group">
              <label class="control-label" for="title"><?php echo __('Nombre'); ?></label>
              <div class="controls">
                <input type="text" class="form-control" id="title" name="data[title]" value="<?= (isset($logistic)) ? $logistic['Logistic']['title'] : '' ?>" required>
              </div>
              <small class="text-muted">Indica el título de esta logística. Es probable que aparezca en algún correo que enviemos al cliente para informarle del código de seguimiento o eventualmente otro estado envío.</small>
            </div>
            <br /> 
          <?php if(isset($logistic) && !$logistic['Logistic']['local_prices']) :?>
            <div class="control-group">
              <label class="control-label" for="tracking_url"><?php echo __('URL Tracking'); ?></label>
              <div class="controls">
                <input type="text" max-length="255" size="60" class="form-control" id="tracking_url" name="data[tracking_url]" value="<?php echo (isset($logistic)) ? $logistic['Logistic']['tracking_url'] : ''; ?>" required>
              </div>
              <small class="text-muted">Indica la url del enlace que recibirá el cliente por correo electrónico para chequear el estado de su envío. Generalmente está enlazado a algún sitio de <?= $logistic['Logistic']['title'] ?></small>
            </div>            
          <?php endif ?>
          <?php if(!empty($config)): ?>
            <h4 class="sub-header">Configuración</h4>
            <?php foreach($config as $item):?>
            <div class="control-group">
              <label class="control-label" for="<?= $item['Setting']['id'] ?>"><?php echo __(strtok($item['Setting']['extra'], ':')); ?></label>
              <div class="controls">
                <input type="text" max-length="255" size="60" class="form-control" id="<?= $item['Setting']['id'] ?>" name="config[<?= $item['Setting']['id'] ?>]" value="<?= @$item['Setting']['value'] ?>" required>
              </div>
              <small class="text-muted"><?= substr($item['Setting']['extra'], strpos($item['Setting']['extra'], ":") + 1) ?></small>
            </div>
          <?php endforeach ?>
          <?php endif ?>

          </div>
          <div class="col-md-6">
            <h4 class="sub-header"><?php echo __('Prioridad de oferta'); ?></h4>
            <div class="alert alert-primary">
              <div class="control-group">
                <label class="control-label" for="columns-text"><?php echo __('Envíos gratuitos'); ?></label>
                <div class="controls text-center switch-scale">
                  <?php
                    $enabled = (isset($logistic) && $logistic['Logistic']['free_shipping'] == 1 || !isset($logistic)) ? 'checked' : '';
                    $disabled = (isset($logistic) && $logistic['Logistic']['free_shipping'] == 0) ? 'checked' : '';
                  ?>
                  <label for="free_shipping_1">Disponible</label>
                  <input type="radio" class="form-control" id="free_shipping_1" name="data[free_shipping]" value="1" <?php echo $enabled; ?> /> &nbsp;
                  <label for="free_shipping_0">No Disponible</label>
                  <input type="radio" class="form-control" id="free_shipping_0" name="data[free_shipping]" value="0" <?php echo $disabled; ?> />
                </div>
                <small class="text-muted">Indica si esta logística estará disponible para los envíos gratuitos. Si está activo significa que esta logística tendrá prioridad para los envíos gratuitos. <span class="alert-link">Establezca <i>Disponible</i> para que las clientas puedan seleccionar <i><?= @$logistic['Logistic']['title'] ?></i> para sus envíos gratuitos.</span></small>
                <?php if($enabled && @$logistic['Logistic']['local_prices']): ?>
                  <br>
                  <br>
                  <small class="text-danger alert-link"><b>Exclusividad no garantizada.</b> <i> <?= $logistic['Logistic']['title'] ?></i> tiene alcance local, esto significa que solo estará disponible para envíos gratuitos dentro de su área de cobertura, caso contrario se mostrarán otras opciones de envío que pueden no estar establecidas como disponibles para envío gratuito.</small>
                <?php endif ?>
              </div>
            </div>            
            <h4 class="sub-header">Mas datos</h4>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Alcance'); ?></label>
              <div class="controls text-center switch-scale switch-custom">
                <?php
                  $enabled = (isset($logistic) && $logistic['Logistic']['local_prices'] == 1 || !isset($logistic)) ? 'checked' : '';
                  $disabled = (isset($logistic) && $logistic['Logistic']['local_prices'] == 0) ? 'checked' : '';
                ?>
                <label for="enabled_1">Local</label>
                <input type="radio" class="form-control" id="enabled_1" name="data[local_prices]" value="1" <?php echo $enabled; ?> /> &nbsp;
                <label for="enabled_0">Nacional</label>
                <input type="radio" class="form-control" id="enabled_0" name="data[local_prices]" value="0" <?php echo $disabled; ?> />
              </div>
              <small class="text-muted">Indica si la logística utiliza una configuración de tarifas (Local) o no (Nacional). Las logísticas nacionales estan integradas a la tienda mediante sus correspondientes apis. Seleccione <strong>Alcance Local</strong> para agregar tarifas.</small>
            </div>
            <br>
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
            <br>
          </div>
        </div>
      </div>
      <br />
      <div class="form-actions">
        <a href="/admin/logistica" class="btn btn-info"><i class="icon-repeat"></i> Atrás</a>
        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Guardar</button>
      </div>
    </form>
  </div>
</div>

<?php if(isset($logistic_prices) && $logistic['Logistic']['local_prices']) :?>

<div class="block block-themed">
  <div class="block-title">
    <h4>
    <?php
      echo (isset($logistic)) ? __('Tarifas de ' . $logistic['Logistic']['title']) : __('Agregar Tarifas');
    ?>
    </h4>
  </div>

  <div class="block-content">
    <p class="p">Usted puede editar las tarifas de esta logística de acuerdo a las zonas que están representadas por códigos postales. Los códigos postales en Argentina contienen cuatro números. Puede asignarlos de forma taxativa (ej: 1440, 1441) o agrupar con expresiones (ej: 92**, 930*). Mas información sobre <a href="https://códigos-postales.cybo.com/argentina/#mapwrap" target="_blank">códigos postales de argentina</a></p>
    <button class="btn btn-success" type="button" onclick="edit_logistic_price()">Agregar</button>
    <table class="table table-striped" id="tarifas">
      <thead>
        <tr>
          <th><?php echo __('Zona'); ?></th>
          <th><?php echo __('Códigos postales'); ?></th>
          <th><?php echo __('Tarifa'); ?></th>
          <th><?php echo __('Observaciones'); ?></th>
          <th></th>
        </tr>
      </thead>
      <tbody id="table_prices">
      <?php foreach($logistic_prices as $price) :?>
        <tr id="prices_<?= $price['LogisticsPrices']['id'] ?>" class="<?= !$price['LogisticsPrices']['enabled'] ? 'bg-light' : '' ?>">
          <td>
            <p class="title">
              <?php echo $price['LogisticsPrices']['title'] ?>
            </p>
          </td>
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
              <button class="btn btn-danger" type="button" data-loading-text="<i class='gi gi-clock'></i>" onclick="remove_logistic_price(<?php echo $price['LogisticsPrices']['id'] ?>, this)">
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
        <div class="control-group">
          <label class="control-label" for="columns-text"><?php echo __('Estado'); ?></label>
          <div class="controls">
            <label for="enabled_1">Sí</label>
            <input type="radio" id="enabled_1" name="enabled" value="1" /> &nbsp;
            <label for="enabled_0">No</label>
            <input type="radio" id="enabled_0" name="enabled" value="0" />
          </div>
        </div>
        <div class="form-group">
          <label class="control-label" for="info"><?php echo __('Zona'); ?></label>
          <div class="controls">
            <input type="text" class="form-control" id="title" max-length="100" name="title" value="" placeholder="Zona Norte GBA" required>
          </div>
          <small class="text-muted">Nombre para denominar esta zona de logística.</small>
        </div>        
        <div class="form-group">
          <label class="control-label" for="info"><?php echo __('Códigos postales'); ?></label>
          <div class="controls">
            <textarea id="zips" class="form-control" name="zips" rows="5" placeholder="Indique códigos postales válidos" required></textarea>
          </div>
          <small class="text-muted">Indica los códigos postales <strong>separados por coma o espacio</strong> que abarca la zona de cobertura de esta logística.</small>
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
          <button class="btn btn-success btn-save-logistic-prices" data-loading-text="<i class='gi gi-clock'></i>" type="submit">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php else: ?>
<?php if (isset($logistic) && $logistic['Logistic']): ?>
<div class="content">
  <div class="has-card-background card-alcance-nacional">
    <h3>Alcance Nacional</h3><p><strong><?= $logistic['Logistic']['title'] ?></strong> tiene alcance nacional y no puede aceptar tarifas ya que está integrada a la tienda mediante api.</p>
  </div>
</div>
<?php endif ?>
<?php endif ?>