<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->element('admin-menu'); ?>
<?php echo $this->Html->css('draggable-table', array('inline' => false));?>
<?php echo $this->Html->script('draggable-table', array('inline' => false));?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
<div class="block-section">
	<table id="admin_menu-datatables" class="table table-bordered table-hover table-condensed draggable-table" data-url="/admin/ordernum/admin_menu">
		<thead>
			<tr>
				<th class="hidden-phone hidden-tablet"><?php echo __('Icon'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Nombre'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('URL'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($adminMenu as $key => $menu): ?>
				<tr data-id="<?= $menu['id'] ?>" data-order="<?= $menu['ordernum'] ?>">
					<td width="1%" class="text-center">
						<i class="<?=$menu['icon']?> fa-lg text-success"></i>
					</td>
					<td>
						<a href="<?=$this->Html->url(array('action'=>'admin_menu','edit',$menu['id']))?>">
							<?=$menu['name']?>
						</a>
					</td>
					<td>
						<i class="gi gi-link fa-lg text-success"></i>
						<?=$menu['url'] ?>
					</td>
					<td>
						<div class="btn-group">   
							<a 
							href="<?=$this->Html->url(array('action'=>'admin_menu','edit',$menu['id']))?>" 
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
						data-id="<?=$menu['id']?>" 
						data-url-back="<?=$this->Html->url(array('action'=>'admin_menu'))?>" 
						data-delurl="<?=$this->Html->url(array('action'=>'admin_menu', 'delete'))?>" 
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