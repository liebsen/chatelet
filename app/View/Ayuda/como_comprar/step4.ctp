     <div id="headhelp">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <h1>¿Cómo<br>comprar?</h1>
                    </div>
                    <div class="col-md-6">
                        <div class="animated rubberBand delay1">
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
            <a href="como_comprar" class="active">¿Cómo comprar?</a>
            <a href="envios">Envíos</a>
            <a href="metodos_de_pago">Métodos de pago</a>
            <a href="politicas_de_cambio">Políticas de cambio</a>
            <a href="faq">Preguntas frecuentes</a>
        </section>

        <section id="desarrollo">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6 col-sm-8">
                        <?php echo $this->Html->image('ayudin4.jpg', array( 'class' => 'img-responsive step' )); ?>
                    </div>

                    <div class="col-md-6 col-sm-4">
                     <?php
                        echo $this->Html->link('Seguir con Envios', array( 'controller' => 'ayuda', 'action' => 'envios' ), 
                            array(
                        'class' => 'bt'
                        ));
                    ?>
                    </div>
                </div>
            </div>
        </section>

            <?php echo $this->Html->link('Seguir con Envios', array( 'controller' => 'ayuda', 'action' => 'envios' ), array( 'class' => 'continuar' )); ?>
  