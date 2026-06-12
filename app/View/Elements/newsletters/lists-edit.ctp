<?php
	// echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
  echo $this->Html->script('relations.js?v=' . $version['ver'], array('inline' => false));
	echo $this->Html->script('lists-edit.js?v=' . $version['ver'], array('inline' => false));
  echo $this->Html->script('form_app.js?v=' . $version['ver'], array('inline' => false));
	echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
	echo $this->Html->css('bootstrap-datepicker');
  echo $this->Form->create(null, array(
  'class' => 'w-100',
  'id' => 'form_app',
)); 
?>
  <input type="hidden" name="x_coord" id="x_coord">
  <input type="hidden" name="y_coord" id="y_coord">
  <input type="hidden" name="redirect" value="/admin/newsletters/lists"/>
  <input type="hidden" name="search_mode" value=""/>
  <input type="hidden" name="data[id]" value="<?= $list['NewsletterList']['id'] ?? 0 ?>"/>
  <div class="row">
    <div class="col-md-6">
      <h4 class="sub-header"><?=$list['NewsletterList']['name'] ?? 'Crea nueva Lista'?></h4>
      <p>Configura el alcance para esta Lista</p>
      <div class="form-group flex-end flex-between gap-05">
        <div class="controls flex-1">
          <label class="control-label" for="toggle">Activo</label>
          <input type="checkbox" name="data[enabled]" value="1" id="toggle" class="toggle-checkbox"<?=@$list['NewsletterList']['enabled'] == '1' ? ' checked' : (!empty($list['NewsletterList']['id']) ? '' : ' data-change="1" checked')?>>
          <label for="toggle" class="toggle-label"></label>
        </div>
<?php if(!empty($list_users)): ?>
        <a href="javascript:void(0)" onclick="$('.table-main:not(.table-users)').hide();$('.table-users').toggle()">
          <span class="badge badge-<?=count($list_users) ? 'info' : 'light' ?> is-rounded is-large"><?php echo count($list_users) ?></span></a>
        </a>
