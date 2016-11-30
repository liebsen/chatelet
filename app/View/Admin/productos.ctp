<?php 
 echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false));
 echo $this->Html->script('image_prodshop', array('inline' => false)); 
 echo $this->Html->script('admin-delete', array('inline' => false)); 

?>
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
		
			<div style="display:inline;">
				<label class="" for="columns-text">Código de Lista:</label>
				<input type="number" name="list_code" value="<?php echo @$list_code ?>" required style="width:60px;text-align:center"/>
			</div>
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
	
			
			<div style="display:inline;">
				<label class="" for="columns-text">Banner Shop 

				<div class="row">
					<div class="col-xs-12">
						<div class="control-group"> 
							<label class="control-label" for="columns-text">Imagen: <span class="counter">0</span>%</label>
							<div class="controls">                          
								<input type="file" id="upload" data-input="[name='image_bannershop']" data-count=".counter" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
						    <input type="hidden" name="image_bannershop" value="<?php echo (!empty( @$image_bannershop )) ? @$image_bannershop : null ; ?>" /> <?php echo (!empty( @$image_bannershop )) ? "<a target='_new' class='badge badge-inverse' href='". $this->webroot . 'files/uploads/'.@$image_bannershop."''>VER IMAGEN ACTUAL</a>" : null; ?> 
							</div>
						</div>
						<br />
						<div class="control-group">
							<label class="control-label" for="columns-text"></label>
							<div class="controls">
								<script id="image_thumb" type="text/x-handlebars-template" data-url="<?php echo $this->webroot . 'files/uploads/' ?>">
									<span style="margin-top:10px;margin-bottom:10px;">	
										<img src="{{image}}" width="100"/> 
										<a href="#" class="delete_image" data-input="[name='image_bannershop']" data-file="{{file}}">X</a>
									</span>
								</script>
								<span id="images">
								</span>
							</div>
						</div>
					</div>
				</div></label>
            </div>
            &nbsp;
			&nbsp;
			&nbsp;
			
            <div style="display:inline;">
				<label class="" for="columns-text">Menu Shop 
				<div class="row">
				<div class="col-xs-12">                                       
					<div class="control-group"> 
						<label class="control-label" for="columns-text">Imagen: <span class="counter_two">0</span>%</label>
						<div class="controls">
							<input type="file" id="uploadkari" data-input="[name='image_menushop']" data-count=".counter_two" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
					    <input type="hidden" name="image_menushop" value="<?php echo (!empty( @$image_menushop )) ? @$image_menushop : null ; ?>" /> <?php echo (!empty( @$image_menushop )) ? "<a target='_new' class='badge badge-inverse' href='". $this->webroot . 'files/uploads/'.@$image_menushop."''>VER IMAGEN ACTUAL</a>" : null; ?> 
						</div>
					</div>
					<br />
					<div class="control-group">
						<label class="control-label" for="columns-text"></label>
						<div class="controls">
							<script id="image_thumb_two" type="text/x-handlebars-template" data-url="<?php echo $this->webroot . 'files/uploads/' ?>">
								<span style="margin-top:10px;margin-bottom:10px;">	
									<img src="{{image_two}}" width="100"/> 
									<a href="#" class="delete_image_two" data-input="[name='image_menushop']" data-file="{{file_two}}">X</a>
								</span>
							</script>
							<span id="images_two">
							</span>
						</div>
					</div>
				</div>
			</div> </label>
            </div>
            &nbsp;
			&nbsp;
			&nbsp;
	
            <div style="display:inline;">
				<label class="" for="columns-text">Banner Producto Shop 
					<div class="row">
				<div class="col-xs-12">
					<div class="control-group"> 
						<label class="control-label" for="columns-text">Imagen: <span class="counter_one">0</span>%</label>
						<div class="controls">
							<input type="file" id="upload_one" data-input="[name='image_prodshop']" data-count=".counter_one" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
					    <input type="hidden" name="image_prodshop" value="<?php echo (!empty( @$image_prodshop )) ? @$image_prodshop : null ; ?>" /> <?php echo (!empty( @$image_prodshop )) ? "<a target='_new' class='badge badge-inverse' href='". $this->webroot . 'files/uploads/'.@$image_prodshop."''>VER IMAGEN ACTUAL</a>" : null; ?> 
						</div>
					</div>
					<br />
					<div class="control-group">
						<label class="control-label" for="columns-text"></label>
						<div class="controls">
							<script id="image_thumb_one" type="text/x-handlebars-template" data-url="<?php echo $this->webroot . 'files/uploads/' ?>">
								<span style="margin-top:10px;margin-bottom:10px;">	
									<img src="{{image_one}}" width="100"/> 
									<a href="#" class="delete_image_one" data-input="[name='image_prodshop']" data-file="{{file_one}}">X</a>
								</span>
							</script>
							<span id="images_one">
							</span>
						</div>
					</div>
				</div>
			</div></label>
            </div>
			
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