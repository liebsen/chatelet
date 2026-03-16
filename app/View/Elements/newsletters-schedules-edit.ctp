<?php
	// echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
	echo $this->Html->script('newsletters-schedules.js?v=' . $version['ver'], array('inline' => false));
	echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
	echo $this->Html->css('bootstrap-datepicker');
?>

<?php echo $this->Form->create(null, array(
  'url' => array(
      'controller' => 'admin',
      'action' => 'newsletters'
  ),
  'class' => 'w-100',
  'id' => 'newsletter_schedule_edit',
)); ?>
  <input type="hidden" name="redirect" value="/admin/newsletters/schedules"/>
  <input type="hidden" name="id" value="<?= $schedule['Newsletter']['id'] ?? 0 ?>"/>
	<div class="row">
    <div class="col-xs-12">
      <h4 class="sub-header"><?=$schedule['Newsletter']['name'] ?? 'Crea un nuevo Schedule'?></h4>
      <p>Este envío fue utilizado <span>3</span> veces</p>
      <div class="card">
        <div class="card-body">
          <h5 class="control-label" for="title"><?=$schedule['Newsletter']['title']?></h5>
          <div class="controls"><?=$schedule['Newsletter']['body']?></div>
        </div>
      </div>
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
          <?php for($i=0; $i < 25; $i++): ?>
          	<option value="<?=$i?>"><?=$i?>hs</option>
          <?php endfor ?>
        	</select>
        </div>
        <small>Es el título que verán las clientas en su dispositivo</small>
      </div>

      <div class="control-group w-100">
        <h4 class="sub-header">Filtros en historial de compras</h4>
        <!--label class="control-label" for="products-filter">Filtros en historial de compras</label-->
        <div class="controls">
          <label class="control-label" for="minSale">Mínimo de compra</label>
          <input type="range" id="minSale" step="10" min="10" max="4000" value="10">
        </div>

        <div class="controls">
          <label class="control-label" for="myRange2">Periodo de evaluación (Desde / Hasta)</label>
          <div class="controls d-flex flex-center gap-05">
            <input type="text" id="minDate" name="filter[date_min]" class="form-control datepicker" data-name="mindate-value" placeholder="Fecha del envío" value="<?=$this->Time->format($schedule['NewsletterSchedule']['filter']->date_min ?? date('d/m/Y'), '%d/%m/%Y')?>"/>
            <input type="text" id="maxDate" name="filter[date_max]" class="form-control datepicker" data-name="maxdate-value" placeholder="Fecha del envío" value="<?=$this->Time->format($schedule['NewsletterSchedule']['filter']->date_max ?? date('d/m/Y'), '%d/%m/%Y')?>"/>
          </div>
        </div>


        <h4 class="sub-header">Filtros de cuenta</h4>
        <div class="controls">
          <label class="control-label" for="myRange2">Día de nacimiento (Desde / Hasta)</label>
          <div class="controls d-flex flex-center gap-05">
            <input type="text" id="minDob" name="filter[dob_min]" class="form-control datepicker" data-format="dd/mm" data-name="mindob-value" placeholder="Día de nacimiento mínimo" value="<?=$this->Time->format($schedule['NewsletterSchedule']['filter']->dob_min ?? date('d/m'), '%d/%m')?>"/>
            <input type="text" id="maxDob" name="filter[dob_max]" class="form-control datepicker" data-format="dd/mm" data-name="maxdob-value" placeholder="Día de nacimiento max" value="<?=$this->Time->format($schedule['NewsletterSchedule']['filter']->dob_max ?? date('d/m'), '%d/%m')?>"/>
          </div>
        </div>


        <div class="controls">
          <input type="text" id="products-filter" class="form-control" placeholder="Buscar"/>
        </div>

      </div>  

    </div>
    <div class="col-md-6">
    	<h4 class="sub-header">Configuración de envío</h4>
    	<p>Configura el alcance para este Envío</p>
      <table class="table table-striped text-small">
        <tr>
          <th>Fecha / hora de envío</th>
          <td><span class="date-value"><?= $schedule['NewsletterSchedule']['schedule_date']?></span> - <span class="hour-value"><?= $schedule['NewsletterSchedule']['schedule_hour']?>hs</span></td>
        </tr>
        <tr>
          <th>Periodo de evaluación</th>
          <td><span class="mindate-value"><?= $schedule['NewsletterSchedule']['filter']->date_min?></span> - <span class="maxdate-value"><?= $schedule['NewsletterSchedule']['filter']->date_max?></span></td>
        </tr>
        <tr>
          <th>Mínimo de compra</th>
          <td><span class="minsale-value"><?= $schedule['NewsletterSchedule']['filter']->sale_min?></span></td>
        </tr>
        <tr>
          <th>Clientes seleccionados</th>
          <td><span class="minsale-value"><?= count($schedule_users)?></span></td>
        </tr>
      </table>

        <div style="padding: 0.25rem;">
<?php foreach($schedule_users as $user): ?>
    <span 
      class="label product-item is-clickable is-enabled" 
      onclick="toggleOption(this, 'user')" 
      data-coupon="<?php echo $coupon['Coupon']['id'] ?>" 
      data-json='<?php echo json_encode($user['User']) ?>'><?php echo $user['User']['name']?>
    </span>
<?php endforeach ?>
        </div>

    </div>
  </div>
  <div class="form-actions">
    <a href="/admin/newsletters/schedules" class="btn btn-info"><i class="fa fa-chevron-left mr-1"></i> Atrás</a>
    <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
  </div>

<?php echo $this->Form->end(); ?>