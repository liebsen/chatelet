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