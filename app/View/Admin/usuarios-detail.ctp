<?php
  echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
?>
<?php echo $this->element('admin-menu');?>
<div class="block">
  <div class="block-title">
    <h4>
    <?php 
      echo (isset($usuario)) ? __('Editar Usuario') : __('Agregar Usuario');
    ?>
    </h4>
  </div>

  <div class="block-content">
    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
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
              <input type="email" id="" name="data[email]" value="<?php echo (isset($usuario)) ? $usuario['User']['email'] : ''; ?>" required>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Contraseña'); ?></label>
            <div class="controls">
              <input type="password" id="" name="data[password]" <?php echo (!isset($usuario)) ? 'checked': '' ?>>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Nombre'); ?></label>
            <div class="controls">
              <input type="text" id="" name="data[name]" value="<?php echo (isset($usuario)) ? $usuario['User']['name'] : ''; ?>" required>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Apellido'); ?></label>
            <div class="controls">
              <input type="text" id="" name="data[surname]" value="<?php echo (isset($usuario)) ? $usuario['User']['surname'] : ''; ?>" required>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Fecha de nacimiento'); ?></label>
            <div class="controls">
              <input type="text" class="input-datepicker" name="data[birthday]" value="<?php echo (isset($usuario)) ? $this->Time->format($usuario['User']['birthday'], '%d/%m/%Y') : ''; ?>" />
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Sexo'); ?></label>
            <div class="controls">
              <?php
                $masculino = (isset($usuario) && $usuario['User']['gender'] == 'M') ? 'checked' : '';
                $femenino = (isset($usuario) && $usuario['User']['gender'] == 'F') ? 'checked' : '';
              ?>
              Masculino <input type="radio" name="data[gender]" value="M" required <?php echo $masculino; ?> /> - 
              Femenino <input type="radio" name="data[gender]" value="F" required <?php echo $femenino; ?> />
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('DNI'); ?></label>
            <div class="controls">
              <input type="text" id="" name="data[dni]" value="<?php echo (isset($usuario)) ? $usuario['User']['dni'] : ''; ?>" required>
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Newsletter'); ?></label>
            <div class="controls">
              <?php
                $news = (isset($usuario) && $usuario['User']['newsletter'] == '1') ? 'checked' : '';
                $no_news = (isset($usuario) && $usuario['User']['newsletter'] == '0') ? 'checked' : '';
              ?>
              Si <input type="radio" name="data[newsletter]" value="1" <?php echo $news; ?> /> - 
              No <input type="radio" name="data[newsletter]" value="0" <?php echo $no_news; ?> />
            </div>
          </div>
          <br />
        </div>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Telefono'); ?></label>
            <div class="controls">
              <input type="text" id="" name="data[telephone]" value="<?php echo (isset($usuario)) ? $usuario['User']['telephone'] : ''; ?>">
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Otro telefono'); ?></label>
            <div class="controls">
              <input type="text" id="" name="data[another_telephone]" value="<?php echo (isset($usuario)) ? $usuario['User']['another_telephone'] : ''; ?>">
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Dirección'); ?></label>
            <div class="controls">
              <input type="text" id="" name="data[address]" value="<?php echo (isset($usuario)) ? $usuario['User']['address'] : ''; ?>">
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Provincia'); ?></label>
            <div class="controls">
                <select id="provincia" class="selectpicker" name="data[province]">
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
              <input type="text" id="" name="data[city]" value="<?php echo (isset($usuario)) ? $usuario['User']['city'] : ''; ?>">
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Barrio'); ?></label>
            <div class="controls">
              <input type="text" id="" name="data[neighborhood]" value="<?php echo (isset($usuario)) ? $usuario['User']['neighborhood'] : ''; ?>">
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Código Postal'); ?></label>
            <div class="controls">
              <input type="text" id="" name="data[postal_address]" value="<?php echo (isset($usuario)) ? $usuario['User']['postal_address'] : ''; ?>">
            </div>
          </div>
          <br />
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('¿Es administrador?'); ?></label>
            <div class="controls">
              <?php
                $admin = (isset($usuario) && $usuario['User']['role'] == 'admin') ? 'checked' : '';
                $regular = (isset($usuario) && $usuario['User']['role'] != 'admin') ? 'checked' : '';
              ?>
              Si <input type="radio" name="data[role]" value="admin" <?php echo $admin ?> /> - 
              No <input type="radio" name="data[role]" value="" <?php echo $regular ?> />
            </div>
          </div>
          <br />
        </div>              
      </div>      
      <br />               
      <div class="form-actions">
        <button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> Reset</button>
        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Submit</button>
      </div>
    </form>
  </div>
</div>