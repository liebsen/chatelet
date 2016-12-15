<div id="main" class="container">
	<?php foreach ($promos as $key => $promo): ?>
		<div class="row">
			<div class="col-xs-12 text-center">
				<br />
				<img class="img-responsive" src="<?php echo Configure::read('imageUrlBase').$promo['Promo']['image'] ?>" onError="this.onerror=null;this.src='<?php echo Configure::read('imageUrlBase').'img/promo_placeholder.png' ?>';" >
				<br />
			</div>
		</div>
	<?php endforeach ?>
	<?php if (!count($promos)): ?>
		<div class="row">
			<div class="col-xs-12 text-center">
				<br />
				<small><i>No hay promociones en este momento.</i></small>
				<br />
			</div>
		</div>
	<?php endif ?>
	<br />
</div>
