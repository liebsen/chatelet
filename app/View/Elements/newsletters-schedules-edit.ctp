<?php
	// echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
	echo $this->Html->script('newsletters-schedules-edit.js?v=' . $version['ver'], array('inline' => false));
	echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
	echo $this->Html->css('bootstrap-datepicker');  

?>

<?php echo $this->Form->create(null, array(
  'url' => array(
      'controller' => 'admin',
      'action' => 'newsletters'
  ),
  'class' => 'w-100',
  'id' => 'newsletter_schedules_edit',
)); ?>
  <input type="hidden" name="redirect" value="/admin/newsletters/schedules"/>
  <input type="hidden" name="id" value="<?= $schedule['NewsletterSchedule']['id'] ?? 0 ?>"/>
  <input type="hidden" name="newsletter_id" value="<?= $schedule['Newsletter']['id'] ?? 0 ?>"/>
	<div class="row">
    <div class="col-xs-12">
      <h4 class="sub-header"><?=$schedule['Newsletter']['name'] ?? 'Crea un nuevo Schedule'?></h4>
      <p>Esta plantilla tiene asociados <span><?= count($schedule_products)?></span> productos</p>

<?php if(isset($schedule['Newsletter']['id'])): ?>
      <div class="card">
        <div class="card-body">
          <h5 class="control-label" for="title"><?=$schedule['Newsletter']['title']?></h5>
          <div class="controls"><?=$schedule['Newsletter']['body']?></div>
        </div>
      </div>
<?php else: ?>
      <div class="controls">
        <label class="control-label" for="title">Selecciona una plantilla</label>
        <select class="form-control" name="newsletter_id">
<?php foreach($newsletters as $newsletter): ?>
  <option value="<?= $newsletter['Newsletter']['id']?>"><?= $newsletter['Newsletter']['name']?> - <?= $newsletter['Newsletter']['title']?></option>
<?php endforeach ?>
        </select>
      </div>
<?php endif ?>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
    	<h4 class="sub-header">Programar fecha de envío</h4>
    	<p>Establece la fecha y/o hora del envío para este Envío</p>
      <div class="control-group">
        <label class="control-label" for="title">Programar fecha/hora</label>
        <div class="controls d-flex flex-center gap-05">
          <input type="text" name="data[schedule_date]" class="form-control datepicker" placeholder="Fecha del envío" value="<?=$this->Time->format($schedule['NewsletterSchedule']['schedule_date'] ?? date('d/m/Y'), '%d/%m/%Y')?>"/>
          <select class="form-control" name="data[schedule_hour]">
          <?php for($i=0; $i < 24; $i++): ?>
          	<option value="<?=$i?>"><?=$i?>hs</option>
          <?php endfor ?>
        	</select>
        </div>
        <small>Es el título que verán las clientas en su dispositivo</small>
      </div>
      <h4 class="sub-header">Cuentas selecionadas</h4>
      <p>Selecciona las cuentas que deseas asignar a este envío</p>
      <div class="controls">
        <input type="text" id="user-filter" class="form-control" placeholder="Buscar clienta..."/>
      </div>      
      <div class="controls tags-container user-container">
<?php foreach($schedule_users as $user): ?>
  <span 
    class="label user-item is-clickable text-lowercase is-enabled" 
    data-rel_id="<?php echo $schedule['Newsletter']['id'] ?>" 
    data-id="<?=$user['User']['id']?>"
    data-type="user"
    data-source="newsletter"
    data-model="NewsletterUser"><?php echo $user['User']['email']?>
  </span>
