<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->element('admin-menu'); ?>
<?php echo $this->Html->css('draggable-table', array('inline' => false));?>
<?php echo $this->Html->script('draggable-table', array('inline' => false));?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
<div class="block-section">
	<table id="legends-datatables" class="table table-bordered table-hover table-condensed draggable-table" data-url="/admin/ordernum/legend">
		<thead>
			<tr>
				<th class="hidden-phone hidden-tablet">&nbsp;</th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Leyenda'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Cuotas'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Interés'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Monto min'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($legends as $key => $legend): ?>
				<tr data-id="<?= $legend['Legend']['id'] ?>" data-order="<?= $legend['Legend']['ordernum'] ?>">
					<td>
						<?=$legend['Legend']['enabled'] ? '<i class="gi gi-check fa-lg text-success"></i>' : '<i class="gi gi-unchecked fa-lg text-danger"></i>'?>
					</td>
					<td>
						<a href="<?=$this->Html->url(array('action'=>'legends','edit',$legend['Legend']['id']))?>">
							<?=$legend['Legend']['title']?>
						</a>
					</td>
					<td>
						<a href="<?=$this->Html->url(array('action'=>'legends','edit',$legend['Legend']['id']))?>">
							<?=$legend['Legend']['dues']?>
						</a>
					</td>
					<td>
						<a href="<?=$this->Html->url(array('action'=>'legends','edit',$legend['Legend']['id']))?>">
							<?=$legend['Legend']['interest']?>%
						</a>
					</td>
					<td>
						<a href="<?=$this->Html->url(array('action'=>'legends','edit',$legend['Legend']['id']))?>">
							$<?=intval($legend['Legend']['min_sale'])?>
						</a>
					</td>
					<td>
						<div class="btn-group">   
							<a 
							href="<?=$this->Html->url(array('action'=>'legends','edit',$legend['Legend']['id']))?>" 
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
						data-id="<?=$legend['Legend']['id']?>" 
						data-url-back="<?=$this->Html->url(array('action'=>'legends'))?>" 
						data-delurl="<?=$this->Html->url(array('action'=>'legends', 'delete'))?>" 
						data-msg="¿Eliminar leyenda?"
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