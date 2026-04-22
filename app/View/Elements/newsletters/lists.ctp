<?php // echo $this->Html->script('newsletters-lists', array('inline' => false)); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
	<div class="mobile">
		<div class="d-flex flex-wrap justify-content-center align-items-left gap-05">
<?php foreach ($lists as $key => $list): ?>
			<div class="card card-auto">
				<div class="card-body d-flex flex-between flex-nowrap gap-05 w-auto">
					<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'lists', 'edit', $list['NewsletterList']['id']))?>" 
							data-toggle="tooltip" 
							class="card-img"
							title="<?=$list['NewsletterList']['text']?>">
						<span class="badge">#<?=$list['NewsletterList']['id']?></span>
						<span class="badge"><?=\readable_time_ago($list['NewsletterList']['modified']) ?></span>
					</a>
					<div class="card-text">
						<span class="badge badge-<?=$list['NewsletterList']['enabled'] == '1' ? 'success' : 'light'?>"><?=$list['NewsletterList']['name']?></span>
						<span>
							<i class="gi gi-woman fa-lg"></i> <span>Audiencia</span>
							<span class="badge badge-<?=!empty($list[0]['total']) ? '-success' : '-danger d-block'?>">
								<?=!empty($list[0]['total']) ? $list[0]['total'] : '<i class="fa fa-warning"></i> Lista vacía'?>
							</span>
						</span>
					</div>
					<div class="d-flex flex-column flex-center flex-nowrap gap-05">          
						<a 
							href="<?=$this->Html->url(
								array(
									'action' => 'newsletters', 
									'schedules', 
									'edit', 
									'?' => array(
										'list_id' => $list['NewsletterList']['id']
									)
								)
							)?>"
							data-toggle="tooltip" 
							title="Programar envío" 
							class="btn btn-sm btn-success" 
						>
							<i class="gi gi-send"></i>
						</a>
<?php if($list['User']['id']==$this->Session->read('Auth.User.id')):?>
						<a 
							href="#"
							data-toggle="tooltip" 
							title="" 
							class="btn btn-sm btn-danger deletebutton" 
							data-original-title="Eliminar" 
							data-id="<?=$list['NewsletterList']['id']?>" 
							data-url-back="<?=$this->Html->url(array('action'=>'newsletters', 'lists'))?>" 
							data-delurl="<?=$this->Html->url(array('action'=>'newsletters', 'lists', 'delete'))?>" 
							data-msg="<?=__('¿Eliminar Lista?')?>"                   
							>
							<i class="fa fa-trash-o"></i>
						</a>
<?php endif ?>
					</div>
				</div>
			</div>
<?php endforeach ?>	
		</div>
	</div>
	<div class="desktop">
		<table id="lists-datatables" class="table table-bordered table-hover">
			<thead>
				<tr>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('#'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Nombre'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Autor'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Audiencia'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Modificado'); ?></th>
					<th class="span1 text-center"><i class="gi gi-flash"></i></th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($lists as $key => $list): ?>
				<tr>
					<td>
						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'lists', 'edit', $list['NewsletterList']['id']))?>" 
							data-toggle="tooltip" 
							class="card-img sm"
							title="<?=$list['NewsletterList']['text']?>">
							<span class="badge badge-info">#<?=$list['NewsletterList']['id']?></span>
						</a>
					</td>
					<td>
						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'lists', 'edit', $list['NewsletterList']['id']))?>">
							<span class="badge badge-<?=$list['NewsletterList']['enabled'] == '1' ? 'success' : 'light'?>" title="<?=$list['NewsletterList']['name']?>"><?=\word_limit($list['NewsletterList']['name'])?></span>
						</a>
					</td>
					<td>
<?php if(strlen($list['User']['name'])):?>
	<span class="badge badge-info"><?=$list['User']['name']?></span>
<?php else: ?>
	<span class="badge badge-info text-lowercase"><?=strstr($list['User']['email'],'@',true)?></span>
<?php endif ?>
					</td>
					<td>
						<span class="badge badge-<?=!empty($list[0]['total']) ? 'success' : 'danger'?> is-rounded">
							<?=!empty($list[0]['total']) ? $list[0]['total'] : '<i class="fa fa-warning"></i> Lista vacía'?>
						</span>
					</td>
					<td data-order="<?=strtotime($list['NewsletterList']['modified'])?>">
						<span class="badge is-rounded" title="<?=$this->Time->format($list['NewsletterList']['modified'], '%d/%m/%Y %H:%M')?>">
						<?=\readable_time_ago($list['NewsletterList']['modified'])?> </span>
					</td>
					<td> 
						<div class="d-flex flex-center flex-nowrap gap-25">          
							<a 
								href="<?=$this->Html->url(
									array(
										'action' => 'newsletters', 
										'schedules', 
										'edit', 
										'?' => array(
											'list_id' => $list['NewsletterList']['id']
										)
									)
								)?>"
								data-toggle="tooltip" 
								title="Programar envío" 
								class="btn btn-sm btn-success" 
							>
								<i class="gi gi-send"></i>
							</a>
							<!--a 
								href="javascript:void(0)" 
								title="Editar email" 
								class="btn btn-warning btn-stats"
								data-stats='<?=json_encode($list['stats'])?>'
							>
								<i class="gi gi-charts"></i>
							</a-->
<?php if($list['User']['id']==$this->Session->read('Auth.User.id')):?>
							<a 
								href="#" 
								data-toggle="tooltip" 
								title="" 
								class="btn btn-sm btn-danger deletebutton" 
								data-original-title="Eliminar" 
								data-id="<?=$list['NewsletterList']['id']?>" 
								data-url-back="<?=$this->Html->url(array('action'=>'newsletters', 'lists'))?>" 
								data-delurl="<?=$this->Html->url(array('action'=>'newsletters', 'lists', 'delete'))?>" 
								data-msg="<?=__('¿Eliminar Lista?')?>"                   
								>
								<i class="fa fa-trash-o"></i>
							</a>
<?php endif ?>
						</div>
					</td>
				</tr>
	<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<div class="form-actions">
<?php if(empty($this->params->query['extended'])): ?>
	<a href="/admin/newsletters/lists?extended=1">
    <button class="btn" type="button"><i class="fa fa-eye"></i> <span class="ml-1">Ver todo</span></button>
  </a>
<?php else: ?>
	<a href="/admin/newsletters/lists">
    <button class="btn" type="button"><i class="fa fa-eye-slash mr-1"></i><span class="ml-1">Ver menos</span></button>
  </a>
<?php endif ?>
  <a class="btn btn-success dropdown-toggle" href="<?=$this->Html->url(array('action'=>'newsletters', 'lists', 'edit'))?>">
    <i class="gi gi-magic"></i> <span class="ml-1">Crear lista</span>
  </a>
	</div>