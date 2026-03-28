<?php
	// echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
  echo $this->Html->script('relations.js?v=' . $version['ver'], array('inline' => false));
	echo $this->Html->script('schedules-edit.js?v=' . $version['ver'], array('inline' => false));
	echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
	echo $this->Html->css('bootstrap-datepicker');
  echo $this->Form->create(null, array(
  'class' => 'w-100',
  'id' => 'schedule_edit',
)); ?>
  <input type="hidden" name="x_coord" id="x_coord">
  <input type="hidden" name="y_coord" id="y_coord">
  <input type="hidden" name="redirect" value="/admin/newsletters/schedules"/>
  <input type="hidden" name="data[id]" value="<?= $schedule['NewsletterSchedule']['id'] ?? 0 ?>"/>
	<div class="row">
    <div class="col-xs-12">
      <h4 class="sub-header"><?=$schedule['Newsletter']['name'] ?? 'Crea un nuevo Schedule'?></h4>
      <p>Esta plantilla tiene asociados <span><?= count($schedule_products)?></span> productos</p>
<?php if(!empty($schedule['Newsletter']['id'])): ?>
    <input type="hidden" name="data[newsletter_id]" value="<?= $schedule['Newsletter']['id'] ?>"/>  
    <a href="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'edit', $schedule['Newsletter']['id']))?>">
      <div class="card">
        <div class="card-body">
          <h5 class="control-label" for="title"><?=$schedule['Newsletter']['title']?></h5>
          <div class="controls"><?=$schedule['Newsletter']['body']?></div>
        </div>
      </div>
    </a>
<?php else: ?>
      <div class="controls">
        <label class="control-label" for="title">Selecciona una plantilla</label>
        <select class="form-control" name="data[newsletter_id]">
  <?php foreach($newsletters as $newsletter): ?>
  <option value="<?= $newsletter['Newsletter']['id']?>"<?=@isset($this->params->query['newsletter_id']) && $newsletter['Newsletter']['id'] == $this->params->query['newsletter_id'] ? ' selected' : ''?>><?= $newsletter['Newsletter']['name']?> - <?= $newsletter['Newsletter']['title']?> (<?=$newsletter['User']['name'] ?? 'Desconocido'?>)</option>
  <?php endforeach ?>
        </select>
      </div>
<?php endif ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <h4 class="sub-header">Configuración</h4>
      <p>Configura el alcance para esta Campaña</p>
      <div class="form-group flex-between gap-05">
        <div class="controls flex-1">
          <label class="control-label" for="toggle">Activo</label>
          <input type="checkbox" name="data[enabled]" value="1" id="toggle" class="toggle-checkbox"<?=@$schedule['NewsletterSchedule']['enabled'] == '1' ? ' checked' : '' ?>>
          <label for="toggle" class="toggle-label"></label>
        </div>
<?php if(!empty($schedule_products)): ?>
        <a href="javascript:void(0)" onclick="$('.table-main:not(.table-products)').hide();$('.table-products').toggle()"><span class="badge badge-<?=count($schedule_products) ? 'success' : 'light' ?> is-rounded is-large"><?php echo count($schedule_products) ?></span></a>
<?php endif ?>
<?php if(!empty($schedule_users)): ?>
        <a href="javascript:void(0)" onclick="$('.table-main:not(.table-users)').hide();$('.table-users').toggle()">
          <span class="badge badge-<?=count($schedule_users) ? 'info' : 'light' ?> is-rounded is-large"><?php echo count($schedule_users) ?></span></a>
        </a>
