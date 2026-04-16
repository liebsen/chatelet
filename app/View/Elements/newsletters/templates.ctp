<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
	<div class="mobile">
		<div class="d-flex flex-wrap justify-content-center align-items-left gap-05">
<?php foreach ($newsletters as $key => $newsletter): ?>
			<div class="card">
				<div class="card-body d-flex flex-wrap gap-1 w-auto">
					<a 
						href="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'edit', $newsletter['Newsletter']['id']))?>" 
						data-toggle="tooltip" 
						class="card-img"
						style="background-image: url('<?=\extract_jpeg_url($newsletter['Newsletter']['body'])?>')"
						title="Editar plantilla">
							<span class="badge badge-<?=$newsletter['Newsletter']['enabled'] == '1' ? 'success' : 'info'?>"><?=$newsletter['Newsletter']['title']?></span>
					</a>
					<div class="card-text">
						<span>
							<i class="gi gi-envelope fa-lg"></i>
							<i class="gi gi-circle_<?=$newsletter['Newsletter']['send_email'] == '1' ? 'ok text-success' : 'remove text-danger'?> fa-lg"></i>
						</span>
						<span>
							<i class="gi gi-chat fa-lg"></i>
							<i class="gi gi-circle_<?=$newsletter['Newsletter']['send_push'] == '1' ? 'ok text-success' : 'remove text-danger'?> fa-lg"></i>
						</span>
						<span>
							<i class="gi gi-shirt fa-lg"></i>
							<span class="badge badge-success is-rounded"><?=count($newsletter['NewsletterProduct'])?></span>
						</span>
						<span class="badge"> 
							<?=$this->Time->format($newsletter['Newsletter']['modified'], '%d/%m/%Y %H:%M')?>
						</span>
						<span class="badge is-rounded"><?=\readable_time_ago(strtotime($newsletter['Newsletter']['modified'])) ?></span>
						<div class="d-flex flex-center flex-nowrap gap-05">     
							<a 
								href="<?=$this->Html->url(
									array(
										'action' => 'newsletters', 
										'templates', 
										'edit', 
										$newsletter['Newsletter']['id'].'#editor'
									)
								)?>"
								data-toggle="tooltip" 
								title="Editar contenido" 
								class="btn btn-success"><i class="gi gi-edit"></i>
							</a>
							<a 
								href="<?=$this->Html->url(array(
									'action' => 'newsletters', 
									'schedules', 
									'edit', 
									'?' => array(
										'newsletter_id' => $newsletter['Newsletter']['id']
									)
								))?>" 
								data-toggle="tooltip" 
								title="Programar envío" 
								class="btn btn-success" 
							>
								<i class="gi gi-send"></i>
							</a>
							<a 
								href="<?=$this->Html->url(
									array(
										'controller' => 'newsletter', 
										'action' => 'template',
										$newsletter['Newsletter']['id']
									)
								)?>" 
								data-toggle="tooltip" 
								title="Previsualizar" 
								class="btn btn-warning"
								target="_blank" 
							>
								<i class="fa fa-eye"></i>
							</a>							
							<a 
								href="#" 
								data-toggle="tooltip" 
								title="" 
								class="btn btn-danger deletebutton" 
								data-original-title="Eliminar" 
								data-id="<?=$newsletter['Newsletter']['id']?>" 
								data-url-back="<?=$this->Html->url(array('action'=>'newsletters', 'templates'))?>" 
								data-delurl="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'delete'))?>" 
								data-msg="<?=__('¿Eliminar Plantilla?')?>"                   
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
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Plantilla'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Nombre'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Email'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Push'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Catálogo'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Modificado'); ?></th>
					<th class="span1 text-center"><i class="gi gi-flash"></i></th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($newsletters as $key => $newsletter): ?>        
				<tr class="<?=$schedule['rowclass'] ?? ''?>">
					<td>					
						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'edit', $newsletter['Newsletter']['id']))?>" 
							data-toggle="tooltip" 
							class="card-img sm"
							style="background-image: url('<?=\extract_jpeg_url($newsletter['Newsletter']['body'])?>')"
							title="Editar plantilla"><span class="badge badge-info">#<?=$newsletter['Newsletter']['id']?></span>
						</a>
					</td>
					<td>
						<span class="badge badge-<?=$newsletter['Newsletter']['enabled'] == '1' ? 'success' : 'info'?>"><?=$newsletter['Newsletter']['title']?></span>
					</td>
					<td>
						<i class="gi gi-circle_<?=$newsletter['Newsletter']['send_email'] == '1' ? 'ok text-success' : 'remove text-danger'?> fa-lg"></i>
					</td>
					<td>
						<i class="gi gi-circle_<?=$newsletter['Newsletter']['send_push'] == '1' ? 'ok text-success' : 'remove text-danger'?> fa-lg"></i>
					</td>
					<td>
						<span class="badge badge-success is-rounded"><?=count($newsletter['NewsletterProduct'])?></span>
					</td>
					<td>
						<span class="badge"><?=$this->Time->format($newsletter['Newsletter']['modified'], '%d/%m/%Y %H:%M')?></span>
						<span class="badge is-rounded"><?=\readable_time_ago(strtotime($newsletter['Newsletter']['modified'])) ?></span>
					</td>
					<td>
						<div class="d-flex flex-center flex-nowrap gap-05">   
							<a 
								href="<?=$this->Html->url(
									array(
										'action' => 'newsletters', 
										'templates', 
										'edit', 
										$newsletter['Newsletter']['id'],
										'#' => 'editor'
									)
								)?>"
								data-toggle="tooltip" 
								title="Editar contenido" 
								class="btn btn-success"><i class="gi gi-edit"></i>
							</a>	
							<a 
								href="<?=$this->Html->url(array(
									'action' => 'newsletters', 
									'schedules', 
									'edit', 
									'?' => array(
										'newsletter_id' => $newsletter['Newsletter']['id']
									)
								))?>" 
								data-toggle="tooltip" 
								title="Programar envío" 
								class="btn btn-success" 
							>
								<i class="gi gi-send"></i>
							</a>
							<a 
								href="<?=$this->Html->url(
									array(
										'controller' => 'newsletter', 
										'action' => 'template',
										$newsletter['Newsletter']['id']
									)
								)?>" 
								data-toggle="tooltip" 
								title="Previsualizar" 
								class="btn btn-warning"
								target="_blank" 
							>
								<i class="fa fa-eye"></i>
							</a>
							<a 
								href="#" 
								data-toggle="tooltip" 
								title="" 
								class="btn btn-danger deletebutton" 
								data-original-title="Eliminar" 
								data-id="<?=$newsletter['Newsletter']['id']?>" 
								data-url-back="<?=$this->Html->url(array('action'=>'newsletters', 'templates'))?>" 
								data-delurl="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'delete'))?>" 
								data-msg="<?=__('¿Eliminar Plantilla?')?>"                   
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
	<a href="/admin/newsletters/templates?extended=1">
    <button class="btn" type="button"><i class="fa fa-eye"></i> <span class="ml-1">Ver todo</span></button>
  </a>
<?php else: ?>
	<a href="/admin/newsletters/templates">
    <button class="btn" type="button"><i class="fa fa-eye-slash"></i> <span class="ml-1">Ver menos</span></button>
  </a>
<?php endif ?>
	  <a class="btn btn-success dropdown-toggle" href="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'edit'))?>">
	    <i class="gi gi-magic"></i> <span class="ml-1">Crear Plantilla</span>
	  </a>
  </div>