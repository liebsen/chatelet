<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>

	<table id="example-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Código'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Título'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Estado'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Fecha/Hora'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
<?php foreach ($schedules as $key => $schedule): ?>        
			<tr class="<?=isset($schedule['NewsletterSchedule']['recent'])?'bg-selected':''?>">
				<td>
					<?=$schedule['Newsletter']['name']?>
				</td>
				<td>
					<?=$schedule['Newsletter']['title']?>
				</td>
				<td>
					<?=$schedule['Newsletter']['status']??'waiting'?>
				</td>
				<td>
					<?=$schedule['NewsletterSchedule']['schedule_date']??''?> - <?=$schedule['NewsletterSchedule']['schedule_hour']??'0'?>hs
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
						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'emails', 'edit', $schedule['Newsletter']['id']))?>" 
							data-toggle="tooltip" 
							title="Editar email" 
							class="btn btn-success" 
							>
							<i class="gi gi-edit"></i>
						</a>
						<a 
							href="<?=$this->Html->url(array('action'=>'newsletters', 'schedules', 'edit', $schedule['NewsletterSchedule']['id']))?>" 
							data-toggle="tooltip" 
							title="Programar envío" 
							class="btn btn-warning" 
							>
							<i class="gi gi-send"></i>
						</a>
					</div>
				</td>
			</tr>
<?php endforeach ?>
		</tbody>
	</table>

	<div class="form-actions">
		<a href="/admin/newsletters?extended=1">
	    <button class="btn" type="button">Ver todo</button>
	  </a>
	  <a class="btn btn-success dropdown-toggle" href="<?=$this->Html->url(array('action'=>'newsletters', 'schedules', 'edit'))?>">
	    <i class="gi gi-clock mr-1"></i> Programar envío
	  </a>
	</div>