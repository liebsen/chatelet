<?php echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php echo $this->Html->script('admin_index',array('inline'=>false)) ?>
<?php $this->Html->script('ckeditor/ckeditor.js', array('inline' => false));?>

<div class="block">
	<div class="block-title">
		<h4><?php echo __('Presentación') ?></h4>
	</div>

	<div class="block-content">
		<form action="" method="post" class="form-inline" enctype="multipart/form-data">
			<input type="hidden" name="data[id]" value="1" />
			<div class="row">
				<div class="col-md-9">
			    <div class="col-md-4">
						<div class="control-group">
							<label class="control-label" for="columns-text"><?php echo __('Primer linea'); ?></label>
							<div class="controls">
								<input type="text" class="form-control" name="data[line_one]" value="<?php echo $p['Home']['line_one'] ?>">
							</div>
						</div>
          </div>
			    <div class="col-md-4">
						<div class="control-group">
							<label class="control-label" for="columns-text"><?php echo __('Segunda linea'); ?></label>
							<div class="controls">
								<input type="text" class="form-control" name="data[line_two]" value="<?php echo $p['Home']['line_two'] ?>">
							</div>
						</div>
         	</div>
					<div class="col-md-4">
						<div class="control-group">
							<label class="control-label" for="columns-text"><?php echo __('Tercer linea'); ?></label>
							<div class="controls">
								<input type="text" class="form-control" name="data[line_three]" value="<?php echo $p['Home']['line_three'] ?>">
							</div>
						</div>
		      </div>
	        </br>  
			    <div class="row">
						<div class="col-md-12"></br> </br>  </br> </br> 
						  <div class="col-md-4">
						    <label class="control-label" for="columns-text"><?php echo __('Modulo I'); ?></label>
								<div class="control-group">
									<label class="control-label" for="columns-text"><?php echo __('Texto'); ?></label>
									<div class="controls">
										<input type="text" class="form-control" name="data[module_one]" value="<?php echo $p['Home']['module_one'] ?>">
									</div>
								</div>
							</div>
              <div class="col-md-4">
              	<br />
								<div class="control-group">
									<label class="control-label" for="columns-text">Subir Archivo: <span class="counter_one">0</span>%</label>
									<div class="controls">
										<input type="file" id="upload_one" data-input="[name='data[img_url_one]']" data-count=".counter_one" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
										<input type="hidden" name="data[img_url_one]" value="<?php echo $p['Home']['img_url_one'] ?>" />
									</div>
								</div>
						    <div class="control-group">
									<div class="controls">
										<script id="image_thumb_one" type="text/x-handlebars-template" data-url="<?php echo $settings['upload_url'] ?>">
											<span style="margin-top:10px;margin-bottom:10px;">	
												<img src="{{image_one}}" width="100"/> 
												<a href="#" class="delete_image_one" data-input="[name='data[img_url_one]']" data-file="{{file_one}}">X</a>
											</span>
										</script>
										<span id="images_one">
										</span>
									</div>
							  </div>
		         	</div>
							<div class="col-md-4">
                </br>
                <label class="control-label" for="columns-text"><?php echo __('Categoria'); ?></label>
               	<div class="control-group">
							    <select class="form-control" id="category_mod_one" name="category_mod_one">
			                        <?php $category_selected = ''; ?>
			                            <option value="">Seleccione una Categoria</option>
			                            <?php foreach ($cats  as $key => $category) { ?>   
			                                <?php if($category['Category']['id'] == $p['Home']['category_mod_one']){
			                                        $category_selected = 'selected';
			                                    }else{
			                                            $category_selected = '';
			                                        } ?>
			                                <option <?php echo $category_selected; ?> value="<?php echo $category['Category']['id']; ?>">
			                                <?php echo $category['Category']['name']; ?></option>
			                             <?php } ?> 
		                        		 <option value="url" <?=(isset($p['Home']['url_mod_one']) && !empty($p['Home']['url_mod_one']))?'selected':''?>>URL</option>
									</select>
									<input type="url" id="txturlone" name="url_mod_one" value="<?=(isset($p['Home']['url_mod_one']) && !empty($p['Home']['url_mod_one']))?$p['Home']['url_mod_one']:''?>" placeholder="Ingrese url" class="form-control <?=(isset($p['Home']['url_mod_one']) && !empty($p['Home']['url_mod_one']))?'':'hidden'?>">
								</div>
							</div>  
						</div>  
					</div>     
				 
					<div class="row">
						<div class="col-md-12">
							</br>
						  <div class="col-md-4">
						  	<label class="control-label" for="columns-text"><?php echo __('Modulo II'); ?></label>
								<div class="control-group">
									<label class="control-label" for="columns-text"><?php echo __('Texto'); ?></label>
									<div class="controls">
										<input type="text" class="form-control" name="data[module_two]" value="<?php echo $p['Home']['module_two'] ?>">
									</div>
								</div>
		          </div>
						  <div class="col-md-4">
			        	<br />
								<div class="control-group">
									<label class="control-label" for="columns-text">Subir Archivo: <span class="counter_two">0</span>%</label>
									<div class="controls">
										<input type="file" id="upload_two" data-input="[name='data[img_url_two]']" data-count=".counter_two" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
										<input type="hidden" name="data[img_url_two]" value="<?php echo $p['Home']['img_url_two'] ?>" />
									</div>
								</div>

							  <div class="control-group">
									<div class="controls">
										<script id="image_thumb_two" type="text/x-handlebars-template" data-url="<?php echo $settings['upload_url'] ?>">
											<span style="margin-top:10px;margin-bottom:10px;">	
												<img src="{{image_two}}" width="100"/> 
												<a href="#" class="delete_image_two" data-input="[name='data[img_url_two]']" data-file="{{file_two}}">X</a>
											</span>
										</script>
										<span id="images_two">
										</span>
									</div>
							  </div>
		         	</div>
							<div class="col-md-4">
						    </br>
								<label class="control-label" for="columns-text"><?php echo __('Categoria'); ?></label>    
								<div class="control-group">
									<select class="form-control" id="category_mod_two" name="category_mod_two">
				                        <?php $category_selected = ''; ?>
				                            <option value="">Seleccione una Categoria</option>
				                            <?php foreach ($cats  as $key => $category) { ?>   
				                                <?php if($category['Category']['id'] == $p['Home']['category_mod_two']){
				                                        $category_selected = 'selected';
				                                    }else{
				                                            $category_selected = '';
				                                        } ?>
				                                <option <?php echo $category_selected; ?> value="<?php echo $category['Category']['id']; ?>">
				                                <?php echo $category['Category']['name']; ?></option>
				                             <?php } ?> 
			                        		 <option value="url" <?=(isset($p['Home']['url_mod_two']) && !empty($p['Home']['url_mod_two']))?'selected':''?>>URL</option>
									</select>
									<input type="url" id="txturltwo" name="url_mod_two" value="<?=(isset($p['Home']['url_mod_two']) && !empty($p['Home']['url_mod_two']))?$p['Home']['url_mod_two']:''?>" placeholder="Ingrese url" class="form-control <?=(isset($p['Home']['url_mod_two']) && !empty($p['Home']['url_mod_two']))?'':'hidden'?>">

								</div>
				      </div>
						</div>  
					</div>
					</br>  
					<div class="row">
						<div class="col-md-12"></br> 
						  <div class="col-md-4">
						  	<label class="control-label" for="columns-text"><?php echo __('Modulo III'); ?></label>
								<div class="control-group">
									<label class="control-label" for="columns-text"><?php echo __('Texto'); ?></label>
									<div class="controls">
										<input type="text" class="form-control" name="data[module_three]" value="<?php echo $p['Home']['module_three'] ?>">
									</div>
								</div>
							</div>
	            <div class="col-md-4">
	             	<br />
								<div class="control-group">
									<label class="control-label" for="columns-text">Subir Archivo: <span class="counter_three">0</span>%</label>
									<div class="controls">
										<input type="file" id="upload_three" data-input="[name='data[img_url_three]']" data-count=".counter_three" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
										<input type="hidden" name="data[img_url_three]" value="<?php echo $p['Home']['img_url_three'] ?>" />
									</div>
								</div>
						    <div class="control-group">
									<div class="controls">
										<script id="image_thumb_three" type="text/x-handlebars-template" data-url="<?php echo $settings['upload_url'] ?>">
											<span style="margin-top:10px;margin-bottom:10px;">	
												<img src="{{image_three}}" width="100"/> 
												<a href="#" class="delete_image_three" data-input="[name='data[img_url_three]']" data-file="{{file_three}}">X</a>
											</span>
										</script>
										<span id="images_three">
										</span>
									</div>
							  </div>
		         	</div>
							<div class="col-md-4">
						    </br>
						    <label class="control-label" for="columns-text"><?php echo __('Categoria'); ?></label>
								<div class="control-group">
					        <select class="form-control" id="category_mod_three" name="category_mod_three">
		                        <?php $category_selected = ''; ?>
		                            <option value="">Seleccione una Categoria</option>
		                            <?php foreach ($cats  as $key => $category) { ?>   
		                                <?php if($category['Category']['id'] == $p['Home']['category_mod_three']){
		                                        $category_selected = 'selected';
		                                    }else{
		                                            $category_selected = '';
		                                        } ?>
		                                <option <?php echo $category_selected; ?> value="<?php echo $category['Category']['id']; ?>">
		                                <?php echo $category['Category']['name']; ?></option>
									 <?php } ?> 
									 <option value="url" <?=(isset($p['Home']['url_mod_three']) && !empty($p['Home']['url_mod_three']))?'selected':''?>>URL</option>
									</select>
									<input type="url" id="txturlthree" name="url_mod_three" value="<?=(isset($p['Home']['url_mod_three']) && !empty($p['Home']['url_mod_three']))?$p['Home']['url_mod_three']:''?>" placeholder="Ingrese url" class="form-control <?=(isset($p['Home']['url_mod_three']) && !empty($p['Home']['url_mod_three']))?'':'hidden'?>">
								</div>
				      </div>
						</div>  
					</div> 
					</br>
					<div class="row">
						<div class="col-md-12">
							</br> 
							</br>  
							</br> 
							</br> 
					    <div class="col-md-4">
				        <label class="control-label" for="columns-text"><?php echo __('Modulo IV'); ?></label>
								<div class="control-group">
									<label class="control-label" for="columns-text"><?php echo __('Texto'); ?></label>
									<div class="controls">
										<input type="text" class="form-control" name="data[module_four]" value="<?php echo $p['Home']['module_four'] ?>">
									</div>
								</div>
							</div>
              <div class="col-md-4">
              	<br />
								<div class="control-group">
									<label class="control-label" for="columns-text">Subir Archivo: <span class="counter_four">0</span>%</label>
									<div class="controls">
										<input type="file" id="upload_four" data-input="[name='data[img_url_four]']" data-count=".counter_four" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
										<input type="hidden" name="data[img_url_four]" value="<?php echo $p['Home']['img_url_four'] ?>" />
									</div>
								</div>
						    <div class="control-group">
									<div class="controls">
										<script id="image_thumb_four" type="text/x-handlebars-template" data-url="<?php echo $settings['upload_url'] ?>">
											<span style="margin-top:10px;margin-bottom:10px;">	
												<img src="{{image_four}}" width="100"/> 
												<a href="#" class="delete_image_four" data-input="[name='data[img_url_four]']" data-file="{{file_four}}">X</a>
											</span>
										</script>
										<span id="images_four"></span>
									</div>
							  </div>
		         	</div>
							<div class="col-md-4">
                </br>
                <label class="control-label" for="columns-text"><?php echo __('Categoria');?></label>
               	<div class="control-group">
								  <select class="form-control" id="category_mod_four" name="category_mod_four">
                    <?php $category_selected = ''; ?>
                        <option value="">Seleccione una Categoria</option>
                      <?php foreach ($cats  as $key => $category) { ?>   
                          <?php if($category['Category']['id'] == $p['Home']['category_mod_four']){
                                  $category_selected = 'selected';
                              }else{
                                      $category_selected = '';
                                  } ?>
                          <option <?php echo $category_selected; ?> value="<?php echo $category['Category']['id']; ?>">
                          <?php echo $category['Category']['name']; ?></option>
                       <?php } ?>
                        <option value="url" <?=(isset($p['Home']['url_mod_four']) && !empty($p['Home']['url_mod_four']))?'selected':''?>>URL</option>
                    </select>
                    <input type="url" id="txturlfour" name="url_mod_four" value="<?=(isset($p['Home']['url_mod_four']) && !empty($p['Home']['url_mod_four']))?$p['Home']['url_mod_four']:''?>" placeholder="Ingrese url" class="form-control <?=(isset($p['Home']['url_mod_four']) && !empty($p['Home']['url_mod_four']))?'':'hidden'?>">
								</div>
							</div>  
						</div>   
					</div>  
				</div>
				<div class="col-md-3">
					<div class="control-group">
						<label class="control-label" for="columns-text">Subir Archivo: <span class="counter">0</span>%</label>
						<div class="controls">
							<input type="file" id="upload" data-input="[name='data[img_url]']" data-count=".counter" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
							<input type="hidden" name="data[img_url]" value="<?php echo $p['Home']['img_url'] ?>" />
						</div>
					</div>
					<br />
					<div class="control-group">
						<label class="control-label" for="columns-text">Slider (jpg|jpeg|mp4)</label>
						<div class="controls">
							<script id="image_thumb" type="text/x-handlebars-template" data-url="<?php echo $settings['upload_url'] ?>">
								<li style="margin-top:10px;margin-bottom:10px;">
									{{#if video}}
									<video src="{{image}}" width="100"/> 
									{{else}}
									<img src="{{image}}" width="100"/> 
									{{/if}}
									<a href="#" class="delete_image" data-input="[name='data[img_url]']" data-file="{{file}}">X</a>
								</li>
							</script>
							<ul id="images">
							</ul>
						</div>
					</div>
				</div>             
			</div>	
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-12">
						<label class="control-label" for="columns-text"><?php echo __('Newsletter'); ?></label>
					</div>
					<div class="col-md-9">
						<div class="control-group">
							<label class="control-label" for="columns-text"><?php echo __('Texto'); ?></label>
							<div class="controls">
								<textarea id="HomeTextPopupNewsletter" name="text_popup_newsletter" class="form-control"><?php echo $p['Home']['text_popup_newsletter'] ?></textarea>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="display_popup_form"><?php echo __('Mostrar formulario en popup'); ?></label>
							<div class="controls">
								<input type="checkbox" name="display_popup_form" id="display_popup_form" class="form-control" <?=(!empty($p['Home']['display_popup_form']))?'checked':''?>>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="display_popup_form_in_last"><?php echo __('Mostrar formulario en ultimo popup solamente'); ?></label>
							<div class="controls">
								<input type="checkbox" name="display_popup_form_in_last" id="display_popup_form_in_last" class="form-control" <?=(!empty($p['Home']['display_popup_form_in_last']))?'checked':''?>>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="control-group">
							<label class="control-label" for="columns-text">Subir Archivo: <span class="counter_newsletter">0</span>%</label>
							<div class="controls">
								<input type="file" id="HomeImgPopupNewsletter" data-input="[name='data[img_popup_newsletter]']" data-count=".counter_newsletter" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
								Tamaño recomendado 990x546
								<input type="hidden" name="data[img_popup_newsletter]" value="<?php echo $p['Home']['img_popup_newsletter'] ?>" />
							</div>
						</div>	
						 <div class="control-group">
							<div class="controls">
								<script id="image_thumb_newsletter" type="text/x-handlebars-template" data-url="<?php echo $settings['upload_url'] ?>">
									<span style="margin-top:10px;margin-bottom:10px;">	
										<img src="{{image_newsletter}}" width="100"/> 
										<a href="#" class="delete_image_newsletter" data-input="[name='data[img_popup_newsletter]']" data-file="{{file_newsletter}}">X</a>
									</span>
								</script>
								<span id="images_newsletter"></span>
							</div>
					  </div>
					</div>
				</div>
			</div>
			</br>
			</br>
			<div class="form-actions">
				<input type="hidden" name="id" value="1">
				<button type="reset" class="btn btn-danger" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="icon-repeat"></i> Restaurar</button>
				<button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="icon-ok"></i> Guardar</button>
			</div>
		</form>
	</div>
</div>
