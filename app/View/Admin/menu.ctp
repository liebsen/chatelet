<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->element('admin-menu'); ?>
<?php echo $this->Html->css('draggable-table', array('inline' => false));?>
<?php echo $this->Html->script('draggable-table', array('inline' => false));?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
<div class="block-section">
	<table id="menu-datatables" class="table table-bordered table-hover table-condensed draggable-table" data-url="/admin/ordernum/banner">
		<thead>
			<tr>
				<th class="hidden-phone hidden-tablet">&nbsp;</th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Menu'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Categoría'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Texto'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($menu as $key => $menu): ?>
				<tr data-id="<?= $menu['Menu']['id'] ?>" data-order="<?= $menu['Menu']['ordernum'] ?>">
					<td>
						<?=$menu['Menu']['enabled'] ? '<i class="gi gi-check fa-lg text-success"></i>' : '<i class="gi gi-unchecked fa-lg text-danger"></i>'?>
					</td>
					<td>
						<a href="<?=$this->Html->url(array('action'=>'menu','edit',$menu['Menu']['id']))?>">
							<?=$menu['Menu']['title']?>
						</a>
					</td>
					<td>
						<a href="<?=$this->Html->url(array('action'=>'menu','edit',$menu['Menu']['id']))?>">
							<?=$menu['Menu']['category_name']?>
						</a>
					</td>
					<td>          
						<?=$menu['Menu']['text']?>   
					</td> 
					<td>
						<div class="btn-group">   
							<a 
							href="<?=$this->Html->url(array('action'=>'menu','edit',$menu['Menu']['id']))?>" 
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
						data-id="<?=$menu['Menu']['id']?>" 
						data-url-back="<?=$this->Html->url(array('action'=>'menu'))?>" 
						data-delurl="<?=$this->Html->url(array('action'=>'menu', 'delete'))?>" 
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