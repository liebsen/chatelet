<?php 
	echo $this->element('admin-menu');
	echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));
	echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));
	echo $this->Html->script('admin-delete', array('inline' => false));
?>
<div class="block-section table-responsive">
	<table id="contacto-datatables" class="table table-bordered table-hover"  width="100%">
		<thead>
			<tr>
				<th class="text-center hidden-phone"><?php echo __('Fecha'); ?></th>  
				<th class="text-center hidden-phone"><?php echo __('Nombre'); ?></th>  
				<th class="hidden-phone hidden-tablet"><?php echo __('Email'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Telefono'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Mensaje'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('¿Particular o comerciante?'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($contacts as $key => $contact): ?>        
				<tr>
					<td>
						<?php echo date('d/m/Y',strtotime($contact['Contact']['created'])) ?>
					</td>
					<td>
						<?=$contact['Contact']['name']?>
					</td>	                 
					<td>
						<?=$contact['Contact']['email']?>
					</td>
					<td>
						<?=$contact['Contact']['telephone']?>
					</td>
					<td>
						<?=$contact['Contact']['message']?>
					</td>
					<td>
						<?=ucfirst($contact['Contact']['client_type'])?>
					</td>
					<td>            
						<a 
						href="#" 
						data-toggle="tooltip" 
						title="" 
						class="btn btn-danger deletebutton" 
						data-original-title="Eliminar" 
						data-id="<?=$contact['Contact']['id']?>" 
						data-url-back="<?=$this->Html->url(array('action'=>'contacto'))?>" 
						data-delurl="<?=$this->Html->url(array('action'=>'contacto', 'delete'))?>" 
						data-msg="<?=__('¿Eliminar mensaje?')?>"                   
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