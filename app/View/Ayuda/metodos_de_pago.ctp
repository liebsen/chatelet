<?php
	$this->Html->css('ayuda', array('inline' => false));
?>
  <div id="headhelp">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <h1>Métodos<br>de pago</h1>
                    </div>
                    <div class="col-md-6">
                        <div class="animated bounceIn delay1 p-2">
                            <div class="box w-leaves">                        
                                <h3>Comprá en Châtelet con tu método preferido</h3>
                                <p>Podés pagar desde tu casa a través de mercado pago o transferencia bancaria. Si tu elección es realizarlo con tarjeta de crédito (*) (<strong>VISA, MasterCard, Argencard, American Express, Tarjeta Naranja, Cabal, Tarjeta Shopping e Italcred</strong>) mercado pago solicitará los datos necesarios y podrá enviarte una confirmación para que puedas validarla por cuestiones de seguridad.</p>
                                <p>Pagos a través de RapiPago o Pago Fácil o Bapro (**), mercado pago solicitará datos básicos para poder emitir la boleta correspondiente y que la puedas imprimir y abonar en cualquier centro de pago autorizado.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section id="optionsHelp">
            <a href="/ayuda/como_comprar" >¿Cómo comprar?</a>
            <a href="/ayuda/envios">Envíos</a>
            <a href="/ayuda/metodos_de_pago" class="active">Métodos de pago</a>
            <a href="/ayuda/politicas_de_cambio">Políticas de cambio</a>
            <a href="/ayuda/faq" >Preguntas frecuentes</a>
        </section>

        <section id="desarrollo">
            <div class="wrapper text-center"> 
                <img src="<?php echo Router::url('/',true).'images/tjtas.png'; ?>"><br>
                <small>Si tu pago es por medio de una transferencia bancaria, mercado pago te facilitará los datos necesarios.</small>
            </div>
        </section>

        <section id="referncia">
            <div class="wrapper">
                <h3>Comprá en Châtelet con tu método preferido</h3>
                <ul>
                    <li>* Pagando con las tarjetas de crédito habilitadas tu pedido será reservado por un periodo de 24 hs y quedaremos a la espera de la confirmación de la operación por parte de mercado pago.</li>
                    <li>** Abonando en RapiPago, Pago Fácil o Bapro, el pedido será reservado por un periodo de 24/48 hs. Transcurrido ese tiempo, la reserva caducará y tu pedido será cancelado. Cuánto antes realices el pago, antes podrás recibirlo en tu domicilio!</li>
                    <!--li>***El pago se acredita en el momento por lo que tu pedido será despachado en 24 hs. En todos los casos CHATELET te mantendrá informado sobre el estado del pedido y el tiempo de acreditación del pago dependerá del sistema que seleccione el cliente.</li>
                    <li>*** Las prendas no tienen cambio.</li>
                    <li>*** Los envíos por compra online tienen una demora de 7 a 10 días hábiles.</li-->
                </ul>
            </div>
        </section>
