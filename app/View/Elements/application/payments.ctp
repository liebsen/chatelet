				      <div class="row">
				        <div class="col-md-6">
				        	<h4 class="sub-header">Acceso a Mercado Pago</h4>
					        <p>Proporciona los siguientes datos provistos por Mercado Pago. Establece modo de operación.</p>
					        <div class="control-group">
					          <label class="control-label" for="columns-text"><?php echo __('Client ID'); ?></label>
					          <div class="controls">
					            <input type="text" maxlength="100" name="data[mercadopago_client_id]" class="form-control" value="<?php echo @$settings['mercadopago_client_id'] ?>" placeholder="ID de Mercado pago"/>
					          </div>
					        </div>
					        <div class="control-group">
					          <label class="control-label" for="columns-text"><?php echo __('Client secret'); ?></label>
					          <div class="controls">
					            <input type="text" maxlength="100" name="data[mercadopago_client_secret]" class="form-control" value="<?php echo @$settings['mercadopago_client_secret'] ?>" placeholder="Codigo secret"/>
					          </div>
					        </div>
					      </div>
					      <div class="col-md-6">
				        	<h4 class="sub-header">Modo de operación</h4>
					        <div class="control-group">
					          <!--label class="control-label" for="columns-text"><?php echo __('Modo de operación'); ?></label-->
					          <div class="controls text-center switch-scale">
					            <?php
					              $enabled = @$settings['mercadopago_sandbox_on'] == 'on' ? 'checked' : '';
					              $disabled = @$settings['mercadopago_sandbox_on'] == 'off' ? 'checked' : '';
					            ?>
					            <span>
					            <input type="radio" class="form-control" id="mercadopago_sandbox_on_0" name="data[mercadopago_sandbox_on]" value="off" <?php echo $disabled; ?> />
					            <label for="mercadopago_sandbox_on_0">Entorno real (Producción)</label>
					          </span>
					          <span>
					            <input type="radio" class="form-control" id="mercadopago_sandbox_on_1" name="data[mercadopago_sandbox_on]" value="on" <?php echo $enabled; ?> /> 
					            <label for="mercadopago_sandbox_on_1">Entorno pruebas</label>
					          </span>
					          </div>
					          <span class="text-muted">Indica si los pagos se solicitarán a modo de pruebas.</span>
					        </div>

					        <!--label for="mercadopago_sandbox_on" class="d-flex justify-content-start justify-content-center gap-05">
						        <input type="checkbox" id="mercadopago_sandbox_on" name="data[mercadopago_sandbox_on]" <?php echo @!empty($settings['mercadopago_sandbox_on'] && $settings['mercadopago_sandbox_on'] == 'on') ? ' checked' : '' ?>>
						        <span>Modo pruebas</span>
						      </label-->
						     </div>
						  </div>