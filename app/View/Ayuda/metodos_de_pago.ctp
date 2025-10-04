<?php $this->Html->script('ayuda', array('inline' => false)); ?>

          <div id="headhelp">
            <?php echo $this->element('navbar-ayuda'); ?>
            <div class="wrapper">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-xs-12 col-md-4">
                        <div class="animated fadeIn delay2">
                            <h1>Formas<br>de pago</h1>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-8 pr-2-d">
                        <div class="animated scaleIn delay box-cont">
                            <div class="box img-bg" style="background-image: url('/img/pago.jpg')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <section id="desarrollo">
            <div class="wrapper  animated fadeIn delay25 text-center"> 
                <img src="<?php echo Router::url('/',true).'images/tjtas.png'; ?>"><br>
                <small>Si tu pago es por medio de una transferencia bancaria, mercado pago te facilitará los datos necesarios.</small>
            </div>
        </section>

        <section id="desarrollo">
            <div class="wrapper">
                <div class="col-xs-12 col-md-6">
                    <h3>Comprá en Châtelet con tu método preferido</h3>
                    <ul>
                        <li class="mb-8">* Podés pagar a través de la plataforma de pago MercadoPago. Si tu elección es realizarlo con tarjeta de crédito o débito (VISA, MASTERCARD, AMERICAN EXPRESS, TARJETA NARANJA, CABAL, ETC) MercadoPago solicitará los datos necesarios y podrá enviarte una confirmación para que puedas validarla por cuestiones de seguridad.</li>
                        <li class="mb-8">** Transferencia bancaria: Al finalizar el pedido en pantalla te aparecerán los datos bancarios e importe final para que puedas transferir. Recordá siempre enviarnos el comprobante por WhatsApp al 11-5504-2428</li>
                        <li>*** Pagos a través de RapiPago, Pago Fácil o Bapro: MercadoPago solicitará datos básicos para poder emitir la boleta correspondiente y que la puedas imprimir y abonar en cualquier centro de pago autorizado.</li>
                        <!--li>***El pago se acredita en el momento por lo que tu pedido será despachado en 24 hs. En todos los casos CHATELET te mantendrá informado sobre el estado del pedido y el tiempo de acreditación del pago dependerá del sistema que seleccione el cliente.</li>
                        <li>*** Las prendas no tienen cambio.</li>
                        <li>*** Los envíos por compra online tienen una demora de 7 a 10 días hábiles.</li-->
                    </ul>
                </div>
                <div class="col-xs-12 col-md-6"></div>
            </div>
        </section>
