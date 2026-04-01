		        	<div class="row">
		        		<div class="col-md-6">
					        <h4 class="sub-header">Acceso a Gmail</h4>
					        <p>Indica el nombre de usuario y contraseña de la cuenta gmail</p>
					        <div class="control-group">
					          <label class="control-label" for="columns-text"><?php echo __('Usuario'); ?></label>
					          <div class="controls">
					            <input type="text" maxlength="100" name="data[email_user]" class="form-control" value="<?php echo @$settings['email_username'] ?>" placeholder="Ingresá el nombre de usuario de la aplicaición"/>
					          </div>
					        </div>
					        <div class="control-group">
					          <label class="control-label" for="columns-text"><?php echo __('Contraseña'); ?></label>
					          <div class="controls">
					            <input type="pasword" maxlength="100" name="data[email_pass]" class="form-control" value="<?php echo @$settings['email_password'] ?>" placeholder="Ingresá la contraseña de la aplicación"/>
					          </div>
					        </div>
								</div>
			      		<div class="col-md-6">
					      </div>
							</div>