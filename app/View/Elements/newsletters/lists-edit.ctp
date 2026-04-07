<?php
	// echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
  echo $this->Html->script('relations.js?v=' . $version['ver'], array('inline' => false));
	echo $this->Html->script('lists-edit.js?v=' . $version['ver'], array('inline' => false));
	echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
	echo $this->Html->css('bootstrap-datepicker');
  echo $this->Form->create(null, array(
  'class' => 'w-100',
  'id' => 'list_edit',
)); ?>
  <input type="hidden" name="x_coord" id="x_coord">
  <input type="hidden" name="y_coord" id="y_coord">
  <input type="hidden" name="redirect" value="/admin/newsletters/lists"/>
  <input type="hidden" name="data[id]" value="<?= $list['NewsletterList']['id'] ?? 0 ?>"/>
  <div class="row">
    <div class="col-md-6">
      <h4 class="sub-header"><?=$list['NewsletterList']['name'] ?? 'Crea nueva Lista'?></h4>
      <p>Configura el alcance para esta Lista</p>
      <div class="form-group flex-between gap-05">
        <div class="controls flex-1">
          <label class="control-label" for="toggle">Activo</label>
          <input type="checkbox" name="data[enabled]" value="1" id="toggle" class="toggle-checkbox"<?=@$list['NewsletterList']['enabled'] == '1' ? ' checked' : '' ?>>
          <label for="toggle" class="toggle-label"></label>
        </div>
<?php if(!empty($list_users)): ?>
        <a href="javascript:void(0)" onclick="$('.table-main:not(.table-users)').hide();$('.table-users').toggle()">
          <span class="badge badge-<?=count($list_users) ? 'info' : 'light' ?> is-rounded is-large"><?php echo count($list_users) ?></span></a>
        </a>
<?php endif ?>      
      </div>
      <div class="table-main table-users bg-info d-none">
        <h4 class="sub-header"><i class="gi gi-cogwheel is-clickable" onclick="$('#user-filter').focus()"></i> Cuentas</h4>
        <table class="table table-forum">
    <?php foreach($list_users as $user): ?>
          <tr><td><?php echo $user['User']['name']?> <?php echo $user['User']['surname']?> (<span class="text-lowercase"><?php echo $user['User']['email']?></span>)</td></tr>
  <?php endforeach ?>
       </table>
      </div>
      <h4 class="sub-header">Datos de la lista</h4>
      <p>Datos básicos de la lista</p>
      <div class="control-group">
        <label class="control-label" for="title">Título</label>
        <div class="controls">
          <input type="text" id="title" name="data[name]" class="form-control" placeholder="Título de la lista" value="<?=$list['NewsletterList']['name']?>" required />
        </div>
        <small class="text-muted">Es el nombre con que identificas esta lista</small>
      </div>
      <!--label class="control-label" for="products-filter">Filtros en historial de compras</label-->
      <div class="controls-group">
        <textarea class="form-control w-100" name="data[text]" id="newsletter" rows="4"><?=$list['NewsletterList']['text']?></textarea>
      </div>


