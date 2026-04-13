<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php // echo $this->Html->script('newsletters-lists', array('inline' => false)); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
	<div class="mobile">
		<div class="d-flex flex-wrap justify-content-center align-items-left gap-1">
<?php foreach ($lists as $key => $list): ?>
			<div class="card">
				<div class="card-body d-flex flex-wrap gap-1 w-auto">
					<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'lists', 'edit', $list['NewsletterList']['id']))?>" 
							data-toggle="tooltip" 
							class="card-img"
							title="<?=$list['NewsletterList']['text']?>">
						<span class="badge"><?=$this->Time->format($list['NewsletterList']['modified'], '%d/%m/%Y')?></span>
					</a>
					<div class="card-text">
						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'lists', 'edit', $list['NewsletterList']['id']))?>" 
							data-toggle="tooltip" 
							title="<?=$list['NewsletterList']['text']?>">
						<?=$list['NewsletterList']['name']?>
						</a>
						<span class="badge badge-<?=!empty($list[0]['total']) ? 'success' : 'danger'?> is-rounded">
								<?=!empty($list[0]['total']) ? $list[0]['total'] : '<i class="fa fa-warning"></i> Lista vacía'?>
						</span>
						<div class="d-flex flex-center flex-nowrap gap-05">          
							<a 
								href="<?=$this->Html->url(
									array(
										'action' => 'newsletters', 
										'schedules', 
										'edit', 
										'?' => array(
											'newsletter_id' => $list['Newsletter']['id']
										)
									)
								)?>"
								data-toggle="tooltip" 
								title="Programar envío" 
								class="btn btn-success" 
							>
								<i class="gi gi-send"></i>
							</a>
							<a 
								href="#" 
								data-toggle="tooltip" 
								title="" 
								class="btn btn-danger deletebutton" 
								data-original-title="Eliminar" 
								data-id="<?=$list['NewsletterList']['id']?>" 
								data-url-back="<?=$this->Html->url(array('action'=>'newsletters', 'lists'))?>" 
								data-delurl="<?=$this->Html->url(array('action'=>'newsletters', 'lists', 'delete'))?>" 
								data-msg="<?=__('¿Eliminar Lista?')?>"                   
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
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Lista'); ?></th>
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
							<span class="badge"><?=$list['NewsletterList']['name']?></span>
						</a>
					</td>
					<td>
						<span class="badge badge-<?=!empty($list[0]['total']) ? 'success' : 'danger'?> is-rounded">
							<?=!empty($list[0]['total']) ? $list[0]['total'] : '<i class="fa fa-warning"></i> Lista vacía'?>
						</span>
					</td>
					<td>
						<?=$this->Time->format($list['NewsletterList']['modified'], '%d/%m/%Y')?>
					</td>
					<td> 
						<div class="d-flex flex-center flex-nowrap gap-05">          
							<!--a 
								href="<?=$this->Html->url(array('action'=>'newsletters', 'lists', 'edit', $list['NewsletterList']['id']))?>" 
								data-toggle="tooltip" 
								title="Editar email" 
								class="btn btn-success" 
								>
								<i class="gi gi-edit"></i>
							</a-->
							<a 
								href="<?=$this->Html->url(
									array(
										'action' => 'newsletters', 
										'schedules', 
										'edit', 
										'?' => array(
											'newsletter_id' => $list['Newsletter']['id']
										)
									)
								)?>"
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
								data-stats='<?=json_encode($list['stats'])?>'
							>
								<i class="gi gi-charts"></i>
							</a-->
							<a 
								href="#" 
								data-toggle="tooltip" 
								title="" 
								class="btn btn-danger deletebutton" 
								data-original-title="Eliminar" 
								data-id="<?=$list['NewsletterList']['id']?>" 
								data-url-back="<?=$this->Html->url(array('action'=>'newsletters', 'lists'))?>" 
								data-delurl="<?=$this->Html->url(array('action'=>'newsletters', 'lists', 'delete'))?>" 
								data-msg="<?=__('¿Eliminar Lista?')?>"                   
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
<?php if(empty($this->params->query['extended'])): ?>
	<a href="/admin/newsletters/lists?extended=1">
    <button class="btn" type="button">Ver todo</button>
  </a>
<?php else: ?>
	<a href="/admin/newsletters/lists">
    <button class="btn" type="button">Ver menos</button>
  </a>
<?php endif ?>
  <a class="btn btn-info dropdown-toggle" href="<?=$this->Html->url(array('action'=>'newsletters', 'lists', 'edit'))?>">
    <i class="gi gi-magic mr-1"></i> Crear lista
  </a>
	</div>