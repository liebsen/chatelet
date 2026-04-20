<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->Html->script('schedules', array('inline' => false)); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
	<div class="mobile">
		<div class="d-flex flex-wrap justify-content-center align-items-left gap-05">
<?php foreach ($schedules as $key => $schedule): ?>
			<div class="card card-auto schedule-rt schedules-<?=$schedule['NewsletterSchedule']['id']?>" data-id="<?=$schedule['NewsletterSchedule']['id']?>">
				<div class="card-body d-flex flex-between flex-nowrap gap-1 w-auto">
					<a 
						href="<?=$this->Html->url(array('action'=>'newsletters', 'schedules', 'edit', $schedule['NewsletterSchedule']['id']))?>" 
						data-toggle="tooltip" 
						class="card-img"
						style="background-image: url('<?=\extract_jpeg_url($schedule['Newsletter']['body'])?>')"
						title="Editar campaña">
						<span class="badge">#<?=$schedule['NewsletterSchedule']['id']?></span>
						<span class="badge"><?=\readable_time_ago(strtotime($schedule['NewsletterSchedule']['schedule_date'] . ' ' . $schedule['NewsletterSchedule']['schedule_hour'] . ':00')) ?> </span></span>
					</a>
					<div class="card-text">
						<span class="badge badge-<?=$schedule['rowclass']?>"><?=$schedule['status']?>
						</span>
						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'edit', $schedule['Newsletter']['id']))?>" 
							data-toggle="tooltip" 
							title="Editar plantilla" 
						>						
							<span class="badge badge-<?=!empty($schedule['prod_total']) ? 'success' : 'light'?>">
							<i class="fa fa-image mr-1"></i> <?=\word_limit($schedule['Newsletter']['title'])?> <?=!empty($schedule['prod_total']) ? '('.$schedule['prod_total'].')' : ''?>
							</span>
							<a 
								href="<?=$this->Html->url(
									array(
										'action' => 'newsletters', 
										'templates', 
										'edit', 
										$schedule['Newsletter']['id'],
										'#' => 'editor',
									)
								)?>"
								data-toggle="tooltip" 
								title="Editar contenido" 
								class="badge badge-info"><i class="gi gi-font"></i>
							</a>							
						</a>

						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'lists', 'edit', $schedule['NewsletterList']['id']))?>" 
							data-toggle="tooltip" 
							title="Editar lista" 
						>						
							<span class="badge badge-info"><i class="fa fa-list mr-1"></i> <?=$schedule['NewsletterList']['name']?> <?=!empty($schedule['list_total']) ? '('.$schedule['list_total'].')' : ''?></span>
						</a>

						<?php if($schedule['Newsletter']['send_email'] == '1'):?>
						<span class="badge badge-success is-rounded" title="Emails enviados">
							<i class="gi gi-envelope"></i> <span class="email_sent"><?=$schedule['stats']['email_sent']?></span> / <span class="email_total"><?=$schedule['stats']['email_total']?></span>
						</span> 
						<?php endif ?>
						<?php if($schedule['Newsletter']['send_push'] == '1'):?>
						<span class="badge badge-warning is-rounded" title="Push enviados">
							<i class="gi gi-chat"></i>
							<span class="push_sent"><?=$schedule['stats']['push_sent']?></span> / <span class="push_total"><?=$schedule['stats']['push_total']?></span>
						</span>
						<?php endif ?>
						<span class="badge badge-danger is-rounded" title="Interacciones">
							<i class="gi gi-fire"></i>
							<span class="clicks"><?=$schedule['stats']['clicks']?></span>
						</span>
					</div>
					<div class="d-flex flex-column flex-center flex-nowrap gap-05">
				    <a href="<?=$this->Html->url(
				        array(
				          'controller' => 'newsletter', 
				          'action' => 'template',
				          $schedule['Newsletter']['id']
				        )
				      )?>"
				      class="btn btn-sm btn-success" 
				      title="Previsualizar plantilla"
				      target="_blank">
				      <i class="fa fa-eye"></i> 
				    </a>
						<a 
							href="#" 
							data-toggle="tooltip" 
							title="" 
							class="btn btn-sm btn-danger deletebutton" 
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
<?php endforeach ?>
		</div>
	</div>
	<div class="desktop">
		<table id="schedules-datatables" class="table table-bordered table-hover">
			<thead>
				<tr>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('#'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Estado'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Autor'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Plantilla'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Lista'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Progreso'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Fecha/Hora'); ?></th>
					<th class="span1 text-center"><i class="gi gi-flash"></i></th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($schedules as $key => $schedule): ?>        
				<tr class="schedule-rt schedules-<?=$schedule['NewsletterSchedule']['id']?>" data-id="<?=$schedule['NewsletterSchedule']['id']?>">
					<td>
						<a 
							href="<?=$this->Html->url(
								array(
									'action'=>'newsletters', 
									'schedules', 
									'edit', 
									$schedule['NewsletterSchedule']['id']
								)
							)?>" 
							data-toggle="tooltip" 
							class="card-img sm"
							style="background-image: url('<?=\extract_jpeg_url($schedule['Newsletter']['body'])?>')"
							title="Editar campaña"><span class="badge badge-info">#<?=$schedule['NewsletterSchedule']['id']?></span>
						</a>
					</td>
					<td>
						<span class="badge badge-<?=$schedule['rowclass']?>">
							<span class="status"><?=$schedule['status']?></span>
						</span>
					</td>
					<td>
