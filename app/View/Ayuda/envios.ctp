<?php $this->Html->script('ayuda', array('inline' => false)); ?>

        <div id="headhelp">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <h1>Consultar<br>envíos</h1>
                    </div>
                    <div class="col-md-6">
                        <div class="animated bounceIn delay1 leaves-pad">
                            <div class="box w-leaves">
                                <h3>¿Tenés alguna consulta o sugerencia?</h3>
                                <p>Los datos son extraídos de OCA. También se puede consultar el estado del envío comunicándose con el centro de atención al cliente de OCA: 0800-999-7700</p>

                                <h3>Seguimiento de paquetes</h3>
                                 <?php echo $this->Form->create() ?>
                                 <form>
                                    <input type="text" class="guia" name="data[guia]" placeholder="Nº de pieza" required>
                                    <input type="submit" class="consultar" id="consult" value="Consultar">
                                </form>
                                <?php echo $this->Form->end(); ?>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>

         <section id="optionsHelp">
            <a href="/ayuda/como_comprar" >¿Cómo comprar?</a>
            <a href="/ayuda/envios" class="active">Envíos</a>
            <a href="/ayuda/metodos_de_pago" >Métodos de pago</a>
            <a href="/ayuda/politicas_de_cambio">Cambios y devoluciones</a>
            <a href="/ayuda/faq" >Preguntas frecuentes</a>
        </section>

        <section id="desarrollo">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6 boxs">
                        <div class="boxs-reframe">
                            <h3>Tiempos de entrega</h3>
                            <p><strong>Los pedidos serán despachados entre 2 y 3 días hábiles. <!-- <?= $data['carrito_takeaway_text'] ?> --></strong></p>
                            <h3>Periodos especiales</h3>
                            <p><strong>Durante acciones especiales como Hot Sale, Cybermonday, Black Friday y promociones en el sitio web los tiempos de procesamiento, envío y entrega pueden verse afectados.</strong></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-left">Envío por OCA</h3>
                        <p class="text-left">Los envíos se realizan a través de OCA en un plazo de entre 7 y 10 días hábiles (dependiendo de la región). Se puede hacer el seguimiento del mismo mediante un link que se envía al mail.</p>
                        <p class="text-left">En caso de no encontrarse a la hora de la visita se dejara un aviso, y se realizara una segunda visita. Si nuevamente no hay nadie en el domicilio, el paquete volverá a nuestra     oficina por falta de recepción y el cliente deberá abonar nuevamente el envío.</p>
                        <h3 class="text-left">Retiro en Sucursal</h3>
                        <p class="text-left">Los pedidos tardan en llegar a la sucursal elegida entre 10 y 15 días hábiles. Una vez que llegue al local, nos comunicaremos con vos por mail para avisarte que ya podés ir a retirar tu compra. Recordá que deberás acercarte al local con tu DNI y el número de pedido y contas con 15 días para ir a retirarlo.</p>
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
        <section id="desarrollo">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6 boxs">
                        <div class="boxs-reframe">
                            <h3>Algunos problemas frecuentes</h3>
                            <p>La respuesta 'Número Inexistente' puede darse si la estampilla no está cargada en el sistema de OCA pero el paquete está enviado.</p>
                            <p>Si el estado del envio es 'En sucursal de destino', podés llamar e ir a buscar el paquete vos mismo. De todas maneras, podés esperar a recibirlo en la dirección de entrega.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
