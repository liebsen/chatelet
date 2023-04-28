     <div id="headhelp">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <h1>¿Cómo<br>comprar?</h1>
                    </div>
                    <div class="col-md-6">
                        <div class="animated bounceIn delay1 p-2">
                            <div class="box w-leaves">
                                <h3>¿Tenés alguna consulta o sugerencia?</h3>
                                <p>Para comprar un producto de nuestro catálogo, primero debes tener una cuenta registrada en nuestro sitio. Si todavía no estás registrado/a <a href="#" id="register" data-toggle="modal" data-target="#particular-modal">hace click aquí</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section id="optionsHelp">
            <a href="/ayuda/como_comprar" class="active">¿Cómo comprar?</a>
            <a href="/ayuda/envios">Envíos</a>
            <a href="/ayuda/metodos_de_pago">Métodos de pago</a>
            <a href="/ayuda/politicas_de_cambio">Políticas de cambio</a>
            <a href="/ayuda/faq">Preguntas frecuentes</a>
        </section>

        <section id="desarrollo">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <p class="alert m-0">Si ya estás registrado/a y querés saber como empezar a comprar, ingresá en continuar:</p>
                    </div>

                    <div class="col-md-6 col-sm-12  flex align-items-center">
                        <?php
		            	echo $this->Html->link('Continuar', array(
                        'controller' => 'ayuda',
                        'action' => 'como_comprar',
                        1
                        ), array(
                            'class' => 'btn cart-btn-green'
                        ));
			             ?>
                    </div>
                </div>
            </div>
        </section>