<?php if(strlen($schedule['User']['name'])):?>
	<span class="badge badge-info"><?=$schedule['User']['name']?></span>
<?php else: ?>
	<span class="badge badge-info text-lowercase"><?=strstr($schedule['User']['email'],'@',true)?></span>
<?php endif ?>
					</td>
					<td>
						<span class="badge badge-<?=!empty($schedule['prod_total']) ? 'success' : 'light'?>"><?=\word_limit($schedule['Newsletter']['title'])?> <?=!empty($schedule['prod_total']) ? '('.$schedule['prod_total'].')' : ''?></span>
						<a 
							href="<?=$this->Html->url(
								array(
									'action' => 'newsletters', 
									'templates', 
									'edit', 
									$schedule['Newsletter']['id'],
									'#' => 'editor',
								)
							)?>"
							data-toggle="tooltip" 
							title="Editar contenido" 
							class="badge badge-info"><i class="gi gi-font"></i>
						</a>
						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'edit', $schedule['Newsletter']['id']))?>" 
							data-toggle="tooltip" 
							title="Editar plantilla" 
							class="badge badge-warning" 
						>
							<i class="gi gi-picture"></i>
						</a>
					</td>
					<td>
						<span class="badge badge-<?=!empty($schedule['list_total']) ? 'info' : 'danger'?>"><?=$schedule['NewsletterList']['name']?> <?=!empty($schedule['list_total']) ? '('.$schedule['list_total']. ')' : ''?></span>
						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'lists', 'edit', $schedule['NewsletterList']['id']))?>" 
							data-toggle="tooltip" 
							title="Editar lista" 
							class="badge badge-info" 
						>
							<i class="gi gi-list"></i>
						</a>
					</td>
					<td>
						<?php if($schedule['Newsletter']['send_email'] == '1'):?>
						<span class="badge badge-success is-rounded" title="Emails enviados">
							<i class="gi gi-envelope"></i> <span class="email_sent"><?=$schedule['stats']['email_sent']?></span> / <span class="email_total"><?=$schedule['stats']['email_total']?></span>
						</span> 
						<?php endif ?>
						<?php if($schedule['Newsletter']['send_push'] == '1'):?>
						<span class="badge badge-warning is-rounded" title="Push enviados">
							<i class="gi gi-chat"></i>
							<span class="push_sent"><?=$schedule['stats']['push_sent']?></span> / <span class="push_total"><?=$schedule['stats']['push_total']?></span>
						</span>
						<?php endif ?>
						<span class="badge badge-danger is-rounded" title="Interacciones">
							<i class="gi gi-fire"></i>
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
						<div class="d-flex flex-center flex-nowrap gap-25">

					    <a href="<?=$this->Html->url(
					        array(
					          'controller' => 'newsletter', 
					          'action' => 'template',
					          $schedule['Newsletter']['id']
					        )
					      )?>"
					      class="btn btn-sm btn-success" 
					      title="Previsualizar plantilla"
					      target="_blank">
					      <i class="fa fa-eye"></i> 
					    </a>
							<a 
								href="#" 
								data-toggle="tooltip" 
								title="" 
								class="btn btn-sm btn-danger deletebutton" 
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
  <a class="btn btn-light btn-update-schedules text-success animation-fadeIn animation-both delay3" href="#">
    <i class="gi gi-repeat"></i> <span class="ml-1">Actualiza [<span class="update-countdown">-</span>]</span>
  </a>
<?php if(empty($this->params->query['extended'])): ?>
	<a href="/admin/newsletters/schedules?extended=1">
    <button class="btn" type="button"><i class="fa fa-eye"></i> <span class="ml-1">Ver todo</span></button>
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

<style type="text/css">
	.btn-update-schedules {
		min-width: 20rem;
		text-align: left;
	}
</style>