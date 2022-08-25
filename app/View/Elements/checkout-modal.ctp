<?php
	/*echo $this->Html->script('bootstrap-datepicker', array('inline' => false));
	echo $this->Html->script('mayorista-validation', array('inline' => false));*/
?>
<div class="modal fade" id="checkout-modal" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="modal-title">Carrito de Compras // <span class="grey">Proceso de compra</span></h4>
			</div>
			<div class="modal-body">
				<h4 class="checkout-title">Necesitás iniciar sesión para poder realizar una compra</h4>
				<p class="checkout-text">
					Por favor, <a href="#" class="pink login">inicie sesion</a> o <a href="#" class="pink" data-toggle="modal" data-target="#registro-modal">registrate con tu cuenta</a>.
				</p>
				<p>
					Si necesitas ayuda, ingresá a la sección 
					<?php 
						echo $this->Html->link('¿Cómo comprar?', 
							array(
								'controller' => 'ayuda',
								'action' => 'como_comprar'
							),
							array(
								'class' => 'pink'
							)
						);
					?>
				</p>
			</div>
		</div>
	</div>
</div>