<?php endif ?>      
      </div>
      <div class="table-main table-users bg-info d-none">
        <h4 class="sub-header"><i class="gi gi-cogwheel is-clickable" onclick="$('#user-filter').focus()"></i> Clientas</h4>
        <table class="table table-forum">
    <?php foreach($list_users as $user): ?>
          <tr><td><?php echo $user['User']['name']?> <?php echo $user['User']['surname']?> (<span class="text-lowercase"><?php echo strstr($user['User']['email'],'@',true)?></span>)</td></tr>
  <?php endforeach ?>
       </table>
      </div>
      <div class="form-box bg-info-outline">
        <h4 class="sub-header">Datos de la lista</h4>
        <p>Datos básicos de la lista</p>
        <div class="control-group">
          <label class="control-label" for="title">Título</label>
          <div class="controls">
            <input type="text" id="title" name="data[name]" class="form-control" placeholder="Título de la lista" value="<?=$list['NewsletterList']['name']?>" required />
          </div>
          <small class="text-muted">Es el nombre con que identificas esta lista. <i class="gi gi-lightbulb"></i> <span class="text-theme text-italic pl-1">Cumpleaños Abril, Compras Mayo, etc...</span></small>
        </div>
        <!--label class="control-label" for="products-filter">Filtros en historial de compras</label-->
        <div class="controls-group mb-4">
          <label class="control-label" for="title">Descripción</label>
          <textarea class="form-control w-100" name="data[text]" id="newsletter" rows="4"><?=$list['NewsletterList']['text']?></textarea>
        </div>
      </div>
    </div>
    <div class="col-md-6 <?=!empty($list['NewsletterList']['id'])?'':' d-disable'?>">
      <div class="form-box bg-info-outline">
        <h4 class="sub-header">Resumen</h4>
        <table class="table table-forum table-striped text-small w-100">
          <tr>
            <td><small>Filtro</small></td>
            <th><span class="filter-type-value"><?= !empty($list['NewsletterList']['filter']->filter->type) ? $list['NewsletterList']['filter']->filter->type : 'ND'?></span></th>
          </tr>
          <tr class="filter-item filter-sales filter-carts">
            <td><small>Periodo de evaluación</small></td>
            <th><span class="date_min-value"><?= !empty($list['NewsletterList']['filter']->filter->date_min) ? $list['NewsletterList']['filter']->filter->date_min : 'ND'?></span> - <span class="date_max-value"><?= !empty($list['NewsletterList']['filter']->filter->date_max) ? $list['NewsletterList']['filter']->filter->date_max : 'ND'?></span></th>
          </tr>
          <tr class="filter-item filter-dob">
            <td><small>Fecha de cumpleaños</small></td>
            <th><span class="dob_min-value"><?= !empty($list['NewsletterList']['filter']->filter->dob_min) ? $list['NewsletterList']['filter']->filter->dob_min : 'ND'?></span> - <span class="dob_max-value"><?= !empty($list['NewsletterList']['filter']->filter->dob_max) ? $list['NewsletterList']['filter']->filter->dob_max : 'ND'?></span></th>
          </tr>
          <tr class="filter-item filter-sales filter-carts">
            <td><small>Mínimo de compra</small></td>
            <th><span class="min_sale-value"><?=\price_format((int) $list['NewsletterList']['filter']->filter->sale_min * 100)?></span></th>
          </tr>
          <tr>
            <td><small>Clientas seleccionadas</small></td>
            <th>
              <span class="user-count"><?= count($list_users)?></span>
            </th>
          </tr>
        </table>
      </div>
      <div class="form-box bg-success-outline">
        <h4 class="sub-header">Filtros</h4>
        <div class="controls mb-4">
          <label class="control-label" for="title">Implementa módulos Usuario, Ventas y Estadísticas</label>
          <select class="form-control filter-type advanced-filter" name="data[filter][type]" data-name="type">
            <option value="">Seleccione un filtro</option>
            <option value="sales" data-target="sales"<?=$list['NewsletterList']['filter']->filter->type == 'sales' ? ' selected' : ''?>>Compras</option>
            <option value="carts" data-target="sales"<?=$list['NewsletterList']['filter']->filter->type == 'carts' ? ' selected' : ''?>>Carrito abandonado</option>
            <option value="dob" data-target="dob"<?=$list['NewsletterList']['filter']->filter->type == 'dob' ? ' selected' : ''?>>Cumpleaños</option>
          </select>
        </div>
        <div class="filter-box filter-item filter-sales<?=in_array($list['NewsletterList']['filter']->filter->type, array('sales', 'carts')) ? ' ' : ' d-none '?>mb-4">
          <p>Establece fecha y monto para filtrar por cuenta de acuerdo al historial de compras</p>
          <div class="control-group">
            <label class="control-label" for="myRange2">Periodo de evaluación (Desde / Hasta)</label>
            <div class="controls d-flex flex-center gap-05">
              <input type="text" name="data[filter][date_min]" class="form-control advanced-filter datepicker" data-name="date_min" placeholder="Fecha mínima" value="<?=$list['NewsletterList']['filter']->filter->date_min ?? ''?>"  autocomplete="off" />
              <input type="text" name="data[filter][date_max]" class="form-control advanced-filter datepicker" data-name="date_max" placeholder="Fecha máxima" value="<?=$list['NewsletterList']['filter']->filter->date_max ?? ''?>"  autocomplete="off" />
            </div>
          </div>
          <div class="controls-group">
            <label class="control-label" for="minSale">Mínimo de compra</label>
            <input type="range" class="advanced-filter" data-name="sale_min" name="data[filter][sale_min]" step="10" min="10" max="10000" value="<?=$list['NewsletterList']['filter']->filter->sale_min?>">
          </div>
        </div>
        <div class="filter-box filter-item filter-dob<?=$list['NewsletterList']['filter']->filter->type == 'dob' ? ' ' : ' d-none '?>mb-4">
          <p>Establece fecha para filtrar por cuenta de acuerdo fecha de nacimiento</p>
          <div class="control-group">
            <label class="control-label" for="myRange2">Día de nacimiento (Desde / Hasta)</label>
            <div class="controls d-flex flex-center gap-05">
              <input type="text" id="minDob" name="data[filter][dob_min]" class="form-control advanced-filter datepicker" data-format="dd/mm" data-name="dob_min" placeholder="Día de nacimiento mínimo" value="<?=$list['NewsletterList']['filter']->filter->dob_min ?? ''?>"  autocomplete="off" />
              <input type="text" id="maxDob" name="data[filter][dob_max]" class="form-control advanced-filter datepicker" data-format="dd/mm" data-name="dob_max" placeholder="Día de nacimiento max" value="<?=$list['NewsletterList']['filter']->filter->dob_max ?? ''?>"  autocomplete="off" />
            </div>
          </div>
        </div>
      </div>
      <div class="form-box bg-info-outline">
        <h4 class="sub-header">Clientas seleccionadas (<?=count($list_users)?>)</h4>
        <p>Selecciona las clientas que deseas para esta lista</p>
        <div class="controls d-flex flex-column gap-05">
          <input type="text" class="form-control relation-search" data-type="user" placeholder="Buscar cuenta..."/>
        </div>
        <div class="secondary-box">
          <a class="secondary-success relations-add relations-add-single is-clickable d-none" data-type="user" data-parent-id="<?=$list['NewsletterList']['id']?>" href="javascript:void(0)">
            <i class="gi gi-plus mr-2"></i>
            <span>Agregar <span class="relations-count"><?=count($list_users)?></span></span>
          </a>
          <a class="secondary-danger relations-remove is-clickable<?=count($list_users)?'':' d-none'?>" data-type="user" data-model="NewsletterUser" data-source="list" data-key="all" data-parent-id="<?=$list['NewsletterList']['id']?>" href="javascript:void(0)">
            <i class="fa fa-trash mr-2"></i>
            <span>Eliminar todo</span>
          </a>
          <a class="secondary-success relations-add-dialog relations-add-all is-clickable">
            <i class="gi gi-plus mr-2"></i> <span>Seleccionar todos (<?=$users_total?>)</span>
          </a>
        </div>
        <div class="controls tags-container user-container">
  <?php foreach($list_users as $user): ?>
    <span 
      class="label relation-item is-clickable text-lowercase is-enabled" 
      data-parent-id="<?php echo $list['NewsletterList']['id'] ?>" 
      data-id="<?=$user['User']['id']?>"
      data-type="user"
      data-source="list"
      title="<?=implode("\n", 
        array(
          implode(" ", 
            array(
              $user['User']['name'],
              $user['User']['surname']
            )
          ),
          strtolower($user['User']['email'])
        )
      )?>"
      data-model="NewsletterUser"><?php echo strstr($user['User']['email'],'@',true)?>
    </span>
  <?php endforeach ?>
        </div>
      </div>
    </div>
  </div>
  <div class="form-actions">
    <a href="<?=$this->Html->url(
      array(
        'controller' => 'admin',
        'action' => 'newsletters',
        'lists'
      )
    )?>" class="btn btn-info">
      <i class="fa fa-chevron-left mr-1"></i> Atrás
    </a>
    <button type="submit" name="save" class="btn btn-success track-coords" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
  </div>
