<?php
	echo $this->Session->flash();
?>
    <?php echo $this->element('navbar-ayuda'); ?>

  <section id="headhelp">
    <div class="wrapper container animation-fadeIn animation-both w-100">
      <div class="row is-flex-center">
        <div class="col-md-4">
          <h1>Contactate<br>con nosotros</h1>
        </div>
        <div class="col-md-8 p-0">
          <div class="box-cont">
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
          <h1>Contacta con Châtelet</h1>
          <p>Elige que tipo de consulta deseas realizar, rellena tus datos y escribe tu consulta, te responderemos en cuanto nos sea posible.</p>
          <div class="form-group">
            <input type="text" name="data[Contact][name]" class="form-control" placeholder="Nombre y Apellido" required />
          </div>
          <div class="form-group">
            <input type="email" class="form-control" name="data[Contact][email]" class="form-control" placeholder="Email" required/>
          </div>
          <div class="form-group">
            <input type="text" name="data[Contact][telephone]" class="form-control" placeholder="Telefono" required />
          </div>
          <div class="p-5">
            <h6>Tipo de consulta</h6>
            <div class="form-group d-flex justify-content-start align-items-center">
              <input type="radio" name="data[Contact][client_type]" id="particular" value="particular" checked="checked" />
              <label for="particular">Particular</label>
            </div>
            <div class="form-group d-flex justify-content-start align-items-center">
              <input type="radio" name="data[Contact][client_type]" id="comerciante" value="comerciante" />
              <label for="comerciante">Comerciante</label>
            </div>
          </div>          
          <div class="form-group">
            <textarea name="data[Contact][message]" class="form-control" placeholder="Escribe tu consulta aquí.." rows="4" required></textarea>
          </div>
        </div>
        <div class="flex-col desktop animation-fadeIn animation-both delay3">
          <div class="card p-0">
            <div class="card-body is-bordered">
              <h3><i class="gi gi-headset mr-1"></i> Soporte Chatelet</h3>
              <p>Tus consultas nos ayudan a mejorar para poder brindar una mejor experiencia de compra a todas nuestra comunidad.</p>
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