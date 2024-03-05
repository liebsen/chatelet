<?php $this->Html->script('ayuda', array('inline' => false)); ?>

        <div id="headhelp">
            <?php echo $this->element('navbar-ayuda'); ?>
            <div class="wrapper">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-xs-12 col-md-4">
                        <div class="animated fadeIn delay2">
                            <h1>Envíos y <br>seguimiento</h1>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-8">
                        <div class="animated scaleIn delay box-cont">
                            <div class="box img-bg" style="background-image: url('/img/envio.jpg')"></div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>


        <section id="desarrollo">
            <div class="wrapper animated fadeIn delay25">
                <div class="row">
                    <div class="col-xs-12 col-md-6 boxes">
                        <div class="boxes-reframe">
                            <h3>Envío por OCA</h3>
                            <p>Los envíos se realizan a través de OCA en un plazo de entre 7 y 10 días hábiles (dependiendo de la región). Se puede hacer el seguimiento del mismo mediante un link que se envía al mail o podes seguir el estado del paquete ingresando en <a href="https://www.oca.com.ar/Busquedas/Envios" target="_blank" class="text-link">la página de búsqueda de envíos de OCA</a> ingresando el número de seguimiento que se te envió por mail.</p>

                            <p>En caso de no encontrarse a la hora de la visita se dejara un aviso, y se
realizara una segunda visita. Si nuevamente no hay nadie en el domicilio, el
paquete volverá a nuestra oficina por falta de recepción y el cliente deberá
abonar nuevamente el envío.</p>

                            <h3>Envío por moto mensajería SpeedMoto</h3>
                            <p>La mensajería retirará tu pedido y lo entregará de lunes a viernes en la franja horaria de 15hs a 21hs. Nosotros te informaremos por WhatsApp el día anterior a recibir el paquete para que estes atento y nos confirmes que te encontrarás en tu domicilio el día de la entrega. La demora de entrega puede ser de 5 a 7 días hábiles. En caso de no encontrarse a la hora de la visita, la entrega será reprogramada para el día siguiente, teniendo el cliente que abonar nuevamente el envío.</p>

                            <h3>Retiro en Sucursal</h3>
                            <p>Los pedidos tardan en llegar a la sucursal elegida entre 7 y 10 días hábiles. Una vez que llegue al local, nos comunicaremos con vos por mail para avisarte que ya podés ir a retirar tu compra. Recordá que deberás acercarte al local con tu DNI y el número de pedido y contas con 15 días para ir a retirarlo.</p>                        
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="p-2 text-left">
                            <h3>Periodos especiales</h3>
                            <p>Durante acciones especiales como Hot Sale, Cybermonday, Black Friday y promociones en el sitio web los tiempos de procesamiento, envío y entrega pueden verse afectados.</p>
                        </div>
                        <div class="p-2 text-left">
                            <h3>Algunos problemas frecuentes</h3>
                            <p>La respuesta 'Número Inexistente' puede darse si la estampilla no está cargada en el sistema de OCA pero el paquete está enviado. Si el estado del envio es 'En sucursal de destino', podés llamar e ir a buscar el paquete vos mismo. De todas maneras, podés esperar a recibirlo en la dirección de entrega.</p>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section id="referncia">
            <div class="wrapper">
                <h2>Referencia de estados</h2>
                <div class="bx">
                    <h3>Depósito Velez</h3>
                    <p>Depósito OCA en CABA.</p>
                </div>
                <div class="bx">
                    <h3>Despachado a Suc. de destino</h3>
                    <p>Paquete Enviado</p>
                </div>
                <div class="bx">
                    <h3>En Distribución</h3>
                    <p>El cartero lo está repartiendo</p>
                </div>
                <div class="bx">
                    <h3>En Sucursal</h3>
                    <p>Ya se encuentra en la sucursal de destino</p>
                </div>
                <div class="bx">
                    <h3>En tránsito</h3>
                    <p>Paquete Viajando</p>
                </div>
            </div>
        </section>
