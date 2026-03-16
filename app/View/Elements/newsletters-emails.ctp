<?php
	echo $this->Html->script('ckeditor/ckeditor', array('inline' => false));
	echo $this->Html->script('newsletters-composer.js?v=' . $version['ver'], array('inline' => false));
?>
<div class="block-section">
<?php if($action == 'create'): ?>
	<div class="row">
    <div class="col-md-12 w-100">
    	<div class="notification-controls w-100">
      	<div class="form-group w-100">
					<p class="text-theme">Compone tu email.</p>
      		<textarea class="form-control" id="newsletter" rows="8"></textarea>
					<h6 class="text-theme">Tabla de variables disponibles</h6>
					<table class="table table-striped">
<?php foreach($templateVars as $id => $name): ?>
				<tr class="is-clickable btn-append-editor" data-text="{{<?= $id ?>}}">
					<th>
						<small class="text-lowercase">
							<i class="fa fa-key text-warning"></i> <?= $id ?>
						</small>
					</th>
					<td>
						<small>
							<i class="gi gi-chat text-muted"></i> <?= $name ?>
						</small>
					</td>
				</tr>
<?php endforeach ?>
					</table>
      	</div>
      </div>
    </div>
  </div>
  <div class="form-actions">
    <a href="/admin/newsletters" class="btn btn-info"><i class="fa fa-chevron-left mr-1"></i> Atrás</a>
    <button type="submit" class="btn btn-success" title="Pulsa aquí para actualizar este formulario"><i class="fa fa-check mr-1"></i> Guardar</button>
  </div>  
<?php else: ?>

	<table id="example-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Título'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Estado'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
<?php foreach ($newsletters as $key => $newsletter): ?>        
			<tr>
				<td>
					<?=$newsletter['Newsletter']['title']?>
				</td>
				<td>
					<?=$newsletter['Newsletter']['status']??'waiting'?>
				</td>
				<td>            
					<a 
						href="#" 
						data-toggle="tooltip" 
						title="" 
						class="btn btn-danger deletebutton" 
						data-original-title="Eliminar" 
						data-id="<?=$newsletter['Newsletter']['id']?>" 
						data-url-back="<?=$this->Html->url(array('action'=>'newsletters'))?>" 
						data-delurl="<?=$this->Html->url(array('action'=>'newsletters', 'delete'))?>" 
						data-msg="<?=__('¿Eliminar Newsletter?')?>"                   
						>
						<i class="fa fa-trash-o"></i>
					</a>
					<a 
						href="<?=$this->Html->url(array('action'=>'newsletters', 'schedule', $newsletter['Newsletter']['id']))?>" 
						data-toggle="tooltip" 
						title="Programar envío" 
						class="btn btn-success" 
						>
						<i class="gi gi-send"></i>
					</a>
				</td>
			</tr>
<?php endforeach ?>
		</tbody>
	</table>
	<div class="form-actions">
		<a href="/admin/newsletters?extended=1">
      <button class="btn" type="button">Ver todo</button>
    </a>
	  <a class="btn btn-success dropdown-toggle" href="<?=$this->Html->url(array('action'=>'newsletters', 'emails', 'create'))?>">
	    <i class="gi gi-edit mr-1"></i> Componer
	  </a>
  </div>
<?php endif ?>
</div>
