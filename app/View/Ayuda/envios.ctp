<?php $this->Html->css('ayuda', array('inline' => false)); ?>
<?php $this->Html->script('ayuda', array('inline' => false)); ?>
<div id="main" class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php echo $this->element('ayuda-menu'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 content">
            <h1>Consultar Envios</h1>
            <p>Los datos son extraidos de OCA.</p>
            <p>También se puede consultar el estado del envío comunicándose con el centro de atención al cliente de OCA: 0800-999-7700</p>
            <div class="seguimiento">
                <?php echo $this->Form->create() ?>
                <p>
                    <?php echo $this->Html->image('OCA.png', array('class' => 'oca')); ?>
                </p>
                <p>
                    <input type="text" class="guia" name="data[guia]" placeholder="Ingrese su Nº de Pieza" required/>
                </p>
                <p>
                    <button type="submit" class="consultar" id="consult">Consultar</button>
                </p>
                <?php echo $this->Form->end(); ?>
            </div>
            <p>La respuesta 'Número Inexistente' puede darse si la estampilla no está cargada en el sistema de OCA. Pero el paquete está enviado.</p>
            <p>Si el estado del envio es 'En sucursal de destino', podés llamar e ir a buscar el paquete vos mismo.</p>
            <p>De todas maneras, podés esperar a recibirlo en la dirección de entrega.</p>

            <br />

            <p>
                El costo y tiempo de envío dependerá de la ubicación de cada cliente.
                <br />Se recomienda consultar al momento de realizar el proceso de compra el costo de envío.
                <br />El pedido será despachado 24 hs después de haberse acreditado el pago.
                <br />
            </p>
            <div class="referencia">Referencia de estados</div>
            <div class="estados">
                <ul class="list-inline estados-list">
                    <li>
                        <p>
                            Depósito Velez
                            <br />Depósito OCA en CABA
                        </p>
                    </li>
                    <li>
                        <p>
                            Despachado a Suc. de destino
                            <br />Paquete Enviado
                        </p>
                    </li>
                    <li>
                        <p>
                            En tránsito
                            <br />Paquete Viajando
                        </p>
                    </li>
                    <li>
                        <p>
                            En Sucursal
                            <br />Ya se encuentra en la sucursal de destino
                        </p>
                    </li>
                    <li>
                        <p>
                            En Distribución
                            <br />El cartero lo está repartiendo
                        </p>
                    </li>
                </ul>
            </div>
            <a href="#" class="condiciones">Términos y condiciones de envios OCA</a>
        </div>
    </div>
    <br />
    <br />
</div>