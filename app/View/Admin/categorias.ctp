<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->element('admin-menu'); ?>
<div class="block-section">
	<table id="example-datatables" class="table table-bordered table-hover table-condensed">
		<thead>
			<tr>
				<th class="text-center hidden-phone"><?php echo __('Nombre'); ?></th>        
				<th class="hidden-phone hidden-tablet"><?php echo __('Imagen'); ?></th>    
				<th class="hidden-phone hidden-tablet"><?php echo __('Talle'); ?></th>    
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($cats as $key => $category): ?>        
				<tr>
					<td>
						<a href="<?=$this->Html->url(array('action'=>'categorias','edit',$category['Category']['id']))?>">
							<?=$category['Category']['name']?>
						</a>
					</td>	                 
					<td>          
						<?php
							if(!empty($category['Category']['img_url'])){
								echo "<a target='_new' class='badge badge-inverse' href='". $this->webroot . 'files/uploads/' . $category['Category']['img_url'] ."''>LINK</a>";
							}
						?>     
					</td> 
					<td>          
						<?php
							if(!empty($category['Category']['size'])){
								echo "<a target='_new' class='badge badge-inverse' href='". $this->webroot . 'files/uploads/' . $category['Category']['size'] ."''>LINK</a>";
							}
						?>     
					</td> 
					<td>
						<div class="btn-group">   
							<a 
							href="<?=$this->Html->url(array('action'=>'categorias','edit',$category['Category']['id']))?>" 
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
						data-id="<?=$category['Category']['id']?>" 
						data-url-back="<?=$this->Html->url(array('action'=>'categorias'))?>" 
						data-delurl="<?=$this->Html->url(array('action'=>'categorias', 'delete'))?>" 
						data-msg="¿Eliminar categoria? Precación: Se borraran los productos que esten contenidos en esta categoria."                   
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