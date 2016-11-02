<?php
	echo $this->Html->css('contacto', array('inline' => false));
	echo $this->Session->flash();
?>
  <div id="headcontacto">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <h1>Contactate<br>con nosotros</h1>
                    </div>
                    <div class="col-md-6">
                        <div class="box">
                            <h3>¿Tiene alguna consulta o sugerencia?</h3>
                            <p>Complete el siguiente formulario y háganos llegar sus inquietudes o recomendaciones que crea pertinentes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       <section id="formulario">
           <div class="wrapper">
               <form>
                   <div class="row">
                       <div class="col-sm-6">
                            <input type="text" placeholder="Nombre y apellido">

                            <h3>Tipo de consulta:</h3>
                            <label class="mr"><span class="active"><i></i></span><input type="radio" name="radio" checked="checked"> Particular</label>
                            <label><span><i></i></span><input type="radio" name="radio"> Comerciante</label>

                            <input type="email" placeholder="Email">
                       </div>

                       <div class="col-sm-6">
                           <input type="text" placeholder="Teléfono">

                           <textarea placeholder="Mensaje"></textarea>

                           <input type="submit" value="Enviar consulta">
                       </div>
                   </div>
               </form>
           </div>
       </section>

        <section id="suscribe">
            <div class="wrapper">
                <div class="col-md-6">Suscribite y conocé las <strong>novedades</strong></div>
                <div class="col-md-6">
                    <form>
                        <input type="text" placeholder="Ingresá tu email">
                        <input type="submit" value="ok">
                    </form>
                </div>
            </div>
        </section>

<!--
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
</div>-->