<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->element('admin-menu'); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>

<div class="block-section table-responsive">
	<table id="logistica-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th class="hidden-phone hidden-tablet"><?php echo __('Nombre'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Alcance'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Activo'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($logistics as $key => $logistic): ?>        
				<tr>
					<td>
						<?=$logistic['Logistic']['title']?>
					</td>
					<td>
						<?= isset($logistic['Logistic']['local_prices']) && $logistic['Logistic']['local_prices'] ? 'Local' : 'Nacional'?>
					</td>
					<td>
						<?=$logistic['Logistic']['enabled'] ? '<i class="gi gi-check fa-lg text-success"></i>' : '<i class="gi gi-unchecked fa-lg text-danger"></i>'?>
					</td>
					<td>
						<div class="btn-group">   
							<a 
							href="<?=$this->Html->url(array('action'=>'logistica','edit',$logistic['Logistic']['id']))?>" 
							data-toggle="tooltip" 
							title="" 
							class="btn btn-xs btn-success" 
							data-original-title="Editar">
							<i class="gi gi-pencil"></i>
						</a>             
						<a 
						href="#" 
						data-toggle="tooltip" 
						title="" 
						class="btn btn-xs btn-danger deletebutton" 
						data-original-title="Eliminar" 
						data-id="<?=$logistic['Logistic']['id']?>" 
						data-url-back="<?=$this->Html->url(array('action'=>'logistica'))?>" 
						data-delurl="<?=$this->Html->url(array('action'=>'logistica', 'delete'))?>" 
						data-msg="<?=__('¿Eliminar logística?')?>"                   
						>
						<i class="gi gi-remove"></i>
					</a>
				</div> 
			</td>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>
</div>