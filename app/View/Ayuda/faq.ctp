<?php
	$this->Html->css('ayuda', array('inline' => false));
?>
       <div id="headhelp">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <h1>Preguntas<br>frecuentes</h1>
                    </div>
                    <div class="col-md-6">
                        <div class="box">
                            <p>Si tenes alguna consulta no dudes en contactarte con nosotros o recurrir a las preguntas frecuentes que se encuentran a continuación:</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       <section id="optionsHelp">
            <a href="como_comprar" >¿Como comprar?</a>
            <a href="envios">Envíos</a>
            <a href="metodos_de_pago">Métodos de pago</a>
            <a href="faq" class="active">Preguntas frecuentes</a>
        </section>

        <section id="desarrollo">
            <div class="wrapper">
                <div class="col-sm-6">
                    <h3>Cuál es el costo de envío y entrega de mi pedido?</h3>
                    <p>El costo de envío y tiempo de entrega dependerá de la ubicación de cada usuario y del peso del pedido. Se recomienda consultar la tabla de envío.</p>

                    <h3>¿Dónde puedo realizar el seguimiento de mi pedido?</h3>
                    <p>Todos los envíos son efectuados por OCA y podes seguir el estado del mismo ingresando en www.oca.com.ar</p>
                </div>

                <div class="col-sm-6">
                    <h3>Cuál es el costo de envío y entrega de mi pedido?</h3>
                    <p>Si el pedido no fue entregado indícanos el número de seguimiento para que podamos identificarlo, e informale a la brevedad sobre el estado del mismo.</p>
                </div>
            </div>
        </section>
<!--
<div id="main" class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<?php
				echo $this->element('ayuda-menu');
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 content">
			<h1>Preguntas frecuentes</h1>

			<br />

			<h4>Cuál es el costo de envío y entrega de mi pedido?</h4>
			<p>
				El costo de envío y tiempo de entrega dependerá de la ubicación de cada usuario y del peso del pedido. 
				Se recomienda consultar la tabla de envío.
			</p>
			
			<br />

			<h4>¿Dónde puedo  realizar el seguimiento de mi pedido?</h4>
			<p>
				Todos los envíos son efectuados por OCA y  podes seguir el estado del mismo ingresando en www.oca.com.ar
			</p>

			<br />

			<h4>No recibí mi pedido</h4>
			<p>
				Si el pedido no fue entregado indícanos el número de seguimiento para que podamos identificarlo, e informale a la brevedad sobre el estado del mismo.
			</p>
		</div>
	</div>
	<div>
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
	</div>
</div>