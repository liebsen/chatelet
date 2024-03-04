        <section id="optionsHelp">
            <a href="/ayuda/como_comprar" class="active">¿Cómo comprar?</a>
            <a href="/ayuda/envios">Envíos</a>
            <a href="/ayuda/metodos_de_pago">Métodos de pago</a>
            <a href="/ayuda/politicas_de_cambio">Cambios y devoluciones</a>
            <a href="/ayuda/faq">Preguntas frecuentes</a>
        </section>
        <div id="headhelp">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <h1>¿Cómo<br>comprar?</h1>
                    </div>
                    <div class="col-md-6">
                        <div class="animated slideInRight delay">
                            <div class="box">
                                <h3>¿Tenés alguna consulta o sugerencia?</h3>
                                <p>Para comprar un producto de nuestro catálogo, primero debes tener una cuenta registrada en nuestro sitio. Si todavía no estás registrado/a <a href="#" id="register" data-toggle="modal" data-target="#particular-modal">hace click aquí</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <section id="desarrollo">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6 col-sm-8">
                         <?php echo $this->Html->image('ayudin2.jpg', array( 'class' => 'img-responsive step' )); ?>
                    </div>

                    <div class="col-md-6 col-sm-4">
                    <?php
                        echo $this->Html->link('Continuar', array(
                        'controller' => 'ayuda',
                        'action' => 'como_comprar',
                         3
                        ), array(
                        'class' => 'btn cart-btn-green'
                        ));
                    ?>
                    </div>
                </div>
            </div>
        </section>
