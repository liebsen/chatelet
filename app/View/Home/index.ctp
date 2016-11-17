<?php
	echo $this->Html->css('home', array('inline' => false));
	echo $this->Html->css('animate', array('inline' => false));
	echo $this->Html->script('home', array('inline' => false));
	echo $this->Html->script('jquery.lettering', array('inline' => false));
	echo $this->Html->script('jquery.textillate', array('inline' => false));

	echo $this->Session->flash();

	$images 	= array();
	$images_aux = explode(';', $home['img_url']);
	foreach ($images_aux as $key => $value) {
		if(!empty($value))
			$images[] 	= Configure::read('imageUrlBase').$value;
	}
     
  
  
?>

        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
      
          <!-- Wrapper for slides -->
          <div class="carousel-inner " role="listbox">
             
              
            <?php foreach ($images as $key => $value): ?> 
                <div  class="item <?php echo (!$key) ? 'active' : is_null('') ; ?>" style="background-image: url(<?php echo $value ?>);" >
                  
                  <div class="carousel-caption">
                    
                    <h1> <?php echo $home['line_one']; ?></h1>
                        <span><?php echo $home['line_two']; ?></span>
                        <p><?php echo $home['line_three']; ?></p>
                       

                    <a href="#">Visitar</a>
                  </div>
                </div>
            <?php endforeach ?>
            
          </div>
         
            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="arrow arrow-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="arrow arrow-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>


        <section id="today">
            <div class="rectangle" style="background-image: url(<?php echo Configure::read('imageUrlBase').$home['img_url_one'] ?>);">

                <h1><?php echo $home['module_one']?></h1>
            </div>
        </section>

        <section id="opts">
            <div class="col-md-6" style="background-image: url(<?php echo Configure::read('imageUrlBase').$home['img_url_two'] ?>);">
                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'index'/*,
                                         intval($home['category_mod_two'])*/)) ?> >
             
                     <?php echo $home['module_two'] ?><br>
                </a>
            </div>

            <div class="col-md-6" style="background-image: url(<?php echo Configure::read('imageUrlBase').$home['img_url_three'] ?>);">
                <a href=<?php echo router::url(array('controller' => 'shop', 'action' => 'index'/*,
                                         intval($home['category_mod_three'])*/)) ?> >

                   <?php echo $home['module_three'] ?><br>
                </a>
            </div>
        </section>

        <section id="location">
            <div class="col-md-4"></div>
            <div class="col-md-8">  
                <h3>Venta por mayor y menor</h3>
                <h4>CAPITAL FEDERAL</h4>
                <ul>
                    <li>Av. Corrientes 2367</li>
                    <li>Tel. 4951-5899</li>
                </ul>
            </div>
        </section>

       <section id="suscribe">
            <div class="wrapper">
                <div class="col-md-6">Suscribite y conocé las <strong>novedades</strong></div>
                <div class="col-md-6">
                    <?php echo $this->Form->create('Contact', array('class' => 'contacto')); ?>
                      <input type="text" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
                      <input type="submit" id="enviar" value="ok">
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </section>
    
         <div class="modal fade" tabindex="-1" id="myModal" role="dialog">
            <div class="content">
                <a class="close" data-dismiss="modal">
                    <span></span>
                    <span></span>
                </a>

                    <?php echo $this->Form->create('Contact'); ?>
                    <h1>Suscribite a nuestro<br><span>Newsletter</span></h1>
                    <p>Y recibí las últimas novedades</p>
                   
                      <input type="email" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
                      <input type="submit" id="enviar" value="ok">
                    <?php echo $this->Form->end(); ?>
         
            </div>
        </div><!-- /.modal -->