<?php endforeach ?>
      </div>  


    </div>
    <div class="col-md-6">
    	<h4 class="sub-header">Configuración de envío</h4>
    	<p>Configura el alcance para este Envío</p>
      <table class="table table-striped text-small">
        <tr>
          <th><small>Fecha / hora de envío</small></th>
          <td><span class="date-value"><?= $schedule['NewsletterSchedule']['schedule_date']?></span> - <span class="hour-value"><?= $schedule['NewsletterSchedule']['schedule_hour']?>hs</span></td>
        </tr>
        <tr>
          <th><small>Periodo de evaluación</small></th>
          <td><span class="mindate-value"><?= $schedule['NewsletterSchedule']['filter']->date_min?></span> - <span class="maxdate-value"><?= $schedule['NewsletterSchedule']['filter']->date_max?></span></td>
        </tr>
        <tr>
          <th><small>Mínimo de compra</small></th>
          <td><span class="minsale-value"><?= $schedule['NewsletterSchedule']['filter']->sale_min?></span></td>
        </tr>
        <tr>
          <th><small>Productos seleccionados</small></th>
          <td>
            <span class="userscount-value">
              <?= count($schedule_products)?>
            </span> 
            <div class="prod-assist<?= count($schedule_products) ? '' : ' d-none'?>">
              <a href="javascript:void(0)" onclick="$('.prod-list').toggle()">Mostrar</a>
              <ul class="prod-list d-none">
  <?php foreach($schedule_products as $product): ?>
          <li><?php echo $product['Product']['name']?> (<?php echo $product['Product']['article']?>)</li>
  <?php endforeach ?>
              </ul>
            </div>
          </td>
        </tr>
        <tr>
          <th><small>Cuentas seleccionadas</small></th>
          <td>
            <span class="userscount-value"><?= count($schedule_users)?></span>
            <a class="userscount-message d-none" href="javascript:void(0)" onclick="relateAll()">Agregar <span class="usercount-new">0</span></a>
          </td>
        </tr>
      </table>
      <h4 class="sub-header">Filtros por compra</h4>
      <p>Establece fecha y monto para filtrar por cuenta de acuerdo al historial de compras</p>
      <div class="control-group">
        <label class="control-label" for="myRange2">Periodo de evaluación (Desde / Hasta)</label>
        <div class="controls d-flex flex-center gap-05">
          <input type="text" id="minDate" name="filter[date_min]" class="form-control datepicker" data-name="mindate-value" placeholder="Fecha del envío" value="<?=$this->Time->format($schedule['NewsletterSchedule']['filter']->date_min ?? date('d/m/Y'), '%d/%m/%Y')?>"/>
          <input type="text" id="maxDate" name="filter[date_max]" class="form-control datepicker" data-name="maxdate-value" placeholder="Fecha del envío" value="<?=$this->Time->format($schedule['NewsletterSchedule']['filter']->date_max ?? date('d/m/Y'), '%d/%m/%Y')?>"/>
        </div>
      </div>
      <!--label class="control-label" for="products-filter">Filtros en historial de compras</label-->
      <div class="controls-group">
        <label class="control-label" for="minSale">Mínimo de compra</label>
        <input type="range" id="minSale" step="10" min="10" max="4000" value="10">
      </div>

      <h4 class="sub-header">Filtro por fecha de nacimiento</h4>
      <p>Establece fecha para filtrar por cuenta de acuerdo fecha de nacimiento</p>
      <div class="control-group">
        <label class="control-label" for="myRange2">Día de nacimiento (Desde / Hasta)</label>
        <div class="controls d-flex flex-center gap-05">
          <input type="text" id="minDob" name="filter[dob_min]" class="form-control datepicker" data-format="dd/mm" data-name="mindob-value" placeholder="Día de nacimiento mínimo" value="<?=$this->Time->format($schedule['NewsletterSchedule']['filter']->dob_min ?? date('d/m'), '%d/%m')?>"/>
          <input type="text" id="maxDob" name="filter[dob_max]" class="form-control datepicker" data-format="dd/mm" data-name="maxdob-value" placeholder="Día de nacimiento max" value="<?=$this->Time->format($schedule['NewsletterSchedule']['filter']->dob_max ?? date('d/m'), '%d/%m')?>"/>
        </div>
      </div>
    </div>
  </div>
  <div class="form-actions">
    <a href="/admin/newsletters/schedules" class="btn btn-info"><i class="fa fa-chevron-left mr-1"></i> Atrás</a>
    <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
  </div>

<?php echo $this->Form->end(); ?>