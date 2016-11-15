<?php $this->Html->script('ayuda', array('inline' => false)); ?>

        <div id="headhelp">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <h1>Consultar<br>envíos</h1>
                    </div>
                    <div class="col-md-6">
                        <div class="box box2">
                            <p>Los datos son extraidos de OCA. También se puede consultar el estado del envío comunicándose con el centro de atención al cliente de OCA: 0800-999-7700</p>

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

         <section id="optionsHelp">
            <a href="como_comprar" >¿Como comprar?</a>
            <a href="envios" class="active">Envíos</a>
            <a href="metodos_de_pago" >Métodos de pago</a>
            <a href="faq" >Preguntas frecuentes</a>
        </section>

        <section id="desarrollo">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6 boxs">
                        La respuesta 'Número Inexistente' puede darse si la estampilla no está cargada en el sistema de OCA pero el paquete está enviado.<br>
                        Si el estado del envio es 'En sucursal de destino', podés llamar e ir a buscar el paquete vos mismo. De todas maneras, podés esperar a recibirlo en la dirección de entrega.
                    </div>

                    <div class="col-md-6 boxs">
                        El costo y tiempo de envío dependerá de la ubicación de cada cliente.<br>
                        Se recomienda consultar al momento de realizar el proceso de compra el costo de envío. El pedido será despachado 24 hs después de haberse acreditado el pago. 
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
