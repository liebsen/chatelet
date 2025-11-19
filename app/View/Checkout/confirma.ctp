<?php 
	echo $this->Session->flash(); 
	$this->set('short_header', 'Checkout');
	$this->set('short_header_text', '← Volver a pago'); 
	$this->set('short_header_link', '/checkout/pago');	

?>
<section id="main" class="has-checkout-steps container animated fadeIn delay min-h-101">
	<?php echo $this->element('checkout-steps') ?>
	<div class="wrapper d-flex flex-column justify-content-center align-items-center gap-1">
		<div class="animated fadeIn delay">
			<div class="is-flex flex-column-sm justify-content-center align-items-start gap-1">
				<div class="card p-4 p-md-5 max-25">
					<div class="card-body">
						<div class="d-flex flex-column justify-content-start align-items-center gap-05">
							<h2 class="text-bolder">Hola, <?php echo $user['name'] ?? 'Invitada'; ?>!</h2>
							<p>Confirma tu compra de <?php echo \price_format($cart_totals['grand_total']) ?>.</p>
							<?php echo $this->Form->create('confirma_form', array(
								'id' => 'confirma_form',
								'url' => array(
									'controller' => 'checkout', 
									'action' => 'sale'
								)
							)); ?>
							<div class="d-flex flex-column justify-content-start align-items-center gap-05">
								<input type="submit" class="btn btn-chatelet btn-confirm dark w-100" value="Confirmar compra" />
								<span class="text-sm text-muted"><b>Al finalizar el proceso</b> revisa tu cuenta en <b><?php echo $user['email']; ?></b></span>
							</div>
							<?php echo $this->Form->end(); ?>	
						</div>
						<!--script>
							setTimeout(function(){
								location.href = '/checkout/envio'
							}, 3000)
						</script-->
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
