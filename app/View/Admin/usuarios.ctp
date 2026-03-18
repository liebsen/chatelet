<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->Html->css('	', array('inline' => false));?>
<?php echo $this->element('admin-menu'); ?>
<div class="block-section table-responsive">
	<table id="usuarios-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th class="text-center hidden-phone"><?php echo __('ID'); ?></th>
				<th class="text-center hidden-phone"><?php echo __('Email'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Nombre'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('FNAC'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Sexo'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('DNI'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Newsletter'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Rol'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Tel'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Dir'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Prov'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Ciudad'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($users as $key => $user): ?>        
				<tr>
					<td>          
						<?=$user['User']['id']?>
					</td>
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
							($user['User']['gender'] == 'M') ? '<i class="gi gi-user text-info"></i>' : '<i class="gi gi-woman text-warning"></i>'
						?>
					</td> 
					<td>          
						<?=$user['User']['dni']?>
					</td> 
					<td>          
						<?=
							($user['User']['newsletter']) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-close text-danger"></i>'
						?>
					</td> 
					<td>          
						<span class="badge badge-lg badge-info"><?=$user['User']['role']?></span>
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
							<i class="fa fa-edit"></i>
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
						<i class="fa fa-trash-o"></i>
					</a>
				</div> 
			</td>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>
</div>