<?php if(!empty($list['NewsletterList']['id'])):?>         
      <h4 class="sub-header">Filtros por compra</h4>
      <p>Establece fecha y monto para filtrar por cuenta de acuerdo al historial de compras</p>
      <div class="control-group">
        <label class="control-label" for="myRange2">Periodo de evaluación (Desde / Hasta)</label>
        <div class="controls d-flex flex-center gap-05">
          <input type="text" name="data[filter][date_min]" class="form-control advanced-filter datepicker" data-name="min_date" placeholder="Fecha mínima" value="<?=$list['NewsletterList']['filter']->date_min ?? ''?>"/>
          <input type="text" name="data[filter][date_max]" class="form-control advanced-filter datepicker" data-name="max_date" placeholder="Fecha máxima" value="<?=$list['NewsletterList']['filter']->date_max ?? ''?>"/>
        </div>
      </div>
      <!--label class="control-label" for="products-filter">Filtros en historial de compras</label-->
      <div class="controls-group">
        <label class="control-label" for="minSale">Mínimo de compra</label>
        <input type="range" class="advanced-filter" data-name="min_sale" name="data[filter][min_sale]" step="10" min="10" max="10000" value="<?=$list['NewsletterList']['filter']->min_sale?>">
      </div>
      <h4 class="sub-header">Filtro por fecha de nacimiento</h4>
      <p>Establece fecha para filtrar por cuenta de acuerdo fecha de nacimiento</p>
      <div class="control-group">
        <label class="control-label" for="myRange2">Día de nacimiento (Desde / Hasta)</label>
        <div class="controls d-flex flex-center gap-05">
          <input type="text" id="minDob" name="data[filter][dob_min]" class="form-control datepicker" data-format="dd/mm" data-name="mindob-value" placeholder="Día de nacimiento mínimo" value="<?=$list['NewsletterList']['filter']->dob_min ?? ''?>"/>
          <input type="text" id="maxDob" name="data[filter][dob_max]" class="form-control datepicker" data-format="dd/mm" data-name="maxdob-value" placeholder="Día de nacimiento max" value="<?=$list['NewsletterList']['filter']->dob_max ?? ''?>"/>
        </div>
      </div>
<?php endif ?>      
    </div>
    <div class="col-md-6">
      <h4 class="sub-header">Resumen</h4>
      <table class="table table-forum table-striped text-small">
        <tr>
          <td><small>Periodo de evaluación</small></td>
          <th><span class="min_date-value"><?= $list['NewsletterList']['filter']->date_min?></span> - <span class="max_date-value"><?= $list['NewsletterList']['filter']->date_max?></span></th>
        </tr>
        <tr>
          <td><small>Mínimo de compra</small></td>
          <th><span class="min_sale-value"><?= $list['NewsletterList']['filter']->sale_min?></span></th>
        </tr>
        <tr>
          <td><small>Cuentas seleccionadas</small></td>
          <th>
            <span class="user-count"><?= count($list_users)?></span>
          </th>
        </tr>
      </table>      
<?php if(!empty($list['NewsletterList']['id'])):?>
      <div class="form-box bg-info">
        <h4 class="sub-header">Cuentas seleccionadas (<?=count($list_users)?>)</h4>
        <div class="factsheet">
          <a class="relations-action-add text-success is-clickable d-none" data-type="user" href="javascript:void(0)">Agregar <span class="relations-count"><?=count($list_users)?></span></a>
          <?php if(count($list_users)): ?>
          <a class="relations-action-remove text-danger is-clickable" data-type="user" href="javascript:void(0)">Eliminar todo</a>
          <?php endif ?>

          <a class="relations-action-add is-clickable" data-type="user" data-model="NewsletterUser" data-source="list" data-key="all" data-parent-id="<?= $list['NewsletterList']['id'] ?>">Seleccionar todos (<?=$users_total?>)</a>          
        </h4>
        <p>Selecciona las cuentas que deseas para esta lista</p>
        <div class="controls d-flex flex-column gap-05">
          <input type="text" class="form-control relation-search" data-type="user" placeholder="Buscar cuenta..."/>
        </div>          
        <div class="controls tags-container user-container">
  <?php foreach($list_users as $user): ?>
    <span 
      class="label relation-item is-clickable text-lowercase is-enabled" 
      data-parent-id="<?php echo $list['NewsletterList']['id'] ?>" 
      data-id="<?=$user['User']['id']?>"
      data-type="user"
      data-source="list"
      data-model="NewsletterUser"><?php echo $user['User']['email']?>
    </span>
  <?php endforeach ?>
        </div>
  <?php endif ?>

      </div>
    </div>
  </div>
  <div class="form-actions">
    <a href="javascript:history.go(-1)" class="btn btn-info">
      <i class="fa fa-chevron-left mr-1"></i> Atrás
    </a>
    <button type="submit" name="save" class="btn btn-success track-coords" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
  </div>
<?php echo $this->Form->end(); ?>