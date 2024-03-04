<?php
	$this->Html->css('ayuda', array('inline' => false));
?>

          <div id="headhelp">
            <?php echo $this->element('navbar-ayuda'); ?>
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-4">
                        <h1>Formas<br>de pago</h1>
                    </div>
                    <div class="col-md-8">
                        <div class="animated slideInRight delay box-cont">
                            <div class="box">                        
                                <h3>Comprá en Châtelet con tu método preferido</h3>
                                <p>Podés pagar desde tu casa a través de mercado pago o transferencia bancaria. Si tu elección es realizarlo con tarjeta de crédito (*) (<strong>VISA, MasterCard, Argencard, American Express, Tarjeta Naranja, Cabal, Tarjeta Shopping e Italcred</strong>) mercado pago solicitará los datos necesarios y podrá enviarte una confirmación para que puedas validarla por cuestiones de seguridad.</p>
                                <p>Pagos a través de RapiPago o Pago Fácil o Bapro (**), mercado pago solicitará datos básicos para poder emitir la boleta correspondiente y que la puedas imprimir y abonar en cualquier centro de pago autorizado.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <section id="desarrollo">
            <div class="wrapper text-center"> 
                <img src="<?php echo Router::url('/',true).'images/tjtas.png'; ?>"><br>
                <small>Si tu pago es por medio de una transferencia bancaria, mercado pago te facilitará los datos necesarios.</small>
            </div>
        </section>

        <section id="desarrollo">
            <div class="wrapper">
                <div class="col-sm-6">
                    <h3>Comprá en Châtelet con tu método preferido</h3>
                    <ul>
                        <li>* Podés pagar a través de la plataforma de pago MercadoPago. Si tu elección es realizarlo con tarjeta de crédito o débito (VISA, MASTERCARD, AMERICAN EXPRESS, TARJETA NARANJA, CABAL, ETC) MercadoPago solicitará los datos necesarios y podrá enviarte una confirmación para que puedas validarla por cuestiones de seguridad.</li>
                        <li>** Transferencia bancaria: Al finalizar el pedido en pantalla te aparecerán los datos bancarios e importe final para que puedas transferir. Recordá siempre enviarnos el comprobante por WhatsApp al 11-5504-2428</li>
                        <li>*** Pagos a través de RapiPago, Pago Fácil o Bapro: MercadoPago solicitará datos básicos para poder emitir la boleta correspondiente y que la puedas imprimir y abonar en cualquier centro de pago autorizado.</li>
                        <!--li>***El pago se acredita en el momento por lo que tu pedido será despachado en 24 hs. En todos los casos CHATELET te mantendrá informado sobre el estado del pedido y el tiempo de acreditación del pago dependerá del sistema que seleccione el cliente.</li>
                        <li>*** Las prendas no tienen cambio.</li>
                        <li>*** Los envíos por compra online tienen una demora de 7 a 10 días hábiles.</li-->
                    </ul>
                </div>
                <div class="col-sm-6"></div>
            </div>
        </section>