<?php echo $this->Form->end(); ?>
<div id="relations-add-dialog" class="d-none">
  <div class="controls flex-1">
    <!--label class="control-label" for="">Deseas agrupar la audiencia</label-->
    <input type="checkbox" name="toggle_split" value="0" id="toggle_reset" class="toggle-checkbox">
    <label for="toggle_split" class="toggle-label toggle-split"></label>
    <small class="text-muted toggle-split-desc">Si activas esta opción se crearán varios grupos de acuerdo a la cantidad que desees.</small>
    <div class="toggle-split-area d-none">
      <label class="control-label" for="title">Tamaño de las muestras</label>
      <div class="controls">
        <input type="number" name="data[filter][audienceMax]" class="form-control relation-audience-max" placeholder="Tamaño de las audiencias" value="<?=$list['NewsletterList']['filter']->filter->audienceMax ?? ''?>" required />
      </div>
      <small class="text-muted">Es el tamaño máximo de cuentas que contendrá cada lista nueva.</small>
    </div>
  </div>
  <div class="control-group d-flex justify-content-end">
    <button class="btn btn-success relations-add btn-persist" data-key="all" data-type="user" data-model="NewsletterUser" data-source="list" data-parent-id="<?= $list['NewsletterList']['id'] ?>" title="Pulsa aquí para agregar todos a la lista"><i class="fa fa-check mr-1"></i> Agregar todos</button>
  </div>
</div>