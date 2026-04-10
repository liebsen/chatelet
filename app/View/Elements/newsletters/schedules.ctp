<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->Html->script('schedules', array('inline' => false)); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
	<table id="example-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Campaña'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Catálogo'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Audiencia'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Estado'); ?></th>     		
     		<th class="hidden-phone hidden-tablet"><?php echo __('Progreso'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Fecha/Hora'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
<?php foreach ($schedules as $key => $schedule): ?>        
			<tr>
				<td>
					<a 
						href="<?=$this->Html->url(array('action'=>'newsletters', 'schedules', 'edit', $schedule['NewsletterSchedule']['id']))?>" 
						data-toggle="tooltip" 
						title="Editar campaña">
					<?=$schedule['Newsletter']['title']?>/<?=$schedule['NewsletterList']['name']?>
					</a>
				</td>
				<td>
					<span class="badge badge-<?=!empty($schedule[0]['prod_total']) ? 'success' : 'light'?> is-rounded">
						<?=!empty($schedule[0]['prod_total']) ? $schedule[0]['prod_total'] : 'Estático'?>
					</span>
				</td>
				<td>
					<span class="badge badge-<?=!empty($schedule[0]['list_total']) ? 'info' : 'danger'?> is-rounded">
						<?=!empty($schedule[0]['list_total']) ? $schedule[0]['list_total'] : '<i class="fa fa-warning"></i> Lista vacía'?>
						</span>
				</td>
				<td>
					<span class="badge badge-<?=$schedule['rowclass']?>"><?=$schedule['status']?></span>
				</td>
				<td>
					<span class="badge badge-success is-rounded" title="Emails enviados">
						<i class="gi gi-envelope"></i> <?=$schedule['stats']['email_sent']?> / <?=$schedule['stats']['email_total']?>
					</span> 
					<span class="badge badge-warning is-rounded" title="Notificación Push enviados">
						<i class="gi gi-chat"></i><?=$schedule['stats']['push_sent']?> / <?=$schedule['stats']['push_total']?>
					</span>
				</td>
				<td>
					<span class="badge badge-<?=strtotime($schedule['NewsletterSchedule']['schedule_date'] . ' ' . $schedule['NewsletterSchedule']['schedule_hour'] . ':00') > time() ? 'warning' : 'success'?> is-rounded" title="Fecha / Hora de ejecución">
					<?=$this->Time->format($schedule['NewsletterSchedule']['schedule_date'] . ' ' . $schedule['NewsletterSchedule']['schedule_hour'] . ':00', '%d/%m/%Y %H:00') ?> </span> 
					<span class="badge is-rounded" title="Fecha / Hora de ejecución">
					<?=\readable_time_ago(strtotime($schedule['NewsletterSchedule']['schedule_date'] . ' ' . $schedule['NewsletterSchedule']['schedule_hour'] . ':00')) ?> </span>
				</td>
				<td> 
					<div class="btn-group">           
						<a 
							href="#" 
							data-toggle="tooltip" 
							title="" 
							class="btn btn-danger deletebutton" 
							data-original-title="Eliminar" 
							data-id="<?=$schedule['NewsletterSchedule']['id']?>" 
							data-url-back="<?=$this->Html->url(array('action'=>'newsletters', 'schedules'))?>" 
							data-delurl="<?=$this->Html->url(array('action'=>'newsletters', 'schedules', 'delete'))?>" 
							data-msg="<?=__('¿Eliminar Campaña?')?>"                   
							>
							<i class="fa fa-trash-o"></i>
						</a>
						<!--a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'edit', $schedule['Newsletter']['id']))?>" 
							data-toggle="tooltip" 
							title="Editar email" 
							class="btn btn-success" 
							>
							<i class="gi gi-edit"></i>
						</a-->
						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'edit', $schedule['Newsletter']['id']))?>" 
							data-toggle="tooltip" 
							title="Editar plantilla" 
							class="btn btn-warning" 
						>
							<i class="gi gi-picture"></i>
						</a>
						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'lists', 'edit', $schedule['NewsletterList']['id']))?>" 
							data-toggle="tooltip" 
							title="Editar lista" 
							class="btn btn-info" 
						>
							<i class="gi gi-group"></i>
						</a>						
						<!--a 
							href="javascript:void(0)" 
							title="Editar email" 
							class="btn btn-warning btn-stats"
							data-stats='<?=json_encode($schedule['stats'])?>'
						>	
							<i class="gi gi-charts"></i>
						</a-->						
					</div>
				</td>
			</tr>
<?php endforeach ?>
		</tbody>
	</table>
	<div class="form-actions">
<?php if(empty($this->params->query['extended'])): ?>
	<a href="/admin/newsletters/schedules?extended=1">
    <button class="btn" type="button">Ver todo</button>
  </a>
<?php else: ?>
	<a href="/admin/newsletters/schedules">
    <button class="btn" type="button">Ver menos</button>
  </a>
<?php endif ?>
  <a class="btn btn-success dropdown-toggle" href="<?=$this->Html->url(array('action'=>'newsletters', 'schedules', 'edit'))?>">
    <i class="gi gi-send mr-1"></i> Crear nueva campaña
  </a>
  <a class="btn btn-success <?=$_SERVER['REMOTE_ADDR'] == '127.0.0.1' ? 'btn-updates-schedules' : 'btn-refresh'?>" href="#">
    <i class="gi gi-repeat mr-1"></i> Actualizar
  </a>
</div>