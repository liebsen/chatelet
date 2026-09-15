
<div class="block-section">
	<div class="block-title">
		<h4>Shop - Opciones</h4>
	</div>
	<div class="block-content">
		<form action="<?php echo Router::url(array('action'=>'products_settings')) ?>" method="POST" class="w-100">
			<div class="d-flex flex-nowrap gap-05">
				<div>
					<label class="" for="stock_min">Stock Mínimo:</label>
					<input type="number" class="form-control" id="stock_min" name="stock_min" value="<?php echo @$stock_min ?>" required/>
				</div>
				<div>
					<label class="" for="list_code">Código de Lista:</label>
					<input type="number" class="form-control" id="list_code" name="list_code" value="<?php echo @$list_code ?>" required/>
				</div>
				<div>
					<label class="" for="list_code_desc">Código de Lista Descuento:</label>
					<input type="number" class="form-control" id="list_code_desc" name="list_code_desc" value="<?php echo @$list_code_desc ?>"/>
				</div>
			</div>
			<div>
				<label class="" for="show_shop">Activar Shop </label>
				<input type="checkbox" class="input-themed" id="show_shop" name="show_shop" value="<?php echo @$show_shop ?>" <?php echo (!empty($show_shop))?'checked':''; ?>/>
			</div>
			<div class="row">
				<?php for($i=0;$i<10;$i++): ?>
				<div class="col-xs-12">
					<label class="" for="more_list_code_desc">Código de Lista Descuento:</label>
					<div class="d-flex flex-center gap-05">
						<input type="number" class="form-control" id="more_list_code_desc" name="more_list_code_desc[]" value="<?php echo @$more_list_code_desc[$i] ?>"/>
						<select class="form-control" name="rubro[]" id="rubro_<?=$i?>">
							<option value="0">Select Category</option>
							<?php foreach ($cats as $cat): ?>
								<option
								<?php if ($cat['Category']['id'] == (int)$more_list_category[$i]) { echo ' selected="selected" '; } ?>
								 value="<?=$cat['Category']['id']?>"><?=$cat['Category']['name']?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<?php endfor; ?>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<label class="" >Imagen general del shop </label>
					<div class="row">
						<div class="col-xs-12">
							<div class="control-group"> 
								<label class="control-label" for="upload"><span class="counter"></span></label>
								<div class="controls">                          
									<input type="file" class="form-control" id="upload" data-input="[name='image_bannershop']" data-count=".counter" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
							    <input type="hidden" name="image_bannershop" value="<?php echo (!empty( @$image_bannershop )) ? @$image_bannershop : null ; ?>" /> <?php echo (!empty( @$image_bannershop )) ? "<a target='_new' class='badge badge-inverse' href='". $settings['upload_url'].@$image_bannershop."''>VER IMAGEN ACTUAL</a>" : null; ?> 
								</div>
							</div>
							<div class="control-group">
								<label class="control-label"></label>
								<div class="controls">
									<script id="image_thumb" type="text/x-handlebars-template" data-url="<?php echo $settings['upload_url'] ?>">
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
					</div>
        </div>
      <div>

			<div class="row">
				<div class="col-xs-12">
					<label class="">Imagen del menu shop
					<div class="row">
						<div class="col-xs-12">                                       
							<div class="control-group"> 
								<label class="control-label"><span class="counter_two"></span></label>
								<div class="controls">
									<input type="file" class="form-control" id="uploadkari" data-input="[name='image_menushop']" data-count=".counter_two" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
							    <input type="hidden" name="image_menushop" value="<?php echo (!empty( @$image_menushop )) ? @$image_menushop : null ; ?>" /> <?php echo (!empty( @$image_menushop )) ? "<a target='_new' class='badge badge-inverse' href='". $settings['upload_url'].@$image_menushop."''>VER IMAGEN ACTUAL</a>" : null; ?> 
								</div>
							</div>
							<div class="control-group">
								<label class="control-label"></label>
								<div class="controls">
									<script id="image_thumb_two" type="text/x-handlebars-template" data-url="<?php echo $settings['upload_url'] ?>">
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
					</div>
				</div>
			</div> 

			<div class="row">
				<div class="col-xs-12">
					<label class="">Imagen general en categor&iacute;a</label>
					<div class="control-group"> 
						<label class="control-label" for="upload_one"><span class="counter_one"></span></label>
						<div class="controls">
							<input type="file" class="form-control" id="upload_one" data-input="[name='image_prodshop']" data-count=".counter_one" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
					    <input type="hidden" name="image_prodshop" value="<?php echo (!empty( @$image_prodshop )) ? @$image_prodshop : null ; ?>" /> <?php echo (!empty( @$image_prodshop )) ? "<a target='_new' class='badge badge-inverse' href='". $settings['upload_url'].@$image_prodshop."''>VER IMAGEN ACTUAL</a>" : null; ?> 
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="image_thumb_one"></label>
						<div class="controls">
							<script id="image_thumb_one" type="text/x-handlebars-template" data-url="<?php echo $settings['upload_url'] ?>">
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
			</div>

			<div class="row">
				<div class="col-xs-12">
					<div class="d-flex flex-nowrap gap-05">
						<button class="btn btn-success" type="submit">Guardar</button>
						<button class="btn btn-warning" name="only_categories" value="yes" type="submit">Guardar Solo Rubros</button>
						<input type="checkbox" name="no-update-prices" value="yes" /> No actualizar precios, solo cambiar Stock Config / Visibilidad del Shop
					</div>
				</div>
			</div>
			<button class="btn btn-success" name="execute_discounts" value="yes" type="submit">Actualizar etiquetas de descuento</button>
		</form>
	</div>
  <div class="form-actions">
		<a href="/admin/productos" class="btn btn-info"><i class="fa fa-chevron-left"> <span class="ml-1">Volver</span> </a>
	</div>
</div>