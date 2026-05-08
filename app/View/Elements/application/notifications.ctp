<?php 
echo $this->Html->script('application-notifications.js?v=' . $version['ver'], array('inline' => false));
?>

<?php foreach($notification_settings as $id => $value):?>	
	<input type="hidden" name="data[<?=$id?>]" value="<?=$value?>">
<?php endforeach ?>

	<div class="row">
	  <div class="col-md-12">
	  	<h4 class="sub-header">Notificaciones de la tienda</h4>
	  	<p class="text-theme">Selecciona un tipo de notificación para editar. Todas las notificaciones se enviarán por correo electrónico.</p>
	  	<div class="controls">
		  	<select class="form-control" name="notification_tag" id="notification_tag" data-exclude="1">
		  		<option value="">Elige una notificación para continuar</option>
		  		<?php foreach($notification_tags as $key => $tag): ?>
		  			<option value="<?=$key?>"><?=$tag?></option>
		  		<?php endforeach ?> 
		  	</select>
		  </div>
	  </div>
	  <div class="col-md-12 w-100">
	  	<hr>
	  	<div class="notification-controls d-disable w-100">
	      <div class="control-group">
	        <label class="control-label" for="notification_title">Título</label>
	        <div class="controls">
	          <input type="text" name="notification_title" id="notification_title" class="form-control" placeholder="Título de la plantilla" value="<?=$newsletter['Newsletter']['title']?>" data-exclude="1" />
	        </div>
	      </div>				
	    	<div class="control-group">
	    		<label class="control-label" for="notification_text">Texto</label>
	    		<textarea class="form-control" id="notification_text" rows="8" data-exclude="1"></textarea>
	    	</div>
	    	<div class="form-group flex-column w-100">
					<h6 class="text-theme">Elementos de plantilla</h6>
					<table class="table table-striped w-100">
	<?php foreach($notification_sale_templates as $id => $name): ?>
				<tr class="is-clickable append-editor" data-text="{{<?= $id ?>}}" data-type="notification_sale">
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
	<?php foreach($notification_register_templates as $id => $name): ?>
				<tr class="is-clickable append-editor" data-text="{{<?= $id ?>}}" data-type="notification_register">
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

	<script type="text/javascript">
		var notification_settings = <?php echo json_encode($notification_settings) ?? '[]' ?>;
	</script>
