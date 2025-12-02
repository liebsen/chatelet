<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->element('admin-menu'); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
<div class="block-section table-responsive">
	<table id="usuarios-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th class="text-center hidden-phone"><?php echo __('Email'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Nombre y apellido'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Fecha de nacimiento'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Sexo'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('DNI'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Newsletter'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Telefono'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Direccion'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Provincia'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Ciudad'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($users as $key => $user): ?>        
				<tr>
					<td>
						<a href="<?=$this->Html->url(array('action'=>'usuarios','edit',$user['User']['id']))?>">
							<?=$user['User']['email']?>
						</a>
					</td>	                 
					<td>          
						<?=$user['User']['name']. ' ' .$user['User']['surname']?>
					</td>
					<td>          
						<?=
							$this->Time->format($user['User']['birthday'], '%d/%m/%Y')
						?>
					</td>
					<td>          
						<?=
							($user['User']['gender'] == 'M') ? 'Masculino' : 'Femenino'
						?>
					</td> 
					<td>          
						<?=$user['User']['dni']?>
					</td> 
					<td>          
						<?=
							($user['User']['name']) ? 'Si' : 'No'
						?>
					</td> 
					<td>          
						<?=$user['User']['telephone']?>
					</td> 
					<td>          
						<?=$user['User']['address']?>
					</td> 
					<td>          
						<?=$user['User']['province']?>
					</td> 
					<td>          
						<?=$user['User']['city']?>
					</td> 
					<td>
						<div class="btn-group">   
							<a 
							href="<?=$this->Html->url(array('action'=>'usuarios','edit',$user['User']['id']))?>" 
							data-toggle="tooltip" 
							title="" 
							class="btn btn-success" 
							data-original-title="Editar">
							<i class="gi gi-pencil"></i>
						</a>             
						<a 
						href="#" 
						data-toggle="tooltip" 
						title="" 
						class="btn btn-danger deletebutton" 
						data-original-title="Eliminar" 
						data-id="<?=$user['User']['id']?>" 
						data-url-back="<?=$this->Html->url(array('action'=>'usuarios'))?>" 
						data-delurl="<?=$this->Html->url(array('action'=>'usuarios', 'delete'))?>" 
						data-msg="<?=__('¿Eliminar usuario?')?>"                   
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