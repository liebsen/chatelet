<?php echo $this->Html->script('oca.js?avoidcache=24',array( 'inline' => false )) ?>
<?php echo $this->Html->css('oca_front',array( 'inline' => false )) ?>
<script>window.freeShipping = <?=(int)@$freeShipping?>;</script>
<div class="row">
	<div class="col-xs-12">
		<h3 id="heading" style="margin:10px 0px">Costo de Envio // <span class="grey">Oca</span></h3>
		<strong>CP:</strong> <input type="text" name="" value="" id="cp" class="both" data-valid="0" data-url="<?php echo $this->Html->url(array('action'=>'delivery_cost')) ?>" />
		&nbsp;
		<span id="cost_container">
			<strong>$<span id="cost">0</span>.00</strong> <span id="free_delivery"></span>
		</span>
		<span id="loading" class="hide">
			<?php echo $this->Html->image('loader.gif',array('height'=>20)) ?>
		</span>
		<br />
		<p style="margin:10px 0px"><i><small>Ingrese su código postal</small></i></p>
	</div>
	<div class="col-xs-12">
		<br />
		<br />
	</div>
</div>

<script>
	let user_cp = '<?php echo $user['postal_address'];?>'
	if (user_cp) {
		$('#cp').val(user_cp)
	}
</script>
