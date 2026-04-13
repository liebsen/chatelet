<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
	<div class="mobile">
		<div class="d-flex flex-wrap justify-content-center align-items-left gap-1">
<?php foreach ($newsletters as $key => $newsletter): ?>
			<div class="card">
				<div class="card-body d-flex flex-wrap gap-1 w-auto">
					<div class="card-img">
						<span class="badge"></span>
					</div>
					<div class="card-text">
						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'edit', $newsletter['Newsletter']['id']))?>" 
							data-toggle="tooltip" 
							title="Editar plantilla">
							<?=$newsletter['Newsletter']['title']?> (<?=$newsletter['Newsletter']['title']?>)
						</a>
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
						<div class="d-flex flex-center flex-nowrap gap-05">        
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
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Email'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Push'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Catálogo'); ?></th>
	     		<th class="hidden-phone hidden-tablet"><?php echo __('Envíos'); ?></th>
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
							title="Editar plantilla">
							<?=$newsletter['Newsletter']['title']?> (<?=$newsletter['Newsletter']['title']?>)
						</a>
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
						<span class="badge is-rounded"><?=count($newsletter['NewsletterSchedule'])?></span>
					</td>
					<td>
						<div class="d-flex flex-center flex-nowrap gap-05">        
							<!--a 
								href="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'edit', $newsletter['Newsletter']['id']))?>" 
								data-toggle="tooltip" 
								title="Editar plantilla" 
								class="btn btn-success" 
							>
								<i class="gi gi-edit"></i>
							</a-->
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

							<!--a 
								 href="<?=$this->Html->url(array('action'=>'newsletters', 'schedules', $newsletter['Newsletter']['id']))?>" 
								data-toggle="tooltip" 
								title="Programar envío" 
								class="btn btn-warning" 
							>
								<i class="gi gi-send"></i>
							</a-->
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
    <button class="btn" type="button">Ver todo</button>
  </a>
<?php else: ?>
	<a href="/admin/newsletters/templates">
    <button class="btn" type="button">Ver menos</button>
  </a>
<?php endif ?>
	  <a class="btn btn-info dropdown-toggle" href="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'edit'))?>">
	    <i class="gi gi-magic mr-1"></i> Crear Plantilla
	  </a>
  </div>