<?php 
echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false));
echo $this->Html->script('custom-tabs.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->css('draggable-sliders.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->css('shop-sliders.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->script('draggable-sliders.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->script('shop-sliders.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->script('admin-sliders.js?v=' . Configure::read('APP_VERSION'), array('inline'=>false));
// $this->Html->script('ckeditor/ckeditor.js', array('inline' => false));
?>

<div class="block">
	<div class="block-content">
		<form action="" id="display_form" method="post" class="form-inline" enctype="multipart/form-data">
			<input type="hidden" name="data[id]" value="1" />
	    <div class="custom-tabs block-themed">
	      <ul class="nav nav-tabs" id="myTab" role="tablist">
	      <?php foreach($tags as $key => $tag): ?>
	        <li class="<?php echo $key == 0 ? 'active ' : '' ?>text-center">
	          <a href="#<?php echo $tag ?>">
	            <?php echo $tag ?>
	          </a>
	        </li>
	       <?php endforeach ?>
	      </ul>
	      <div class="tab-content">
	      	<?php foreach($tags as $key => $tag): ?>
	        <div class="tab-pane pane-<?php echo $tag ?><?php echo $key == 0 ? ' active' : '' ?>">
		        <!--h4 class="sub-header">Pantalla inicial <span class="counter_newsletter hide"></span></h4-->
		        <p><?php echo $slider['tag'] ?></p>
						<div class="control-group w-100 bg-dark" style="min-height: 233px;">
							<div class="controls w-100">
	      				<?php foreach($sliders[$tag] as $key => $item): ?>
									<span class="image-item">	
										<div class="media-container">
											<?php if(strstr($item['img_url'], '.mp4') != false): ?>
								        <video src="<?php echo $settings['upload_url'] ?><?php echo $item['img_url'] ?>"  id="video<?=$key?>" class="carousel-video" <?= (strpos( $_SERVER['HTTP_USER_AGENT'], 'Safari') !== false) ? ' controls="true" ' : '' ?>>
								        </video>
											<?php else: ?>
												<img src="<?php echo $settings['upload_url'] ?><?php echo $item['img_url'] ?>"/> 
											<?php endif ?>
										</div>
		                <span class="category-toolbox">
		                  <span class="btn bg-transparent btn-toggle-form p-3">
		                    <i class="fa fa-edit fa-lg text-success"></i>
		                  </span>
											<a href="#" class="btn bg-transparent delete-image p-3" data-input="[name='data[splash]']" data-file="<?php echo $item['img_url'] ?>">
												<i class="fa fa-close"></i>
											</a>
											<a href="#" class="btn bg-transparent p-3">
												<i class="fa fa-2x fa-<?php echo $item['device'] ?> min-w-4 is-clickable edit-orientation" data-file="<?php echo $item['img_url'] ?>" data-origin="splash" data-orientation="<?php echo $item['device'] ?>"></i>
											</a>
		                </span>
		                <span class="category-form">
		                  <div class="category-form-content">
		                    <span class="form-group d-flex flex-start gap-05" title="Ancho de columna">
		                      <!--label class="text-chatelet">Ancho de columna</label-->
		                      <i class="fa fa-columns"></i>
		                      <select class="form-control update-colsize" name="data[colsize]" style="width: 70px">
		                        <option value="6"<?= empty($category['Category']['colsize']) ? ' selected' : '' ?>>Auto</option>
		                        <!--option value="2"<?= @$category['Category']['colsize'] == '2' ? ' selected' : '' ?>>16.66%</option-->
		                        <option value="20"<?= @$category['Category']['colsize'] == '20' ? ' selected' : '' ?>>20%</option>
		                        <option value="3"<?= @$category['Category']['colsize'] == '3' ? ' selected' : '' ?>>25%</option>
		                        <option value="4"<?= @$category['Category']['colsize'] == '4' ? ' selected' : '' ?>>33%</option>
		                        <option value="40"<?= @$category['Category']['colsize'] == '40' ? ' selected' : '' ?>>40%</option>
		                        <option value="6"<?= @$category['Category']['colsize'] == '6' ? ' selected' : '' ?>>50%</option>
		                        <option value="60"<?= @$category['Category']['colsize'] == '60' ? ' selected' : '' ?>>60%</option>
		                        <option value="8"<?= @$category['Category']['colsize'] == '8' ? ' selected' : '' ?>>66%</option>
		                        <option value="9"<?= @$category['Category']['colsize'] == '9' ? ' selected' : '' ?>>75%</option>
		                        <option value="80"<?= @$category['Category']['colsize'] == '80' ? ' selected' : '' ?>>80%</option>
		                        <option value="12"<?= @$category['Category']['colsize'] == '12' ? ' selected' : '' ?>>100%</option>
		                      </select>              
		                    </span>
		                    <span class="form-group d-flex flex-start gap-05" title="Posición del texto">
		                      <!--label class="text-chatelet">Posición del texto</label-->
		                      <i class="fa fa-text-height"></i>
		                      <select class="form-control update-alignnum" name="data[alignnum]">
		                        <option value="0"<?= empty($category['Category']['alignnum']) ? ' selected' : '' ?>>Centro</option>
		                        <option value="1"<?= @$category['Category']['alignnum'] == '1' ? ' selected' : '' ?>>Izquierda</option>
		                        <option value="2"<?= @$category['Category']['alignnum'] == '2' ? ' selected' : '' ?>>Derecha</option>
		                        <option value="3"<?= @$category['Category']['alignnum'] == '3' ? ' selected' : '' ?>>Arriba</option>
		                        <option value="4"<?= @$category['Category']['alignnum'] == '4' ? ' selected' : '' ?>>Abajo</option>
		                        <option value="5"<?= @$category['Category']['alignnum'] == '5' ? ' selected' : '' ?>>Arriba/Izquierda</option>
		                        <option value="6"<?= @$category['Category']['alignnum'] == '6' ? ' selected' : '' ?>>Arriba/Derecha</option>
		                        <option value="7"<?= @$category['Category']['alignnum'] == '7' ? ' selected' : '' ?>>Abajo/Izquierda</option>
		                        <option value="8"<?= @$category['Category']['alignnum'] == '8' ? ' selected' : '' ?>>Abajo/Derecha</option>
		                      </select>
		                    </span>
		                    <span class="form-group d-flex flex-start gap-05" title="Posición de imagen">
		                      <!--label class="text-chatelet">Ancho de columna</label-->
		                      <i class="fa fa-image"></i>
		                      <select class="form-control update-posnum" name="data[posnum]">
		                        <option value="0"<?= empty($category['Category']['posnum']) ? ' selected' : '' ?>>Centro</option>
		                        <option value="1"<?= @$category['Category']['posnum'] == '1' ? ' selected' : '' ?>>Izquierda</option>
		                        <option value="2"<?= @$category['Category']['posnum'] == '2' ? ' selected' : '' ?>>Derecha</option>
		                        <option value="3"<?= @$category['Category']['posnum'] == '3' ? ' selected' : '' ?>>Arriba</option>
		                        <option value="4"<?= @$category['Category']['posnum'] == '4' ? ' selected' : '' ?>>Abajo</option>
		                        <option value="5"<?= @$category['Category']['posnum'] == '5' ? ' selected' : '' ?>>Arriba/Izquierda</option>
		                        <option value="6"<?= @$category['Category']['posnum'] == '6' ? ' selected' : '' ?>>Arriba/Derecha</option>
		                        <option value="7"<?= @$category['Category']['posnum'] == '7' ? ' selected' : '' ?>>Abajo/Izquierda</option>
		                        <option value="8"<?= @$category['Category']['posnum'] == '8' ? ' selected' : '' ?>>Abajo/Derecha</option>
		                      </select>
		                    </span>
		                  </div>
		                </span>										
									</span>
								<?php endforeach ?>
							</div>
					  </div>
					  <progress class="progress_newsletter hide w-100" value="50" max="100">0%</progress>
						<div class="control-group">
							<div class="controls">
								<input type="file" class="form-control" id="HomeImgPopupNewsletter" data-input="[name='data[splash]']" data-progress=".progress_newsletter" data-url="<?php echo $this->Html->url(array( 'action' => 'save_file_admin' ),true) ?>"/>
								Imagen. Tamaño recomendado 1920x1080 o 720x1600
								<input type="hidden" name="data[splash]" value="<?php echo $slider['Home']['splash'] ?>" />
							</div>
						</div>
	        </div>
	      <?php endforeach ?>
	      </div>
	    </div>
			<div class="form-actions">
				<input type="hidden" name="id" value="1">
				<button type="reset" class="btn btn-danger" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="fa fa-close mr-1"></i> Restaurar</button>
				<button type="submit" class="btn btn-success animated fast" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
			</div>
		</form>
	</div>
</div>
