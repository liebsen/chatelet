<?php
  $this->Html->script('ckeditor/ckeditor', array('block' => 'script'));
  $this->Html->script('form_app.js?v=' . $version['ver'], array('block' => 'script')); 
  $this->Html->script('regenerate_pass.js?v=' . $version['ver'], array('block' => 'script')); 
?>
<?php echo $this->element('admin/menu');?>
<div class="block-section">
  <div class="block-tabs">
    <!--div class="block-title">
      <h4>
      <?php 
        echo (isset($usuario)) ? __('Editar Usuario') : __('Agregar Usuario');
      ?>
      </h4>
    </div-->

    <div class="tab-content">
      <form action="" id="form_app" method="post" class="form-inline">
        <?php
          if (isset($this->request->pass[1])) {
            echo '<input type="hidden" name="data[id]" value="'. htmlspecialchars($this->request->pass[1]) .'" />';
          }
        ?>
        <div class="row">
          <div class="col-md-12">
            <h4 class="sub-header">Información Principal</h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Email'); ?></label>
              <div class="controls">
                <input type="email" class="form-control w-100" id="" name="data[email]" value="<?php echo (isset($usuario)) ? $usuario['User']['email'] : ''; ?>" required>
              </div>
            </div>
            <br />
            <?php if($this->Session->read('Auth.User.role') === 'sadmin'):?>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Contraseña'); ?></label>
              <button class="btn btn-danger" id="regenerate_password">Generar nueva contraseña</button>
              <span class="regenerate-result case-preserve text-sm text-muted"></span>
            </div>
            <br />
            <?php endif ?>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Nombre'); ?></label>
              <div class="controls">
                <input type="text" class="form-control w-100" id="" name="data[name]" value="<?php echo (isset($usuario)) ? $usuario['User']['name'] : ''; ?>">
              </div>
            </div>
            <br />
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Apellido'); ?></label>
              <div class="controls">
                <input type="text" class="form-control w-100" id="" name="data[surname]" value="<?php echo (isset($usuario)) ? $usuario['User']['surname'] : ''; ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Fecha de nacimiento'); ?></label>
              <div class="controls">
                <input type="text" class="form-control w-100" class="input-datepicker" name="data[birthday]" value="<?php echo (isset($usuario)) ? $this->Time->format($usuario['User']['birthday'], '%d/%m/%Y') : ''; ?>" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Sexo'); ?></label>
              <div class="controls text-center switch-scale">
                <?php
                  $masculino = (isset($usuario) && $usuario['User']['gender'] == 'M') ? 'checked' : '';
                  $femenino = (isset($usuario) && $usuario['User']['gender'] == 'F') ? 'checked' : '';
                ?>
                <span>
                  <input type="radio" class="form-control" name="data[gender]" id="gender_f" value="F" <?php echo $femenino; ?> />
                  <label for="gender_f">Femenino</label>
                </span>
                <span>
                  <input type="radio" class="form-control" name="data[gender]" id="gender_m" value="M" <?php echo $masculino; ?> />
                  <label for="gender_m">Masculino</label>
                </span>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('DNI'); ?></label>
              <div class="controls">
                <input type="text" class="form-control w-100" id="" name="data[dni]" value="<?php echo (isset($usuario)) ? $usuario['User']['dni'] : ''; ?>">
              </div>
            </div>
            <br />
            <div class="form-group">
              <label class="control-label" for="columns-text"><?php echo __('Newsletter'); ?></label>
              <input type="checkbox" name="data[newsletter]" value="1" id="toggle" class="toggle-checkbox"<?= $usuario['User']['newsletter'] == '1' ? ' checked' : '' ?>>
              <label for="toggle" class="toggle-label"></label>
            </div>
            <br />
          </div>
          <div class="col-md-6">
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Teléfono'); ?></label>
              <div class="controls">
                <input type="text" class="form-control w-100" id="" name="data[telephone]" value="<?php echo (isset($usuario)) ? $usuario['User']['telephone'] : ''; ?>">
              </div>
            </div>
            <br />
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Otro teléfono'); ?></label>
              <div class="controls">
                <input type="text" class="form-control w-100" id="" name="data[another_telephone]" value="<?php echo (isset($usuario)) ? $usuario['User']['another_telephone'] : ''; ?>">
              </div>
            </div>
            <br />
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Dirección'); ?></label>
              <div class="controls">
                <input type="text" class="form-control w-100" id="" name="data[address]" value="<?php echo (isset($usuario)) ? $usuario['User']['address'] : ''; ?>">
              </div>
            </div>
            <br />
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Provincia'); ?></label>
              <div class="controls">
                  <select id="provincia" class="selectpicker form-control w-100" name="data[province]">
                    <?php
                      if (isset($usuario) && !empty($usuario['User']['province'])) {
                        echo '<option value="'. $usuario['User']['province'] .'" selected>'. $usuario['User']['province'] .'</option>';
                      } else {
                        echo '<option>Seleccionar provincia</option>';
                      }
                    ?>
                    <option value="Capital Federal">Capital Federal</option>
                    <option value="Buenos Aires">Buenos Aires</option>
                    <option value="Catamarca">Catamarca</option>
                    <option value="Chaco">Chaco</option>
                    <option value="Chubut">Chubut</option>
                    <option value="Cordoba">Córdoba</option>
                    <option value="Corrientes">Corrientes</option>
                    <option value="Entre Rios">Entre Ríos</option>
                    <option value="Formosa">Formosa</option>
                    <option value="Jujuy">Jujuy</option>
                    <option value="La Pampa">La Pampa</option>
                    <option value="La Rioja">La Rioja</option>
                    <option value="Mendoza">Mendoza</option>
                    <option value="Misiones">Misiones</option>
                    <option value="Neuquen">Neuquén</option>
                    <option value="Rio Negro">Río Negro</option>
                    <option value="Salta">Salta</option>
                    <option value="San Juan">San Juan</option>
                    <option value="San Luis">San Luis</option>
                    <option value="Santa Cruz">Santa Cruz</option>
                    <option value="Santa Fe">Santa Fe</option>
                    <option value="Sgo. del Estero">Santiago del Estero</option>
                    <option value="Tierra del Fuego">Tierra del Fuego</option>
                    <option value="Tucuman">Tucumán</option>
                  </select>
              </div>
            </div>
            <br />
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Ciudad'); ?></label>
              <div class="controls">
                <input type="text" class="form-control w-100" id="" name="data[city]" value="<?php echo (isset($usuario)) ? $usuario['User']['city'] : ''; ?>">
              </div>
            </div>
            <br />
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Barrio'); ?></label>
              <div class="controls">
                <input type="text" class="form-control w-100" id="" name="data[neighborhood]" value="<?php echo (isset($usuario)) ? $usuario['User']['neighborhood'] : ''; ?>">
              </div>
            </div>
            <br />
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Código Postal'); ?></label>
              <div class="controls">
                <input type="text" class="form-control w-100" id="" name="data[postal_address]" value="<?php echo (isset($usuario)) ? $usuario['User']['postal_address'] : ''; ?>">
              </div>
            </div>
            <br />
            <div class="form-group">
              <label class="control-label" for="toggle-admin"><?php echo __('¿Es administrador?'); ?></label>
              <input type="checkbox" name="data[role]" value="admin" id="toggle-admin" class="toggle-checkbox"<?= $usuario['User']['role'] == 'admin' ? ' checked' : '' ?>>
              <label for="toggle-admin" class="toggle-label"></label>
            </div>
            <hr />
            <div class="form-group">
              <label class="control-label" for="toggle-admin"><?php echo __('¿Es miembro del club?'); ?></label>
              <input type="checkbox" name="data[role]" value="club" id="toggle-club" class="toggle-checkbox"<?= $usuario['User']['role'] == 'club' ? ' checked' : '' ?>>
              <label for="toggle-club" class="toggle-label"></label>
            </div>
          </div>              
        </div>      
        <br />               
        <div class="form-actions">
          <button type="reset" class="btn btn-danger"><i class="fa fa-close"></i> <span class="ml-1">Reset</span></button>
          <button type="submit" class="btn btn-success" disabled><i class="fa fa-check"></i> <span class="ml-1">Guardar</span></button>
        </div>
      </form>
    </div>
  </div>
</div>
