<?php echo $this->Html->script('handlebars-v2.0.0',array('inline'=>false)) ?>
<?php echo $this->Html->script('whatsapp',array('inline' => false)) ?>

<div class="block block-themed">
	<div class="block-title">
		<h4><?php echo __('Compra por WhatsApp') ?></h4>
	</div>

	<div class="block-content">
		<div class="row">
			<div class="col-xs-4">
				<form action="" method="post" class="form-inline" enctype="multipart/form-data">
					<div class="control-group">
						<label class="control-label" for="columns-text"><?php echo __('Seleccione una imagen'); ?></label>
						<div class="controls">
							<input type="file" name="data[Promo][image]" required value="" accept="image/*">
						</div>
					</div>
					<br />
					<div class="control-group">						
						<div class="controls">
							<button class="btn btn-primary" type="submit">Agregar Imagen</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-xs-8">
				<ul class="list-unstyled">
					<?php foreach ($items as $key => $item): ?>
					<li>
						<br />
						<img src="<?php echo Configure::read('imageUrlBase') . $item['Promo']['image'] ?>" width="200">
						<button class="btn btn-danger" onclick="window.location.href='<?php echo $this->Html->url(array('action'=>'remove_whatsapp',$item['Promo']['id'])) ?>'">x</button>
						<br />
					</li>
					<?php endforeach ?>
				</ul>
			</div>
		</div>
	</div>
</div>