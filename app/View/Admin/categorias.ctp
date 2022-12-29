<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->element('admin-menu'); ?>
<?php echo $this->Html->css('draggable-table', array('inline' => false));?>
<?php echo $this->Html->script('draggable-table', array('inline' => false));?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
<div class="block-section">
	<table id="categorias-datatables" class="table table-bordered table-hover table-condensed draggable-table" data-url="/admin/ordernum/category">
		<thead>
			<tr>
				<th class="text-center hidden-phone"><?php echo __('Nombre'); ?></th>        
				<th class="hidden-phone hidden-tablet"><?php echo __('Ancho'); ?></th> 
				<th class="hidden-phone hidden-tablet"><?php echo __('Imagen'); ?></th>    
				<th class="hidden-phone hidden-tablet"><?php echo __('Talle'); ?></th>    
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($cats as $key => $category): ?>
			<tr data-id="<?= $category['Category']['id'] ?>" data-order="<?= $category['Category']['ordernum'] ?>">
				<td>
					<a href="<?=$this->Html->url(array('action'=>'categorias','edit',$category['Category']['id']))?>">
						<?=$category['Category']['name']?>
					</a>
				</td>
				<td>
					<?php if(empty(@$category['Category']['colsize'])) echo 'Auto' ?>
					<?php if(@$category['Category']['colsize'] == '20') echo '20%' ?>
					<?php if(@$category['Category']['colsize'] == '3') echo '25%' ?>
					<?php if(@$category['Category']['colsize'] == '4') echo '33%' ?>
					<?php if(@$category['Category']['colsize'] == '40') echo '40%' ?>
					<?php if(@$category['Category']['colsize'] == '6') echo '50%' ?>
					<?php if(@$category['Category']['colsize'] == '60') echo '60%' ?>
					<?php if(@$category['Category']['colsize'] == '80') echo '80%' ?>
					<?php if(@$category['Category']['colsize'] == '12') echo '100%' ?>
				</td>
				<td>          
					<?php
						if(!empty($category['Category']['img_url'])){
							echo "<a target='_new' class='badge badge-inverse' href='". Configure::read('imageUrlBase') . $category['Category']['img_url'] ."''>LINK</a>";
						}
					?>     
				</td> 
				<td>          
					<?php
						if(!empty($category['Category']['size'])){
							echo "<a target='_new' class='badge badge-inverse' href='". Configure::read('imageUrlBase') . $category['Category']['size'] ."''>LINK</a>";
						}
					?>     
				</td>
				<td>
					<div class="btn-group">
						<a 
							href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($category['Category']['name'])))); ?>"
							data-toggle="tooltip" 
							title="" 
							target="_blank"
							class="btn btn-sm btn-info" 
							data-original-title="Editar">
							<i class="fa fa-eye"></i>
						</a> 
						<a 
							href="<?=$this->Html->url(array('action'=>'categorias','edit',$category['Category']['id']))?>" 
							data-toggle="tooltip" 
							title="" 
							class="btn btn-sm btn-success" 
							data-original-title="Editar">
							<i class="gi gi-pencil"></i>
						</a>             
						<a 
							href="#" 
							data-toggle="tooltip" 
							title="" 
							class="btn btn-sm btn-danger deletebutton" 
							data-original-title="Eliminar" 
							data-id="<?=$category['Category']['id']?>" 
							data-url-back="<?=$this->Html->url(array('action'=>'categorias'))?>" 
							data-delurl="<?=$this->Html->url(array('action'=>'categorias', 'delete'))?>" 
							data-msg="¿Eliminar categoria? Precación: Se borraran los productos que esten contenidos en esta categoria.">
							<i class="gi gi-remove"></i>
						</a>
					</div> 
				</td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
</div>