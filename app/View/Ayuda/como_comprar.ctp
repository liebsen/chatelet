<?php
    $this->Html->css('ayuda', array('inline' => false));
?>
    
        <div id="headhelp">
            <?php echo $this->element('navbar-ayuda'); ?>
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-4">
                        <h1>¿Cómo<br>comprar?</h1>
                    </div>
                    <div class="col-md-8">
                        <div class="animated slideInRight delay2 leaves-pad">
                            <div class="box w-leaves">
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
                <div class="help-img">
                    <?php echo $this->Html->image('como-comprar.jpeg', array( 'class' => 'img-responsive step margin-auto rounded' )); ?><br><br>
                </div>

                <div class="wrapper">
                    <div class="col-sm-6">
                        <h3>Comprar en nuestra tienda online es muy fácil y seguro. Seguí estos pasos</h3>
                            <ol class="ordered-list">
                                <li>Elegí tu prenda
Podés encontrarla navegando por las categorías de nuestro shop o utilizando el buscador.
Una vez que hayas encontrado el producto que deseas, cliqueá para ingresar y conocer todos sus detalles.</li>
<li>Si querés comprarlo, elegí color y talle, y hacé clic en “Agregar al carrito”. Por más que la opción de color sea una sola, igual tenes que seleccionarla, de otro modo no podrás agregarlo. Aguardá unos segundos y el sistema te dirá si efectivamente hay stock de dicho artículo.</li>
<li>Tu producto fue agregado. Si querés agregar más productos, podés seguir navegando y repetir el proceso. Cuando termines, accedé a tu carrito haciendo click en botón del margen superior derecho del sitio “Tu pedido”</li>
<li>Allí podrás ver el resumen de tu compra (producto, talle, color, etc). Elegí como queres recibir tu compra, en caso de querer entrega en domicilio deberás cargar tu código postal y seleccionar la empresa de envios. O si queres retirar en sucursal deberás elegir por cual retirar. En caso de tener un código promocional (no es obligatorio), cargalo en el recuadro correspondiente y hacé click en “calcular”. Verifica que el pedido sea correcto y hace click en “Siguiente”</li>
<li>Para continuar no es necesario estar registrado, de igual forma si ya tenés una cuenta podes ingresar pero si no tenes cuenta cerrá el recuadro desde la cruz del margen superior derecho.</li>
<li>Seguí los pasos, indicando como queres abonar tu compra, completa tus datos personales y hace click en “Finalizar compra”</li>
<li>Serás redirigido a la plataforma de MercadoPago o, si elegiste transferencia bancaria, te aparecerán los datos bancarios en pantalla, ¡y listo!</li>
<li>Te mantendremos informado del estado de tu pedido por mail o WhatsApp.</li>
</ol><br><br>                    
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </section>
