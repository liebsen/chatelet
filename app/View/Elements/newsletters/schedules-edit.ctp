<?php
	// echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
  echo $this->Html->script('relations.js?v=' . $version['ver'], array('inline' => false));
	echo $this->Html->script('schedules-edit.js?v=' . $version['ver'], array('inline' => false));
  echo $this->Html->script('application-form.js?v=' . $version['ver'], array('inline' => false));
	echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
	echo $this->Html->css('bootstrap-datepicker');
  echo $this->Form->create(null, array(
  'class' => 'w-100',
  'id' => 'form_app',
)); ?>
  <input type="hidden" name="x_coord" id="x_coord">
  <input type="hidden" name="y_coord" id="y_coord">
  <input type="hidden" name="reset" id="reset">
  <input type="hidden" name="reset_all" id="reset_all">
  <input type="hidden" name="redirect" value="/admin/newsletters/schedules"/>
  <input type="hidden" name="data[id]" value="<?= $schedule['NewsletterSchedule']['id'] ?? 0 ?>"/>
  <div class="row">
    <div class="col-md-6">
      <h4 class="sub-header"><span class="">Activar campaña</span></h4>
      <p>Indica si se debe agregar a la tarea programada y ejecturase</p>
      <div class="form-group flex-end flex-between gap-05">
        <div class="controls flex-1">
          <label class="control-label" for="toggle">Activo</label>
          <input type="checkbox" name="data[enabled]" value="1" id="toggle" class="toggle-checkbox"<?=@$schedule['NewsletterSchedule']['enabled'] == '1' ? ' checked' : '' ?>>
          <label for="toggle" class="toggle-label"></label>
        </div>
      </div>
      <div class="form-box bg-success-outline">
        <h4 class="sub-header"><span class="pl-1">Implementar componentes</span></h4>
        <p>Elige al menos una plantilla y una lista para esta Campaña</p>
        <div class="d-flex flex-column justify-content-center align-items-center gap-1 mb-4">
          <div class="controls">
            <label class="control-label" for="title"><i class="gi gi-picture mr-1"></i> Plantilla</label>
            <select class="form-control" name="data[newsletter_id]" required>
      <?php foreach($newsletters as $newsletter): ?>
      <option value="<?= $newsletter['Newsletter']['id']?>"<?=@($newsletter['Newsletter']['id'] == $this->params->query['newsletter_id'] || $newsletter['Newsletter']['id'] == $schedule['NewsletterSchedule']['newsletter_id']) ? ' selected' : ''?>><?= $newsletter['Newsletter']['title']?> (<?= $newsletter['0']['total']?>)</option>
      <?php endforeach ?>
            </select>
          </div>
          <div class="controls">
            <label class="control-label" for="title"><i class="gi gi-list mr-1"></i> Lista</label>
            <select class="form-control" name="data[list_id]" required>
      <?php foreach($lists as $list): ?>
      <option value="<?= $list['NewsletterList']['id']?>"<?=@($list['NewsletterList']['id'] == $this->params->query['list_id'] || $list['NewsletterList']['id'] == $schedule['NewsletterSchedule']['list_id']) ? ' selected' : ''?>><?= $list['NewsletterList']['name']?> (<?= $list['0']['total']?>)</option>
      <?php endforeach ?>
            </select>
          </div>
          <small>La tarea programada de Newsletters se ejecuta una vez por minuto en el servidor</small>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-box bg-success-outline">
        <h4 class="sub-header"><i class="gi gi-stopwatch"></i> <span class="ml-1">Programar fecha de envío</span></h4>
        <p>Establece la fecha y/o hora para la ejecución de esta camapaña</p>
        <div class="control-group">
          <label class="control-label" for="title">Programar fecha/hora</label>
          <div class="controls d-flex flex-center gap-05">
            <input type="text" name="data[schedule_date]" class="form-control datepicker" placeholder="Fecha del envío" value="<?=$this->Time->format($schedule['NewsletterSchedule']['schedule_date'] ?? date('d-m-Y'), '%d/%m/%Y')?>" data-force="true" required />
            <select class="form-control schedule_hour" name="data[schedule_hour]" data-value="<?=$schedule['NewsletterSchedule']['schedule_hour']?>" data-force="true"></select>
          </div>
          <small>Cualquier fecha / hora asignada anterior a hoy será procesada si tiene envíos pendientes</small>
        </div>
      </div>
    </div>
  </div>
  <div class="form-actions">
    <a href="<?=$this->Html->url(
      array(
        'controller' => 'admin',
        'action' => 'newsletters',
        'schedules'
      )
    )?>" class="btn btn-info">
      <i class="fa fa-chevron-left"></i> <span class="ml-1">Atrás</span>
    </a>
    <a href="/newsletter/template/<?=$schedule['Newsletter']['id']?>" class="btn btn-warning" target="_blank"><i class="fa fa-eye"></i> <span class="ml-1">Previsualizar</span></a>    
    <button class="btn btn-reset-ask btn-success track-coords" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-repeat"></i> <span class="ml-1">Reenviar</span></button>
    <button type="submit" name="save" class="btn btn-success track-coords" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check"></i> <span class="ml-1">Guardar</span></button>
  </div>
<?php echo $this->Form->end(); ?>

<div id="reset_content" class="d-none">
  <div class="controls flex-1">
    <label class="control-label" for="">Enviar a todos</label>
    <input type="checkbox" name="toggle_reset" value="1" id="toggle_reset" class="toggle-checkbox">
    <label for="toggle_reset" class="toggle-label toggle-force"></label>
    <small class="text-muted">Si desactivas esta opción solo se reenviará a los que fallaron el anterior intento.</small>
  </div>
  <div class="controls">
    <button class="btn btn-reset btn-success track-coords" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Reenviar</button>
  </div>
</div>
