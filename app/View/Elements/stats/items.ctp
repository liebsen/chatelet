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
<?php foreach ($items as $key => $item): ?>        
			<tr class="bg-<?=$item['rowclass']?> schedules-<?=$item['NewsletterSchedule']['id']?>">
				<td>
					<a 
						href="<?=$this->Html->url(array('action'=>'newsletters', 'schedules', 'edit', $item['NewsletterSchedule']['id']))?>" 
						data-toggle="tooltip" 
						title="Editar campaña">
					<?=$item['Newsletter']['title']?>/<?=$item['NewsletterList']['name']?>
					</a>
				</td>
				<td>
					<span class="badge badge-<?=!empty($item[0]['prod_total']) ? 'success' : 'light'?> is-rounded">
						<?=!empty($item[0]['prod_total']) ? $item[0]['prod_total'] : 'Estático'?>
					</span>
				</td>
				<td>
					<span class="badge badge-<?=!empty($item[0]['list_total']) ? 'info' : 'danger'?> is-rounded">
						<?=!empty($item[0]['list_total']) ? $item[0]['list_total'] : '<i class="fa fa-warning"></i> Lista vacía'?>
						</span>
				</td>
				<td>
					<span class="badge badge-<?=$item['rowclass']?>"><span class="status"><?=$item['status']?></span>
				</td>
				<td>
					<?php if(!empty($item['Newsletter']['send_email'])):?>
					<span class="badge badge-success is-rounded" title="Emails enviados">
						<i class="gi gi-envelope"></i> <span class="email_sent"><?=$item['stats']['email_sent']?></span> / <span class="email_total"><?=$item['stats']['email_total']?></span>
					</span> 
					<?php endif ?>
					<?php if(!empty($item['Newsletter']['send_push'])):?>
					<span class="badge badge-warning is-rounded" title="Notificación Push enviados">
						<i class="gi gi-chat"></i>
						<span class="push_sent"><?=$item['stats']['push_sent']?></span> / <span class="push_total"><?=$item['stats']['push_total']?></span>
					</span>
					<?php endif ?>
				</td>
				<td>
					<span class="badge badge-<?=strtotime($item['NewsletterSchedule']['schedule_date'] . ' ' . $item['NewsletterSchedule']['schedule_hour'] . ':00') > time() ? 'warning' : 'success'?> is-rounded" title="Fecha / Hora de ejecución">
					<?=$this->Time->format($item['NewsletterSchedule']['schedule_date'] . ' ' . $item['NewsletterSchedule']['schedule_hour'] . ':00', '%d/%m/%Y %H:00') ?> </span> 
					<span class="badge text-capitalize" title="Fecha / Hora de ejecución">
					<?=\readable_time_ago($item['NewsletterSchedule']['schedule_date'] . ' ' . $item['NewsletterSchedule']['schedule_hour'] . ':00') ?> </span>
				</td>
				<td> 
					<div class="btn-group">           
						<a 
							href="#" 
							data-toggle="tooltip" 
							title="" 
							class="btn btn-danger deletebutton" 
							data-original-title="Eliminar" 
							data-id="<?=$item['NewsletterSchedule']['id']?>" 
							data-url-back="<?=$this->Html->url(array('action'=>'newsletters', 'schedules'))?>" 
							data-delurl="<?=$this->Html->url(array('action'=>'newsletters', 'schedules', 'delete'))?>" 
							data-msg="<?=__('¿Eliminar Campaña?')?>"                   
							>
							<i class="fa fa-trash-o"></i>
						</a>
						<!--a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'edit', $item['Newsletter']['id']))?>" 
							data-toggle="tooltip" 
							title="Editar email" 
							class="btn btn-success" 
							>
							<i class="gi gi-edit"></i>
						</a-->
						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'edit', $item['Newsletter']['id']))?>" 
							data-toggle="tooltip" 
							title="Editar plantilla" 
							class="btn btn-warning" 
						>
							<i class="gi gi-picture"></i>
						</a>
						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'lists', 'edit', $item['NewsletterList']['id']))?>" 
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
							data-stats='<?=json_encode($item['stats'])?>'
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
    <button class="btn" type="button"><i class="fa fa-eye"></i> <span>Ver todo</span></button>
  </a>
<?php else: ?>
	<a href="/admin/newsletters/schedules">
    <button class="btn" type="button"><i class="fa fa-eye-slash"></i> <span>Ver menos</span></button>
  </a>
<?php endif ?>
  <a class="btn btn-success dropdown-toggle" href="<?=$this->Html->url(array('action'=>'newsletters', 'schedules', 'edit'))?>">
    <i class="gi gi-send"></i> <span class="ml-1">Nueva campaña</span>
  </a>
  <a class="btn btn-success btn-update-schedules" href="#">
    <i class="gi gi-repeat"></i> <span class="ml-1">Actualizar</span>
  </a>
</div>