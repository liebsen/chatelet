<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>

<?php echo $this->element('admin-menu'); ?>
<div class="block-section">
	<table id="example-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
			    <th class="hidden-phone hidden-tablet"><?php echo __('Imagen'); ?></th>
				<th class="text-center hidden-phone"><?php echo __('Descripcion'); ?></th>
				<th class="text-center hidden-phone"><?php echo __('Articulo'); ?></th>
			 	<th class="text-center hidden-phone"><?php echo __('Id Producto'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($lookb as $key => $lookbook): ?>    
				<tr>
					<td>          
						<?php
							echo "<a target='_new' class='badge badge-inverse' href='". Configure::read('uploadUrl') . $lookbook['LookBooks']['img_url'] ."''>LINK</a>";
						?>     
					</td>
					<td>
			      		<?=$lookbook['LookBooks']['name']?>
						
					</td>
					<td>
						<?=$lookbook['LookBooks']['article']?>
					</td>
					<td>
						<?=$lookbook['LookBooks']['product_id']?>
					</td>
					<td>
						<div class="btn-group">   
							<a
							href="#" 
							data-toggle="tooltip" 
							title="" 
							class="btn btn-xs btn-danger deletebutton" 
							data-original-title="Eliminar" 
							data-id="<?=$lookbook['LookBooks']['id']?>" 
							data-url-back="<?=$this->Html->url(array('action'=>'lookbook'))?>" 
							data-delurl="<?=$this->Html->url(array('action'=>'lookbook', 'delete'))?>" 
							data-msg="<?=__('¿Eliminar Look Book?')?>" >
							<i class="gi gi-remove"></i>
							</a>
						</div> 
		        	</td>
		        </tr>
		    <?php endforeach ?>
		</tbody>
	</table>
</div>