<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<div class="block block-themed">
	<div class="block-title">
		<h4>Shop - Opciones</h4>
	</div>

	<div class="block-content">
		<form action="<?php echo Router::url(array('action'=>'products_settings')) ?>" method="POST" style="width:100%;">
			<div style="display:inline;">
				<label class="" for="columns-text">Stock Mínimo:</label>
				<input type="number" name="stock_min" value="<?php echo @$stock_min ?>" required style="width:60px;text-align:center"/>
			</div>
			&nbsp;
			&nbsp;
			&nbsp;
			&nbsp;
			<div style="display:inline;">
				<label class="" for="columns-text">Código de Lista:</label>
				<input type="number" name="list_code" value="<?php echo @$list_code ?>" required style="width:60px;text-align:center"/>
			</div>
			&nbsp;
			&nbsp;
			&nbsp;
			&nbsp;
			<div style="display:inline;">
				<label class="" for="columns-text">Mostrar Shop </label>
				<input type="checkbox" class="input-themed" name="show_shop" value="<?php echo @$show_shop ?>" <?php echo (!empty($show_shop))?'checked':''; ?>/>
			</div>
			&nbsp;
			&nbsp;
			&nbsp;
			&nbsp;
			<button class="btn btn-sm" type="submit" style="margin-top: -2px;">Guardar</button>
			<br />
		</form>
	</div>
</div>
<?php echo $this->element('admin-menu'); ?>
<div class="block-section">
	<table id="example-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th class="text-center hidden-phone"><?php echo __('Nombre'); ?></th>
				<th class="text-center hidden-phone"><?php echo __('Descripcion'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Imagen'); ?></th>
				<th class="text-center hidden-phone"><?php echo __('Precio'); ?></th>
				<th class="text-center hidden-phone"><?php echo __('Nro de Articulo'); ?></th>
				<th class="text-center hidden-phone"><?php echo __('Categoria'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($prods as $key => $product): ?>        
				<tr>
					<td>
						<a href="<?=$this->Html->url(array('action'=>'productos','edit',$product['Product']['id']))?>">
							<?=$product['Product']['name']?>
						</a>
					</td>
					<td>
						<?=$product['Product']['desc']?>
					</td>
					<td>          
						<?php
							echo "<a target='_new' class='badge badge-inverse' href='". $this->webroot . 'files/uploads/' . $product['Product']['img_url'] ."''>LINK</a>";
						?>     
					</td>
					<td>
						<?=$product['Product']['price']?>
					</td>
					<td>
						<?=$product['Product']['article']?>
					</td>
					<td>
						<?=$product['Product']['category_id']?>
					</td>
					<td>
						<div class="btn-group">   
							<a 
							href="<?=$this->Html->url(array('action'=>'productos','edit',$product['Product']['id']))?>" 
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
						data-id="<?=$product['Product']['id']?>" 
						data-url-back="<?=$this->Html->url(array('action'=>'productos'))?>" 
						data-delurl="<?=$this->Html->url(array('action'=>'productos', 'delete'))?>" 
						data-msg="<?=__('¿Eliminar producto?')?>"                   
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