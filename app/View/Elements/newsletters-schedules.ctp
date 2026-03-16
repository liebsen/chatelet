
	<table id="example-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Título'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Estado'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($schedules as $key => $schedule): ?>        
				<tr>
					<td>
						<?=$schedule['Newsletter']['title']?>
					</td>
					<td>
						<?=$schedule['Newsletter']['status']??'waiting'?>
					</td>
					<td>            
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
						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'schedules', 'edit', $schedule['NewsletterSchedule']['id']))?>" 
							data-toggle="tooltip" 
							title="Programar envío" 
							class="btn btn-success" 
							>
							<i class="gi gi-edit"></i>
						</a>
						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'emails', 'edit', $schedule['Newsletter']['id']))?>" 
							data-toggle="tooltip" 
							title="Editar email" 
							class="btn btn-warning" 
							>
							<i class="gi gi-envelope"></i>
						</a>
				</td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>

	<div class="form-actions">
		<a href="/admin/newsletters?extended=1">
	    <button class="btn" type="button">Ver todo</button>
	  </a>
	  <a class="btn btn-success dropdown-toggle" href="<?=$this->Html->url(array('action'=>'newsletters', 'schedule', 'create'))?>">
	    <i class="gi gi-clock mr-1"></i> Programar envío
	  </a>
	</div>