<?php endif ?>      
      </div>
      <div class="table-main table-products bg-success d-none">
        <h4 class="sub-header"><a class="text-muted" href="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'edit', $schedule['Newsletter']['id']))?>"><i class="gi gi-cogwheel is-clickable"></i></a> Productos</h4>
        <table class="table table-forum">
  <?php foreach($schedule_products as $product): ?>
          <tr><td><?php echo $product['Product']['name']?> (<?php echo $product['Product']['article']?>)</td></tr>
  <?php endforeach ?>
        </table>
      </div>
      <div class="table-main table-users bg-info d-none">
        <h4 class="sub-header"><i class="gi gi-cogwheel is-clickable" onclick="$('#user-filter').focus()"></i> Cuentas</h4>
        <table class="table table-forum">
    <?php foreach($schedule_users as $user): ?>
          <tr><td><?php echo $user['User']['name']?> <?php echo $user['User']['surname']?> (<span class="text-lowercase"><?php echo $user['User']['email']?></span>)</td></tr>
  <?php endforeach ?>
       </table>
      </div>
      <h4 class="sub-header">Configuración</h4>
      <table class="table table-forum table-striped text-small">
        <tr>
          <td><small>Fecha / hora de envío</small></td>
          <th><span class="date-value"><?= $schedule['NewsletterSchedule']['schedule_date'] ?? date('d/m/Y')?></span> - <span class="hour-value"><?= $schedule['NewsletterSchedule']['schedule_hour'] ?? date('H')?>hs</span></th>
        </tr>
        <tr>
          <td><small>Periodo de evaluación</small></td>
          <th><span class="min_date-value"><?= $schedule['NewsletterSchedule']['filter']->date_min?></span> - <span class="max_date-value"><?= $schedule['NewsletterSchedule']['filter']->date_max?></span></th>
        </tr>
        <tr>
          <td><small>Mínimo de compra</small></td>
          <th><span class="min_sale-value"><?= $schedule['NewsletterSchedule']['filter']->sale_min?></span></th>
        </tr>
        <tr>
          <td><small>Productos seleccionados</small></td>
          <th>
            <span class="product-count">
              <?= count($schedule_products)?>
            </span> 
          </th>
        </tr>
        <tr>
          <td><small>Cuentas seleccionadas</small></td>
          <th>
            <span class="user-count"><?= count($schedule_users)?></span>
          </th>
        </tr>
      </table>
<?php if(!empty($schedule['NewsletterSchedule']['id'])):?>         
      <h4 class="sub-header">Filtros por compra</h4>
      <p>Establece fecha y monto para filtrar por cuenta de acuerdo al historial de compras</p>
      <div class="control-group">
        <label class="control-label" for="myRange2">Periodo de evaluación (Desde / Hasta)</label>
        <div class="controls d-flex flex-center gap-05">
          <input type="text" name="data[filter][date_min]" class="form-control advanced-filter datepicker" data-name="min_date" placeholder="Fecha mínima" value="<?=$schedule['NewsletterSchedule']['filter']->date_min ?? ''?>"/>
          <input type="text" name="data[filter][date_max]" class="form-control advanced-filter datepicker" data-name="max_date" placeholder="Fecha máxima" value="<?=$schedule['NewsletterSchedule']['filter']->date_max ?? ''?>"/>
        </div>
      </div>
      <!--label class="control-label" for="products-filter">Filtros en historial de compras</label-->
      <div class="controls-group">
        <label class="control-label" for="minSale">Mínimo de compra</label>
        <input type="range" class="advanced-filter" data-name="min_sale" name="data[filter][min_sale]" step="10" min="10" max="10000" value="<?=$schedule['NewsletterSchedule']['filter']->min_sale?>">
      </div>
      <h4 class="sub-header">Filtro por fecha de nacimiento</h4>
      <p>Establece fecha para filtrar por cuenta de acuerdo fecha de nacimiento</p>
      <div class="control-group">
        <label class="control-label" for="myRange2">Día de nacimiento (Desde / Hasta)</label>
        <div class="controls d-flex flex-center gap-05">
          <input type="text" id="minDob" name="data[filter][dob_min]" class="form-control datepicker" data-format="dd/mm" data-name="mindob-value" placeholder="Día de nacimiento mínimo" value="<?=$schedule['NewsletterSchedule']['filter']->dob_min ?? ''?>"/>
          <input type="text" id="maxDob" name="data[filter][dob_max]" class="form-control datepicker" data-format="dd/mm" data-name="maxdob-value" placeholder="Día de nacimiento max" value="<?=$schedule['NewsletterSchedule']['filter']->dob_max ?? ''?>"/>
        </div>
      </div>
