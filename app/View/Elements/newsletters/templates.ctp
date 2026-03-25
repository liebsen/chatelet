<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>

	<table id="example-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Plantilla'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Productos'); ?></th>
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
						<?=$newsletter['Newsletter']['title']?> (<?=$newsletter['Newsletter']['name']?>)
					</a>
				</td>
				<td>
					<?=count($newsletter['NewsletterProduct'])?>
				</td>
				<td>
					<?=count($newsletter['NewsletterSchedule'])?>
				</td>
				<td>            
					<a 
						href="#" 
						data-toggle="tooltip" 
						title="" 
						class="btn btn-danger deletebutton" 
						data-original-title="Eliminar" 
						data-id="<?=$newsletter['Newsletter']['id']?>" 
						data-url-back="<?=$this->Html->url(array('action'=>'newsletters'))?>" 
						data-delurl="<?=$this->Html->url(array('action'=>'newsletters', 'delete'))?>" 
						data-msg="<?=__('¿Eliminar Newsletter?')?>"                   
					>
						<i class="fa fa-trash-o"></i>
					</a>
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
				</td>
			</tr>
<?php endforeach ?>
		</tbody>
	</table>
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
	  <a class="btn btn-success dropdown-toggle" href="<?=$this->Html->url(array('action'=>'newsletters', 'templates', 'edit'))?>">
	    <i class="gi gi-edit mr-1"></i> Crear Plantilla
	  </a>
  </div>