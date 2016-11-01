<?php
	echo $this->Html->css('contacto', array('inline' => false));
	echo $this->Session->flash();
?>
<div id="main" class="container content">
	<div class="row">
		<div class="col-md-4">
			<h1 class="heading">Contacto</h1>
			<h3 class="subheading">¿Tiene alguna consulta o sugerencia?</h3>
			<p class="info">
				Complete el siguiente formulario y háganos llegar sus inquietudes o recomendaciones que crea pertinentes.
			</p>
		</div>
		<div class="col-md-4 center">
			<?php echo $this->Form->create('Contact', array('class' => 'contacto')); ?>
				<input type="text" name="data[Contact][name]" class="form-input" placeholder="Nombre y Apellido" required />
				<p>
					<label for="particular">Particular</label>
					<input type="radio" name="data[Contact][client_type]" id="particular" value="particular" checked="checked" />
					<label for="comerciante">Comerciante</label>
					<input type="radio" name="data[Contact][client_type]" id="comerciante" value="comerciante" />
				</p>
				<input type="email" name="data[Contact][email]" class="form-input" placeholder="Email" required/>
				<input type="tel" name="data[Contact][telephone]" class="form-input" placeholder="Telefono" required />
				<textarea class="mensaje" name="data[Contact][message]" class="form-input" placeholder="Mensaje" rows="10" required></textarea>
				<input type="submit" id="contactar" class="big-pink-btn" value="Enviar Consulta" />
			<?php echo $this->Form->end(); ?>
		</div>
		<div class="col-md-4">
		</div>
	</div>
</div>