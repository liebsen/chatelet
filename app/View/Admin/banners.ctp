<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->element('admin-menu'); ?>
<?php echo $this->Html->css('draggable-table', array('inline' => false));?>
<?php echo $this->Html->script('draggable-table', array('inline' => false));?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
<div class="block-section">
	<table id="banners-datatables" class="table table-bordered table-hover table-condensed draggable-table" data-url="/admin/ordernum/banner">
		<thead>
			<tr>
				<th class="hidden-phone hidden-tablet"><?php echo __('Banner'); ?></th>    
				<th class="hidden-phone hidden-tablet"><?php echo __('Enlace'); ?></th>    
				<th class="hidden-phone hidden-tablet"><?php echo __('Imagen'); ?></th>    
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($banners as $key => $banner): ?>
				<tr data-id="<?= $banner['Banner']['id'] ?>" data-order="<?= $banner['Banner']['ordernum'] ?>">
					<td>
						<a href="<?=$this->Html->url(array('action'=>'banners','edit',$banner['Banner']['id']))?>">
							<?=$banner['Banner']['title']?>
						</a>
					</td>
					<td>
						<a href="<?=$this->Html->url(array('action'=>'banners','edit',$banner['Banner']['id']))?>">
							<?=$banner['Banner']['href']?>
						</a>
					</td>
					<td>          
						<?php
							if(!empty($banner['Banner']['img_url'])){
								echo "<a target='_new' class='badge badge-inverse' href='". Configure::read('imageUrlBase') . $banner['Banner']['img_url'] ."''>LINK</a>";
							}
						?>     
					</td> 
					<td>
						<div class="btn-group">   
							<a 
							href="<?=$this->Html->url(array('action'=>'banners','edit',$banner['Banner']['id']))?>" 
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
						data-id="<?=$banner['Banner']['id']?>" 
						data-url-back="<?=$this->Html->url(array('action'=>'banners'))?>" 
						data-delurl="<?=$this->Html->url(array('action'=>'banners', 'delete'))?>" 
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