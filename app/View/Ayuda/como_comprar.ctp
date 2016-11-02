<?php
	$this->Html->css('ayuda', array('inline' => false));
?>

  <div id="headhelp">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <h1>¿Cómo<br>comprar?</h1>
                    </div>
                    <div class="col-md-6">
                        <div class="box">
                            <h3>¿Tiene alguna consulta o sugerencia?</h3>
                            <p>Para comprar un producto de nuestro catalogo, primero debes tener una cuenta registrada en nuestro sitio. Si todavía no estás registrado/a <a href="#">hace click aquí</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section id="optionsHelp">
            <a href="como_comprar" class="active">¿Como comprar?</a>
            <a href="envios">Envíos</a>
            <a href="metodos_de_pago">Métodos de pago</a>
            <a href="faq">Preguntas frecuentes</a>
        </section>

        <section id="desarrollo">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6 col-sm-8">
                        Si ya estás registrado/a y querés saber como empezar a comprar, ingresá en continuar:
                    </div>

                    <div class="col-md-6 col-sm-4">
                        <a href="#" class="bt">Continuar</a>
                    </div>
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
		<div class="col-md-4"></div>
		<div class="col-md-4 content">
			<h1 class="heading">¿Como comprar?</h1>
			<p>
				Para comprar un producto de nuestro catalogo,
				primero debes tener una cuenta registrada en nuestro sitio.
				Si todavía no estás registrado/a, <a href="#" class="pink" data-toggle="modal" data-target="#particular-modal">hace click aqui.</a>
			</p><br /><br />
			<p>
				Si ya estás registrado/a y querés saber como
				empezar a comprar, ingresá en continuar:
			</p><br />
			<?php
				echo $this->Html->link('Continuar', array(
						'controller' => 'ayuda',
						'action' => 'como_comprar',
						1
					), array(
						'class' => 'continuar'
					));
			?>
		</div>
		<div class="col-md-4"></div>
	</div>
	<br />
	<br />
	<br />
	<br />
	<div class="clearfix"></div>
</div>