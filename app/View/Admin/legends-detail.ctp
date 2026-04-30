<?php 
echo $this->Html->script('application-form.js?v=' . $version['ver'], array('inline' => false)); 
echo $this->element('admin/menu');
?>
<div class="block-section">
  <div class="block-tabs">
    <div class="tab-content">
      <form action="" id="form_app" method="post" class="form-inline" enctype="multipart/form-data">
        <?php
          if (isset($this->request->pass[1])) {
            echo '<input type="hidden" name="data[id]" value="'. htmlspecialchars($this->request->pass[1]) .'" />';
          }
        ?>
        <div class="row">
          <div class="col-md-6">
            <h4 class="sub-header">Estado</h4>
            <div class="form-group">
              <label class="control-label" for="columns-text"><?php echo __('Activo'); ?></label>
              <input type="checkbox" name="data[enabled]" value="1" id="toggle" class="toggle-checkbox"<?= @$item['Legend']['enabled'] == '1' ? ' checked' : '' ?>>
              <label for="toggle" class="toggle-label"></label>
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
          </div>
          <div class="col-md-6">
            <h4 class="sub-header">Detalles</h4>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Cuotas'); ?></label>
              <div class="controls">
                <input class="form-control w-100" type="number" id="" name="data[dues]" value="<?php echo (isset($item)) ? $item['Legend']['dues'] : ''; ?>" required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Interés'); ?></label>
              <div class="controls">
                <input class="form-control w-100" type="number" step="any" id="" name="data[interest]" value="<?php echo (isset($item)) ? $item['Legend']['interest'] : ''; ?>" required>
              </div>
              <small class="text-muted">Interés de las cuotas expresado en porcentaje. Ej: 10%</small>
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Monto mínimo'); ?></label>
              <div class="controls">
                <input class="form-control w-100" type="number" step="any" id="" name="data[min_sale]" value="<?php echo (isset($item)) ? $item['Legend']['min_sale'] : ''; ?>" required>
              </div>
              <small class="text-muted">Monto mínimo de la compra expresado en valores nominales. Ej: 50.000ARS</small>
            </div>
            <div class="control-group">
              <label class="control-label" for="columns-text"><?php echo __('Ordenar'); ?></label>
              <div class="controls">
                <input class="form-control w-100" type="number" name="data[ordernum]" value="<?=  !empty($item) ? $item['Legend']['ordernum'] : '100' ?>">
              </div>
              <small class="text-muted">Seleccioná el orden de prioridad para esta legend</small>
            </div>
            <br />
          </div>  
          <br />              
        </div>      
        <br />               
        <div class="form-actions">
          <a href="/admin/legends" class="btn btn-info"><i class="fa fa-chevron-left"></i> <span class="ml-1">Atrás</span></a>
          <button type="reset" class="btn btn-danger" title="Limpia el formulario actual y deshace cualquier cambio hecho previamente"><i class="fa fa-close"></i> <span class="ml-1">Restaurar</span></button>
          <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check"></i> <span class="ml-1">Guardar</span></button>
        </div>
      </form>
    </div>
  </div>
</div>