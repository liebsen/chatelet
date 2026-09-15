<?php 
$start_stock_product = $this->Session->consume('StartStockProduct');
$this->Html->script('handlebars-v2.0.0',array('block' => 'script'));
$this->Html->script('image_prodshop', array('block' => 'script')); 
$this->Html->script('admin-delete', array('block' => 'script')); 
$this->Html->script('admin-checklist.js?v=' . $version['ver'], array('block' => 'script'));
$this->Html->script('productos.js?v=' . $version['ver'], array('block' => 'script'));
$this->Html->css('draggable-table', array('block' => 'css'));
$this->Html->script('draggable-table', array('block' => 'script'));
$this->Html->css('/Vendor/DataTables/datatables.min.css', array('block' => 'css'));
$this->Html->script('/Vendor/DataTables/datatables.min.js', array('block' => 'script'));
//echo $this->element('admin/menu');
?>

<?php if(!empty($start_stock_product)):?>
	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function() {
			var stock_id = '<?=$start_stock_product?>';
	  	const btn = $('#update_stock_'+stock_id)
	  	if(btn.length) {
		  	const icon = btn.find('i').first()
		    var id = btn.attr('data-id'),
			  	url = btn.attr('data-url'),
			  	title = btn.attr('data-title'),
			  	text = btn.attr('data-text');
		  	start_stock_sync(url, id, title, btn, icon)
		  }
	  })
  </script>
<?php endif ?>

<p class="collapse alert alert-success result-message">...</p>

<div class="block-section table-responsive">
	<table id="example-datatables" class="table table-bordered draggable-table" data-url="/admin/ordernum/product">
		<thead>
			<tr>
				<th class="text-center hidden-phone"><input type="checkbox" name="checksAll" /></th>
				<th class="text-center hidden-phone"><?php echo __('Nombre'); ?></th>
				<th class="text-center hidden-phone"><?php echo __('Descripción'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Imagen'); ?></th>
				<th class="text-center hidden-phone"><?php echo __('Precio'); ?></th>
				<th class="text-center hidden-phone"><?php echo __('Artículo'); ?></th>
				<th class="text-center hidden-phone"><?php echo __('Categoría'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($prods as $key => $product): ?>        
				<tr data-id="<?= $product['Product']['id'] ?>" data-order="<?= $product['Product']['ordernum'] ?>" class="<?= $product['Product']['visible'] == '1' ? '' : 'bg-danger'?>">
					<td align="center">
						<input type="checkbox" name="checks" value="<?= $product['Product']['id']?>" />
					</td>
					<td>
						<a href="<?=$this->Html->url(array('action'=>'productos','edit',$product['Product']['id']))?>">
							<?=$product['Product']['name']?>
						</a>
					</td>
					<td>
						<?=\word_limit($product['Product']['desc'])?>
					</td>
					<td>          
						<?php
							echo "<a target='_new' class='badge badge-inverse' href='". $settings['upload_url'] . $product['Product']['img_url'] ."''>LINK</a>";
						?>     
					</td>
					<td>
						<span class="<?= !empty($product['Product']['discount']) && $product['Product']['discount'] !== $product['Product']['price'] ? 'text-success' : 'text-dark' ?>"><?=str_replace(',00','',$this->Number->currency(ceil($product['Product']['discount'] ? $product['Product']['discount'] : $product['Product']['price']), 'ARS', array('places' => 2)))?>
						</span>
					</td>
					<td>
						<span class="badge badge-success"><?=$product['Product']['article']?></span>
					</td>
					<td>
						<?=$product['Category']['name']?>
					</td>
					<td>
						<div class="btn-group d-flex flex-nowrap">
							<a 
								id="update_stock_<?=$product['Product']['id']?>"
								href="javascript:void(0)" 
								data-toggle="tooltip" 
								title="Actualizar Stock" 
								class="btn btn-success update-stock"
								data-id="<?=$product['Product']['id']?>" 
								data-title="<?=$product['Product']['name']?>"
								data-text="¿Estas seguro que deseas actualizar el stock de este producto?"
								data-url="/admin/update_product_stock"
								data-original-title="Actualizar Stock">
								<i class="fa fa-refresh"></i>
							</a>
							<a 
								href="<?=$this->Html->url(array('action'=>'productos','edit',$product['Product']['id']))?>" 
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
								data-id="<?=$product['Product']['id']?>" 
								data-url-back="<?=$this->Html->url(array('action'=>'productos'))?>" 
								data-delurl="<?=$this->Html->url(array('action'=>'productos', 'delete'))?>" 
								data-msg="<?=__('¿Eliminar producto?')?>">
								<i class="fa fa-trash-o"></i>
							</a>
						</div> 
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
  <div class="form-actions" data-url="/admin/batch_productos/">
  	<div class="hide selection-block">
		  <span class="selection-count"></span>	
		  <button class="enableselection btn btn-success btn-adjust" type="button">
		  	<i class="fa fa-eye"></i>
		  	<span>Activar</span>
		  </button>
		  <button class="disableselection btn btn-warning btn-adjust" type="button">
		  	<i class="fa fa-eye-slash"></i>
		  	<span>Desactivar</span>
		  </button>
		  <button class="removeselection btn btn-danger btn-adjust" type="button">
		  	<i class="fa fa-trash-o"></i>
		  	<span>Eliminar</span>
		  </button>
		</div>
  	<a class="btn btn-success" href="/admin/productos/config">
  		<i class="fa fa-cog"></i> <span class="ml-1">Opciones</span>
  	</a>
  	<a class="btn btn-success" href="/admin/productos/add">
  		<i class="fa fa-magic"></i> <span class="ml-1">Nuevo</span>
  	</a>
	</div>
</div>