<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->element('admin-menu'); ?>
<div class="block-section">
	<table id="example-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th class="text-center hidden-phone"><?php echo __('Nombre'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Dirección'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Telefono'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('¿Por mayor?'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Local'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Coordenadas'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($stores as $key => $store): ?>        
				<tr>
					<td>
						<a href="<?=$this->Html->url(array('action'=>'sucursales','edit',$store['Store']['id']))?>">
							<?=$store['Store']['name']?>
						</a>
					</td>	                 
					<td>
						<?=$store['Store']['address']?>
					</td>
					<td>
						<?=$store['Store']['phone']?>
					</td>
					<td>
						<?=
							($store['Store']['por_mayor']) ? 'Si' : 'No'
						?>
					</td>
					<td>
						<?=$store['Store']['local']?>
					</td>
					<td>
						<?=$store['Store']['lat'] . ' - '  .$store['Store']['lng']?>
					</td>
					<td>
						<div class="btn-group">   
							<a 
							href="<?=$this->Html->url(array('action'=>'sucursales','edit',$store['Store']['id']))?>" 
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
						data-id="<?=$store['Store']['id']?>" 
						data-url-back="<?=$this->Html->url(array('action'=>'sucursales'))?>" 
						data-delurl="<?=$this->Html->url(array('action'=>'sucursales', 'delete'))?>" 
						data-msg="<?=__('¿Eliminar sucursal?')?>"                   
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