<?php echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php echo $this->Html->script('custom-tabs.js?v=' . Configure::read('APP_VERSION'), array('inline' => false)); ?>
<?php echo $this->Html->script('jquery.growl.js?v=' . Configure::read('APP_VERSION'), array('inline' => false)); ?>
<?php echo $this->Html->script('application-form.js?v=' . Configure::read('APP_VERSION'), array('inline' => false)); ?>
<?php echo $this->Html->css('jquery.growl.css?v=' . Configure::read('APP_VERSION')) ?>

	<form action="" id="form_app" method="post" class="form-inline" enctype="multipart/form-data">
    <div class="custom-tabs block-themed">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="active text-center">
          <a href="#social">
            Redes sociales
          </a>
        </li>
        <li class="text-center">
          <a href="#payments">
            Mercado pago
          </a>
        </li>
        <li class="text-center">
          <a href="#analytics">
            Analíticas
          </a>
        </li>
        <li class="text-center">
          <a href="#google-fonts">
            Fuente
          </a>
        </li>
      </ul>
      <div class="tab-content p-7">
        <div class="tab-pane active" id="social">
        	<div class="row">
        		<div class="col-md-6">
			        <h4 class="sub-header">Presencia en redes sociales</h4>
			        <p>Incluye la URL entera correspondiente a cada red social</p>
			        <div class="control-group">
			          <label class="control-label" for="facebook_on">
					        <input type="checkbox" id="facebook_on" name="data[facebook_on]" <?= @!empty($settings['facebook_on'] && $settings['facebook_on'] == 'on') ? ' checked' : '' ?>>
			          	<i class="fa fa-facebook"></i><?php echo __('Facebook'); ?></label>
			          <div class="controls">
			            <input type="text" maxlength="100" name="data[facebook_url]" class="form-control" value="<?= @$settings['facebook_url'] ?>"/>
			          </div>
			          <span class="text-muted">Ingresá la URL de tu perfil de Facebook</span>
			        </div>
			        <div class="control-group">
			          <label class="control-label" for="instagram_on">
					        <input type="checkbox" id="instagram_on" name="data[instagram_on]" <?= @!empty($settings['instagram_on'] && $settings['instagram_on'] == 'on') ? ' checked' : '' ?>>
			          	<i class="fa fa-instagram"></i> <?php echo __('Instagram'); ?></label>
			          <div class="controls">
			            <input type="text" maxlength="100" name="data[instagram_url]" class="form-control" value="<?= @$settings['instagram_url'] ?>"/>
			          </div>
			          <span class="text-muted">Ingresá la URL de tu perfil de Instagram</span>
			        </div>
			        <div class="control-group">
			          <label class="control-label" for="x-twitter_on">
					        <input type="checkbox" id="x-twitter_on" name="data[x-twitter_on]" <?= @!empty($settings['x-twitter_on'] && $settings['x-twitter_on'] == 'on') ? ' checked' : '' ?>>
			          	<i class="fa fa-twitter"></i> <?php echo __('X-twitter'); ?></label>
			          <div class="controls">
			            <input type="text" maxlength="100" name="data[x-twitter_url]" class="form-control" value="<?= @$settings['x-twitter_url'] ?>"/>
			          </div>
			          <span class="text-muted"> Ingresá la URL de tu perfil de X</span>
			        </div>
			        <div class="control-group">
			          <label class="control-label" for="youtube_on">
					        <input type="checkbox" id="youtube_on" name="data[youtube_on]" <?= @!empty($settings['youtube_on'] && $settings['youtube_on'] == 'on') ? ' checked' : '' ?>>
			          	<i class="fa fa-youtube"></i> <?php echo __('Youtube'); ?></label>
			          <div class="controls">
			            <input type="text" maxlength="100" name="data[youtube_url]" class="form-control" value="<?= @$settings['youtube_url'] ?>"/>
			          </div>
			          <span class="text-muted"> Ingresá la URL de tu perfil de Youtube</span>
			        </div>			        

						</div>
	      		<div class="col-md-6">
			        <h4 class="sub-header">Compartir contenido</h4>
			        <p>Estos datos se visualizarán al momento de compartir la aplicación con el estandar opengraph de huella de sitios web y aplicaciones. Este estandar es utilizado por la mayoría de los sistemas de mensajería instantánea.</p>
			        <div class="control-group">
			          <label class="control-label" for="columns-text"><?php echo __('Tipo'); ?></label>
			          <div class="controls text-center switch-scale">
			            <?php
			              $enabled = @$settings['opengraph_type'] == 'website' ? 'checked' : '';
			              $disabled = @$settings['opengraph_type'] == 'article' ? 'checked' : '';
			            ?>
			            <label for="enabled_1">Website</label>
			            <input type="radio" class="form-control" id="enabled_1" name="data[opengraph_type]" value="website" <?php echo $enabled; ?> /> &nbsp;
			            <label for="enabled_0">Artículo</label>
			            <input type="radio" class="form-control" id="enabled_0" name="data[opengraph_type]" value="article" <?php echo $disabled; ?> />
			          </div>
			          <span class="text-muted">Indica si se debe trabajar con entorno real o de pruebas</span>
			        </div>
			        <div class="control-group">
			          <label class="control-label" for="columns-text"><?php echo __('Título'); ?></label>
			          <div class="controls">
			            <input type="text" maxlength="100" name="data[opengraph_title]" class="form-control" value="<?= @$settings['opengraph_title'] ?>"/>
			          </div>
			          <span class="text-muted">Ingresá el título que desees para tu aplicación.</span>
			        </div>
			        <div class="control-group">
			          <label class="control-label" for="columns-text"><?php echo __('Descripción'); ?></label>
			          <div class="controls">
			            <textarea name="data[opengraph_text]" class="form-control w-100"><?= @$settings['opengraph_text'] ?></textarea>
			            <span class="text-muted">Ingresá el texto que desees para tu aplicación.</span>
			          </div>
			        </div>
							<hr>	      			
			        <h4 class="sub-header">Imagen principal</h4>
			        <p>Resolución recomendada 500x500px</p>

							<div class="control-group">
								<label class="control-label" for="columns-text"><?php echo __('Seleccione una imagen'); ?></label>
								<div class="controls">
									<input type="file" name="data[opengraph][image]" value="" accept="image/*">
								</div>
							</div>

			        <div class="control-group">
			          <label class="control-label" for="columns-text"><?php echo __('Width'); ?></label>
			          <div class="controls">
			            <input type="number" maxlength="100" name="data[opengraph_width]" class="form-control" value="<?= @$settings['opengraph_width'] ?>"/>
			          </div>
			          <span class="text-muted">Ancho de la imagen</span>
			        </div>
	        		<div class="control-group">
			          <label class="control-label" for="columns-text"><?php echo __('Height'); ?></label>
			          <div class="controls">
			            <input type="number" maxlength="100" name="data[opengraph_height]" class="form-control" value="<?= @$settings['opengraph_height'] ?>"/>
			          </div>
			          <span class="text-muted">Alto de la imagen.</span>
			        </div>
							<br />
							<!--div class="control-group">						
								<div class="controls">
									<button class="btn btn-primary" type="submit">Agregar Imagen</button>
								</div>
							</div-->
						<?php if($settings['opengraph_image']): ?>
							<img src="<?= $settings['opengraph_image'] ?>" width="200">
							<button class="btn btn-danger" onclick="window.location.href='<?php echo $this->Html->url(array('action'=>'remove_opengraph_image')) ?>'">x</button>
						<?php endif; ?> 			        
			      </div>
					</div>
				</div>


				<div class="tab-pane" id="analytics">
	        <h4 class="sub-header">Reportes de la tienda</h4>
	        <p>Proporciona el código público del sitio para todos los servicios.</p>
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Google Analytics code'); ?></label>
	          <div class="controls">
	            <input type="text" maxlength="100" name="data[google_analytics_code]" class="form-control" value="<?= @$settings['google_analytics_code'] ?>"/>
	          </div>
	          <span class="text-muted">Ingresa el código de Google Analytics</span>
	        </div>
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Facebook Pixel ID'); ?></label>
	          <div class="controls">
	            <input type="text" maxlength="100" name="data[facebook_pixel_id]" class="form-control" value="<?= @$settings['facebook_pixel_id'] ?>"/>
	          </div>
	          <span class="text-muted">Ingresa la identificación del pixel.</span>
	        </div>	 
    		</div>


        <div class="tab-pane" id="google-fonts">
	        <h4 class="sub-header">Fuente de la tienda</h4>
	        <p>Asigna el nombre de la fuente que desees (los archivos correspondientes se solicitarán a Google Fonts)</p>
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Google Font name'); ?></label>
	          <div class="controls">
	            <input type="text" maxlength="100" name="data[google_font_name]" class="form-control" value="<?= @$settings['google_font_name'] ?>"/>
	          </div>
	          <span class="text-muted">Ingresa el nombre de la fuente, ej:
	          	<span class="text-muted">DM Sans</span>
	          </span>
	        </div>
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Google Font size'); ?></label>
	          <div class="controls">
	            <input type="text" maxlength="100" name="data[google_font_size]" class="form-control" value="<?= @$settings['google_font_size'] ?>"/>
	          </div>
	          <span class="text-muted">Ingresa el tamaño de la fuente, ej: 
          		<span class="text-muted">300,400,500,600,700,800</span>
	          </span>
	        </div>
        </div>

        <div class="tab-pane" id="payments">
	        <!--h4 class="sub-header">Mercado pago</h4-->
	        <p>Proporciona el client_secret y client_id proporcionado por Mercado pago.</p>
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Modo de operación'); ?></label>
	          <div class="controls text-center switch-scale">
	            <?php
	              $enabled = @$settings['mercadopago_sandbox_on'] == 'on' ? 'checked' : '';
	              $disabled = @$settings['mercadopago_sandbox_on'] == 'off' ? 'checked' : '';
	            ?>
	            <label for="mercadopago_sandbox_on_1">Pruebas</label>
	            <input type="radio" class="form-control" id="mercadopago_sandbox_on_1" name="data[mercadopago_sandbox_on]" value="on" <?php echo $enabled; ?> /> &nbsp;
	            <label for="mercadopago_sandbox_on_0">Producción</label>
	            <input type="radio" class="form-control" id="mercadopago_sandbox_on_0" name="data[mercadopago_sandbox_on]" value="off" <?php echo $disabled; ?> />
	          </div>
	          <span class="text-muted">Indica si debe mostrarse como artículo o como sitio web.</span>
	        </div>
					<hr>	        
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Client ID'); ?></label>
	          <div class="controls">
	            <input type="text" maxlength="100" name="data[mercadopago_client_id]" class="form-control" value="<?= @$settings['mercadopago_client_id'] ?>"/>
	          </div>
	          <span class="text-muted">Ingresa el código de Google Analytics</span>
	        </div>
	        <div class="control-group">
	          <label class="control-label" for="columns-text"><?php echo __('Client secret'); ?></label>
	          <div class="controls">
	            <input type="text" maxlength="100" name="data[mercadopago_client_secret]" class="form-control" value="<?= @$settings['mercadopago_client_secret'] ?>"/>
	          </div>
	          <span class="text-muted">Ingresa la identificación del pixel.</span>
	        </div>
	        <hr>
	        <!--label for="mercadopago_sandbox_on" class="d-flex justify-content-start justify-content-center gap-05">
		        <input type="checkbox" id="mercadopago_sandbox_on" name="data[mercadopago_sandbox_on]" <?= @!empty($settings['mercadopago_sandbox_on'] && $settings['mercadopago_sandbox_on'] == 'on') ? ' checked' : '' ?>>
		        <span>Modo pruebas</span>
		      </label-->
        </div>
     	</div>
	    <br />      
	    <div class="form-actions">
	      <a href="/admin/cupones" class="btn btn-info"><i class="icon-repeat"></i> Atrás</a>
	      <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="icon-ok"></i> Guardar</button>
	    </div>
	  </div>
	</form>
