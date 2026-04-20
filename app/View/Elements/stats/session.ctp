<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->Html->script('schedules', array('inline' => false)); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
	<table id="example-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
     		<th class="hidden-phone hidden-tablet"><?php echo __('#'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Evento'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Usuario'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Fecha/Hora'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
<?php foreach ($items as $key => $item): ?>        
			<tr class="bg-<?=$schedule['rowclass']?> schedules-<?=$schedule['NewsletterSchedule']['id']?>">
				<td>
					<span class="badge badge-light">
						<?=$item['Stat']['id']?>
					</span>
				</td>
				<td>
					<span class="badge badge-light">
						<?=$item['Stat']['tag']?>
					</span>
				</td>
				<td>
					<span class="badge badge-success">
						<?=$item['User']['name']?> <?=$item['User']['surname']?>
					</span>
				</td>
				<td>
					<span class="badge badge-light" title="Fecha / Hora">
					<?=$this->Time->format($item['Stat']['created'], '%d/%m/%Y %H:%M') ?> </span> 
					<span class="badge is-rounded" title="Fecha / Hora de ejecución">
					<?=\readable_time_ago(strtotime($item['Stat']['created'])) ?> </span>
				</td>
				<td> 
					<!--div class="btn-group">           
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
							<i class="gi gi-group"></i>
						</a>						
					</div-->
				</td>
			</tr>
<?php endforeach ?>
		</tbody>
	</table>