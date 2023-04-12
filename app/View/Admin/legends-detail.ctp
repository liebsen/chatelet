<?php echo $this->element('admin-menu');?>
<div class="block block-themed">
  <div class="block-title">
    <h4><?php 
      echo (isset($item)) ? __('Editar Financiación') : __('Agregar Financiación');
    ?></h4>
  </div>

  <div class="block-content">
    <form action="" method="post" class="form-inline" enctype="multipart/form-data">
      <?php
        if (isset($this->request->pass[1])) {
          echo '<input type="hidden" name="data[id]" value="'. htmlspecialchars($this->request->pass[1]) .'" />';
        }
      ?>
      <div class="row">
        <div class="col-md-6">
          <div class="control-group">
            <!--label class="control-label" for="columns-text"><?php echo __('Estado'); ?></label-->
            <div class="controls text-center switch-scale">
              <?php
                $enabled = (isset($item) && $item['Legend']['enabled'] == 1) || !isset($item) ? 'checked' : '';
                $disabled = (isset($item) && $item['Legend']['enabled'] == 0) ? 'checked' : '';
              ?>
              <label for="enabled_1">Activo</label> <input type="radio" class="form-control" id="enabled_1" name="data[enabled]" value="1" <?php echo $enabled; ?> /> &nbsp; 
              <label for="enabled_0">Inactivo</label> <input type="radio" class="form-control" id="enabled_0" name="data[enabled]" value="0" <?php echo $disabled; ?> />
            </div>
            <!--small class="text-muted">Estado principal de este Legend</small-->
          </div>          
          <h4 class="sub-header">Información Principal</h4>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Título'); ?></label>
            <div class="controls">
              <textarea class="form-control" name="data[title]"><?php echo (isset($item)) ? $item['Legend']['title'] : ''; ?></textarea>
              <!--input class="form-control" type="text" id="" name="data[title]" value="<?php echo (isset($item)) ? $item['Legend']['title'] : ''; ?>" required-->
            </div>
            <small class="text-muted">Podés usar las variables: {cuotas}, {interes} y {monto}. Ej: {cuotas} cuotas de ${monto}</small>
          </div>

          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Cuotas'); ?></label>
            <div class="controls">
              <input class="form-control" type="number" id="" name="data[dues]" value="<?php echo (isset($item)) ? $item['Legend']['dues'] : ''; ?>" required>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Interés'); ?></label>
            <div class="controls">
              <input class="form-control" type="number" step="any" id="" name="data[interest]" value="<?php echo (isset($item)) ? $item['Legend']['interest'] : ''; ?>" required>
            </div>
            <small class="text-muted">Interés de las cuotas expresado en porcentaje. Ej: 10%</small>
          </div>
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Monto mínimo'); ?></label>
            <div class="controls">
              <input class="form-control" type="number" step="any" id="" name="data[min_sale]" value="<?php echo (isset($item)) ? $item['Legend']['min_sale'] : ''; ?>" required>
            </div>
            <small class="text-muted">Monto mínimo de la compra expresado en valores nominales. Ej: 50.000ARS</small>
          </div>

          <br />
        </div>
        <div class="col-md-6">
          <div class="control-group">
            <label class="control-label" for="columns-text"><?php echo __('Ordenar'); ?></label>
            <div class="controls">
              <input class="form-control" type="number" name="data[ordernum]" value="<?=  !empty($item) ? $item['Legend']['ordernum'] : '100' ?>">
            </div>
            <small class="text-muted">Seleccioná el orden de prioridad para esta legend</small>
          </div>
          <br />
        </div>  
        <br />              
      </div>      
      <br />               
      <div class="form-actions">
        <a href="/admin/legends" class="btn btn-info"><i class="icon-repeat"></i> Atrás</a>
        <button type="reset" class="btn btn-danger"><i class="icon-repeat"></i> Reset</button>
        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Submit</button>
      </div>
    </form>
  </div>
</div>