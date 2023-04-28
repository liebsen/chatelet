<?php
	echo $this->Session->flash();
?>
  <div id="headcontacto">
    <div class="wrapper">
      <div class="row">
        <div class="col-md-6">
          <h1>Contactate<br>con nosotros</h1>
        </div>
        <div class="col-md-6">
          <div class="animated bounceIn delay1 leaves-pad">                      
            <div class="box w-leaves">
              <h3>¿Tenés alguna consulta o sugerencia?</h3>
              <p>Completá el siguiente formulario y hacenos llegar tus inquietudes o recomendaciones que creas pertinentes.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

 <section id="formulario">
     <div class="wrapper">
        <?php echo $this->Form->create('Contact', array('class' => 'contacto')); ?>
             <div class="row">
                 <div class="col-sm-6">
                      <input type="text" name="data[Contact][name]" class="form-input" placeholder="Nombre y Apellido" required />

                      <h3>Tipo de consulta:</h3>
                      <label class="mr" for="particular"><span class="active"><i></i></span><input type="radio" name="data[Contact][client_type]" id="particular" value="particular" checked="checked" /> Particular</label>
                      <label><span><i></i></span><input type="radio" name="data[Contact][client_type]" id="comerciante" value="comerciante" /> Comerciante</label>

                      <input type="email" name="data[Contact][email]" class="form-input" placeholder="Email" required/>
                 </div>

                 <div class="col-sm-6">
                     <input type="text" name="data[Contact][telephone]" class="form-input" placeholder="Telefono" required />

                     <textarea class="mensaje" name="data[Contact][message]" class="form-input" placeholder="Mensaje" rows="10" required></textarea>

                     <input type="submit" id="contactar" class="big-pink-btn" value="Enviar Consulta" />
                 </div>
             </div>
         <?php echo $this->Form->end(); ?>
     </div>
 </section>


<section id="suscribe">
      <div class="wrapper container is-flex-end">
          <div class="col-md-6">
              <h2 class="h2 mt-0 mb-1">Estemos <strong>conectad@s</strong></h2>
              <p>Enterate de nuestras novedades, descuentos y beneficios exlusivos solo para clientas</p>
          </div>
          <div class="col-md-6">
              <?php echo $this->Form->create('Contact', array('class' => 'contacto')); ?>
                <input class="p-1" type="email" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
                <input type="submit" id="enviar" value="ok">
              <?php echo $this->Form->end(); ?>
          </div>
      </div>
  </section>

      
<!--
<div id="main" class="container content">
	<div class="row">
		<div class="col-md-4">
			<h1 class="heading">Contacto</h1>
			<h3 class="subheading">¿Tenés alguna consulta o sugerencia?</h3>
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
</div>-->