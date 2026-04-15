<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->Html->script('schedules', array('inline' => false)); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
	<div class="mobile">
		<div class="d-flex flex-wrap justify-content-center align-items-left gap-05">
<?php foreach ($schedules as $key => $schedule): ?>
			<div class="card">
				<div class="card-body d-flex flex-wrap gap-1 w-auto">
					<a 
						href="<?=$this->Html->url(array('action'=>'newsletters', 'schedules', 'edit', $schedule['NewsletterSchedule']['id']))?>" 
						data-toggle="tooltip" 
						class="card-img"
						style="background-image: url('<?=\extract_jpeg_url($schedule['Newsletter']['body'])?>')"
						title="Editar campaña">
						<span class="badge badge-<?=$schedule['rowclass']?>"><?=$schedule['Newsletter']['title']?>
						</span>
					</a>
					<div class="card-text">
						<span class="badge badge-<?=$schedule['rowclass']?>">
							<span class="status"><?=$schedule['status']?></span>
						</span>
						<span class="badge badge-success">
							<i class="fa fa-image mr-1"></i> <?=$schedule['Newsletter']['title']?>
						</span>
						<span class="badge badge-<?=!empty($schedule[0]['prod_total']) ? 'success' : 'light'?> is-rounded">
							<?=!empty($schedule[0]['prod_total']) ? $schedule[0]['prod_total'] : 'Estático'?>
						</span>
						<span class="badge badge-info"><i class="fa fa-list mr-1"></i> <?=$schedule['NewsletterList']['name']?></span>
						<span class="badge badge-<?=!empty($schedule[0]['list_total']) ? 'info' : 'danger'?> is-rounded">
							<?=!empty($schedule[0]['list_total']) ? $schedule[0]['list_total'] : '<i class="fa fa-warning"></i> Lista vacía'?></span>
						<div class="d-flex flex-center flex-nowrap gap-05">
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
								<i class="gi gi-list"></i>
							</a>						
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
						</div>
					</div>
				</div>
			</div>
<?php endforeach ?>
		</div>
	</div>
	<div class="desktop">
		<table id="example-datatables" class="table table-bordered table-hover">
			<thead>
				<tr>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Campaña'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Estado'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Plantilla'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Lista'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Progreso'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Fecha/Hora'); ?></th>
					<th class="span1 text-center"><i class="gi gi-flash"></i></th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($schedules as $key => $schedule): ?>        
				<tr class="bg-<?=$schedule['rowclass']?> schedules-<?=$schedule['NewsletterSchedule']['id']?>">
					<td>
						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'schedules', 'edit', $schedule['NewsletterSchedule']['id']))?>" 
							data-toggle="tooltip" 
							class="card-img sm"
							style="background-image: url('<?=\extract_jpeg_url($schedule['Newsletter']['body'])?>')"
							title="Editar campaña"><span class="badge badge-info">#<?=$schedule['NewsletterSchedule']['id']?></span>
						</a>
					</td>
					<td>
						<span class="badge badge-<?=$schedule['rowclass']?>"><span class="status"><?=$schedule['status']?></span>
					</td>
					<td>
						<span class="badge badge-success"><?=$schedule['Newsletter']['title']?></span>
						<span class="badge badge-<?=!empty($schedule[0]['prod_total']) ? 'success' : 'light'?> is-rounded">
							<?=!empty($schedule[0]['prod_total']) ? $schedule[0]['prod_total'] : 'Estático'?>
						</span>
					</td>
					<td>
						<span class="badge badge-info"><?=$schedule['NewsletterList']['name']?></span>
						<span class="badge badge-<?=!empty($schedule[0]['list_total']) ? 'info' : 'danger'?> is-rounded">
							<?=!empty($schedule[0]['list_total']) ? $schedule[0]['list_total'] : '<i class="fa fa-warning"></i> Lista vacía'?>
							</span>
					</td>
					<td>
						<?php if(!empty($schedule['Newsletter']['send_email'])):?>
						<span class="badge badge-success is-rounded" title="Emails enviados">
							<i class="gi gi-envelope"></i> <span class="email_sent"><?=$schedule['stats']['email_sent']?></span> / <span class="email_total"><?=$schedule['stats']['email_total']?></span>
						</span> 
						<?php endif ?>
						<?php if(!empty($schedule['Newsletter']['send_push'])):?>
						<span class="badge badge-warning is-rounded" title="Push enviados">
							<i class="gi gi-chat"></i>
							<span class="push_sent"><?=$schedule['stats']['push_sent']?></span> / <span class="push_total"><?=$schedule['stats']['push_total']?></span>
						</span>
						<?php endif ?>
						<span class="badge badge-info is-rounded" title="Interacciones">
							<i class="gi gi-user"></i>
							<span class="clicks"><?=$schedule['stats']['clicks']?></span>
						</span>
					</td>
					<td>
						<span class="badge badge-<?=strtotime($schedule['NewsletterSchedule']['schedule_date'] . ' ' . $schedule['NewsletterSchedule']['schedule_hour'] . ':00') > time() ? 'warning' : 'success'?> is-rounded" title="Fecha / Hora de ejecución">
						<?=$this->Time->format($schedule['NewsletterSchedule']['schedule_date'] . ' ' . $schedule['NewsletterSchedule']['schedule_hour'] . ':00', '%d/%m/%Y %H:00') ?> </span> 
						<span class="badge is-rounded" title="Fecha / Hora de ejecución">
						<?=\readable_time_ago(strtotime($schedule['NewsletterSchedule']['schedule_date'] . ' ' . $schedule['NewsletterSchedule']['schedule_hour'] . ':00')) ?> </span>
					</td>
					<td> 
						<div class="d-flex flex-center flex-nowrap gap-05">
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
								<i class="gi gi-list"></i>
							</a>						
							<!--a 
								href="javascript:void(0)" 
								title="Editar email" 
								class="btn btn-warning btn-stats"
								data-stats='<?=json_encode($schedule['stats'])?>'
							>	
								<i class="gi gi-charts"></i>
							</a-->
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
						</div>
					</td>
				</tr>
	<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<div class="form-actions">
  <a class="btn btn-light btn-update-schedules" href="#">
    <i class="gi gi-repeat"></i> <span class="ml-1">Actualizar</span>
  </a>
<?php if(empty($this->params->query['extended'])): ?>
	<a href="/admin/newsletters/schedules?extended=1">
    <button class="btn" type="button"><i class="fa fa-eye"></i> <span>Ver todo</span></button>
  </a>
<?php else: ?>
	<a href="/admin/newsletters/schedules">
    <button class="btn" type="button"><i class="fa fa-eye-slash"></i> <span class="ml-1">Ver menos</span></button>
  </a>
<?php endif ?>
  <a class="btn btn-success dropdown-toggle" href="<?=$this->Html->url(array('action'=>'newsletters', 'schedules', 'edit'))?>">
    <i class="gi gi-magic"></i> <span class="ml-1">Crear campaña</span>
  </a>
</div>