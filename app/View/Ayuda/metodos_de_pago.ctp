<?php
	$this->Html->css('ayuda', array('inline' => false));
?>
<div id="main" class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<?php
				echo $this->element('ayuda-menu');
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-md-offset-3 content">
			<h1 class="metodos-de-pago">Metodos de pago</h1>
			<p>
				Todos los pagos se realizan a través de mercado pago. Si tu elección es realizarlo con tarjeta de crédito (*) (VISA, MasterCard, Argencard, American Express, Tarjeta Naranja, Cabal, Tarjeta Shopping e Italcred) mercado pago solicitará los datos necesarios y podrá enviarte una confirmación para que puedas validarla por cuestiones de seguridad. 
			</p>

			<p>
				Pagos a través de RapiPago o Pago Fácil o Bapro (**), mercado pago solicitará datos básicos para poder emitir la boleta correspondiente y que la puedas imprimir y abonar en cualquier centro de pago autorizado.
			</p>

			<p>
				Si tu pago es por medio de una transferencia bancaria, mercado pago te facilitará los datos necesarios.
			</p>

			<div class="metodos-de-pago">
				<a href="https://www.mercadopago.com/" target="_blank">
					<?php
						echo $this->Html->image('mercadopago.png', array('class' => 'img-responsive inline-block'));
					?>
				</a>
			</div>
			<p>
                <small>
                    * Pagando con las tarjetas de crédito habilitadas tu pedido será reservado por un periodo de 24 hs y quedaremos a la espera de la confirmación de la operación por parte de mercado pago.
                </small>
            </p>

            <p>
                <small>
                    ** Abonando en RapiPago, Pago Fácil o Bapro, el pedido será reservado por un periodo de 24/48 hs. Transcurrido ese tiempo, la reserva caducará y tu pedido será cancelado.
                    <br />Cuánto antes realices el pago, antes podrás recibirlo en tu domicilio!
                </small>
            </p>

            <p>
                <small>
                    ***El pago se acredita en el momento por lo que tu pedido será despachado en 24 hs. En todos los casos CHATELET te mantendrá informado sobre el estado del pedido y
                    <br />el tiempo de acreditación del pago dependerá del sistema que seleccione el cliente.
                </small>
            </p>

            <p>
                <small>
                    *** Las prendas no tienen cambio. 
                </small>
            </p>

            <p>
                <small>
                    *** Las prendas que estan en el Shop como principal en cada rubro no estan a la venta.
                </small>
            </p>
			<div class="clearfix" style="height:40px;"></div>
		</div>
	</div>
</div>