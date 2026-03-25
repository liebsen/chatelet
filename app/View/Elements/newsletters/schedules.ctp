<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php // echo $this->Html->script('newsletters-schedules', array('inline' => false)); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
	<table id="example-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Plantilla'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Estado'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Productos'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Cuentas'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Progreso'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Fecha/Hora'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
<?php foreach ($schedules as $key => $schedule): ?>        
			<tr class="<?=$schedule['rowclass'] ?? ''?>">
				<td>
					<a 
						href="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'edit', $schedule['Newsletter']['id']))?>" 
						data-toggle="tooltip" 
						title="Editar plantilla">
					<?=$schedule['Newsletter']['title']?> (<?=$schedule['Newsletter']['name']?>)
					</a>
				</td>
				<td>
					<?=$schedule['status']?>
				</td>
				<td>
					<span class="badge badge-<?=count($schedule['Products']) ? 'success' : 'light'?>">
						<?=count($schedule['Products'])?>
					</span>
				</td>
				<td>
					<span class="badge badge-<?=count($schedule['Users']) ? 'info' : 'danger'?>">
						<?=count($schedule['Users'])?>
						</span>
				</td>
				<td>
					<span class="badge badge-success" title="Emails enviados">
						<?=count($schedule['stats']['email_sent'])?>
					</span> 
					<span class="badge badge-warning" title="Notificación Push enviados">
						<?=count($schedule['stats']['push_sent'])?>
					</span> 
					<span class="badge badge-info" title="Total a enviar">
						<?=count($schedule['stats']['total'])?>
					</span>
				</td>
				<td>
					<?=$this->Time->format($schedule['NewsletterSchedule']['schedule_date'], '%d/%m/%Y')?> - <?=$schedule['NewsletterSchedule']['schedule_hour']??'0'?>hs
				</td>
				<td> 
					<div class="btn-group">           
						<a 
							href="#" 
							data-toggle="tooltip" 
							title="" 
							class="btn btn-danger deletebutton" 
							data-original-title="Eliminar" 
							data-id="<?=$schedule['Newsletter']['id']?>" 
							data-url-back="<?=$this->Html->url(array('action'=>'newsletters'))?>" 
							data-delurl="<?=$this->Html->url(array('action'=>'newsletters', 'delete'))?>" 
							data-msg="<?=__('¿Eliminar Newsletter?')?>"                   
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
							href="<?=$this->Html->url(array('action'=>'newsletters', 'schedules', 'edit', $schedule['NewsletterSchedule']['id']))?>" 
							data-toggle="tooltip" 
							title="Programar envío" 
							class="btn btn-success" 
						>
							<i class="gi gi-send"></i>
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
	</div>