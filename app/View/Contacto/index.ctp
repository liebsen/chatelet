<?php
	echo $this->Session->flash();
?>
  <section id="headcontacto">
    <div class="wrapper container animated fadeIn w-100">
      <div class="row">
        <div class="col-md-4">
          <div class="animated fadeIn delay">
            <h1>Contactate<br>con nosotros</h1>
          </div>
        </div>
        <div class="col-md-8 p-0">
          <div class="animated fadeIn delay box-cont">
            <div class="box">
              <h3>¿Tenés alguna consulta o sugerencia?</h3>
              <p>Completá el siguiente formulario y hacenos llegar tus inquietudes o recomendaciones que creas pertinentes.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="desarrollo" class="bg-arrow">
    <div class="wrapper container">
      <?php echo $this->Form->create('Contact', array('class' => 'contacto')); ?>
      <div class="flex-row">
        <div class="flex-col">

          <div class="form-group">
            <input type="text" name="data[Contact][name]" class="form-control" placeholder="Nombre y Apellido" required />
          </div>
          <div class="form-group">
            <input type="email" class="form-control" name="data[Contact][email]" class="form-control" placeholder="Email" required/>
          </div>
          <div class="form-group">
            <input type="text" name="data[Contact][telephone]" class="form-control" placeholder="Telefono" required />
          </div>
          <div class="p-2">
            <h6>Tipo de consulta</h6>
            <label for="particular">
              <span class="active"><i></i></span>
              <input type="radio" name="data[Contact][client_type]" id="particular" value="particular" checked="checked" /> Particular
            </label>
            <label for="comerciante">
              <span><i></i></span>
              <input type="radio" name="data[Contact][client_type]" id="comerciante" value="comerciante" /> Comerciante
            </label>
          </div>          
          <div class="form-group">
            <textarea name="data[Contact][message]" class="form-control" placeholder="Escribe tu consulta aquí.." rows="4" required></textarea>
          </div>
        </div>
        <div class="flex-col desktop">
          <div class="card">
            <div class="card-body is-bordered">
              <h3>Contacta con Chatelet</h3>
              <p>Elige que tipo de consulta deseas realizar, rellena tus datos y escribe tu consulta, te responderemos en cuanto nos sea posible.</p>
            </div>
          </div>
        </div>  
      </div>
      <hr>
      <div class="row is-flex-center d-none">
        <div class="col-md-6">
          <span class="text-sm text-muted">* Al hacer click en Continuar estas aceptando nuestros <a href="/shop/terminos"> Términos y Condiciones</a>
          </span>
        </div>
        <div class="col-md-6">
          <input type="submit" id="contactar" class="btn btn-chatelet dark" value="Enviar Consulta" />
        </div>
      </div>
      <?php echo $this->Form->end(); ?>
    </div>
  </section>

  <section id="suscribe">
    <?php $this->element('subscribe-box') ?>
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
				<input type="text" name="data[Contact][name]" class="form-control" placeholder="Nombre y Apellido" required />
				<p>
					<label for="particular">Particular</label>
					<input type="radio" name="data[Contact][client_type]" id="particular" value="particular" checked="checked" />
					<label for="comerciante">Comerciante</label>
					<input type="radio" name="data[Contact][client_type]" id="comerciante" value="comerciante" />
				</p>
				<input type="email" name="data[Contact][email]" class="form-control" placeholder="Email" required/>
				<input type="tel" name="data[Contact][telephone]" class="form-control" placeholder="Telefono" required />
				<textarea class="mensaje" name="data[Contact][message]" class="form-control" placeholder="Mensaje" rows="6" required></textarea>
				<input type="submit" id="contactar" class="big-pink-btn" value="Enviar Consulta" />
			<?php echo $this->Form->end(); ?>
		</div>
		<div class="col-md-4">
		</div>
	</div>
</div>-->