<?php endif ?>
    </div>
    <div class="col-md-6">
      <h4 class="sub-header">Método de envío</h4>
      <p>Selecciona el canal por donde notificar a las cuentas</p>
      <div class="form-group flex-start gap-05">
        <div class="controls flex-1">
          <label class="control-label" for="toggle-email">Email</label>
          <input type="checkbox" name="data[send_email]" value="1" id="toggle-email" class="toggle-checkbox"<?=@$schedule['NewsletterSchedule']['send_email'] == '1' ? ' checked' : '' ?>>
          <label for="toggle-email" class="toggle-label"></label>
        </div>
        <div class="controls flex-1">
          <label class="control-label" for="toggle-push">Push</label>
          <input type="checkbox" name="data[send_push]" value="1" id="toggle-push" class="toggle-checkbox"<?=@$schedule['NewsletterSchedule']['send_push'] == '1' ? ' checked' : '' ?>>
          <label for="toggle-push" class="toggle-label"></label>
        </div>
      </div>
      <h4 class="sub-header">Programar fecha de envío</h4>
      <p>Establece la fecha y/o hora del envío para este Envío</p>
      <div class="control-group">
        <label class="control-label" for="title">Programar fecha/hora</label>
        <div class="controls d-flex flex-center gap-05">
          <input type="text" name="data[schedule_date]" class="form-control datepicker" placeholder="Fecha del envío" value="<?=$this->Time->format($schedule['NewsletterSchedule']['schedule_date'] ?? date('d-m-Y'), '%d/%m/%Y')?>"/>
          <select class="form-control" name="data[schedule_hour]">
          <?php for($i=0; $i < 24; $i++): ?>
            <option value="<?=$i?>"<?= $i == $schedule['NewsletterSchedule']['schedule_hour'] ? ' selected':''?>><?=$i?>hs</option>
          <?php endfor ?>
          </select>
        </div>
        <small>Es el título que verán las cuentas en su dispositivo</small>
      </div>
<?php if(!empty($schedule['NewsletterSchedule']['id'])):?>      
      <h4 class="sub-header">Cuentas seleccionadas (<?=count($schedule_users)?>)
        <a class="advanced-action-add text-success d-none" data-type="user" href="javascript:void(0)">Agregar <span class="relations-count"><?=count($schedule_users)?></span></a>
        <?php if(count($schedule_users)): ?>
        <a class="advanced-action-remove text-danger" data-type="user" href="javascript:void(0)">Eliminar todo</a>
      <?php endif ?>
      </h4>
      <p>Selecciona las cuentas que deseas asignar a este envío</p>
      <div class="controls">
        <input type="text" class="form-control relation-search" data-type="user" placeholder="Buscar cuenta..."/>
      </div>      
      <div class="controls tags-container user-container">
<?php foreach($schedule_users as $user): ?>
  <span 
    class="label relation-item is-clickable text-lowercase is-enabled" 
    data-parent-id="<?php echo $schedule['NewsletterSchedule']['id'] ?>" 
    data-id="<?=$user['User']['id']?>"
    data-type="user"
    data-source="schedule"
    data-model="NewsletterUser"><?php echo $user['User']['email']?>
  </span>
<?php endforeach ?>
      </div>
<?php endif ?>      
    </div>
  </div>
  <div class="form-actions">
    <a href="javascript:history.go(-1)" class="btn btn-info"><i class="fa fa-chevron-left mr-1"></i> Atrás</a>
    <button type="submit" class="btn btn-success track-coords" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
  </div>
<?php echo $this->Form->end(); ?>