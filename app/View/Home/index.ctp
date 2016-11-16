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

               
   <!--      [module_one] => Modulo 1
    [module_two] => Modulo 2
    [module_three] => Modulo 3
    [category_mod_one] => 14
    [category_mod_two] => 6
    [category_mod_three] => 31
    [img_url_one] => B0dNEdvGVQimK7F7eYvRHmu9o.jpg
    [img_url_two] => pI0ezibxTfXi2iA7xsKwn5TCn.jpg
    [img_url_three] => ;JFjzgZun6wt0zDFvQltGXK6CW.jpg -->

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
                    <form>
                        <input type="text" placeholder="Ingresá tu email">
                        <input type="submit" value="ok">
                    </form>
                </div>
            </div>
        </section>



<!--
<div id="main" class="main">	
	<?php if (count($images) == 1){ ?>
		<img class="img-responsive" src="<?php echo $images[0]; ?>" />
	<?php }else{ ?>
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		  <!-- Indicators -->
<!--		  <ol class="carousel-indicators">
		  	<?php foreach ($images as $key => $value): ?>
		  		<li data-target="#carousel-example-generic" data-slide-to="<?php echo $key ?>" class="<?php echo (!$key)?'active':''; ?>"></li>
		  	<?php endforeach ?>
		  </ol>

		  <!-- Wrapper for slides -->
<!--		  <div class="carousel-inner">
			<?php foreach ($images as $key => $value): ?>
			    <div class="item <?php echo (!$key) ? 'active' : null ; ?>">
			      <img src="<?php echo $value ?>" alt="...">
			      <div class="carousel-caption">
			        ...
			      </div>
			    </div>
		    <?php endforeach ?>
		  </div>

	       <!-- Controls -->
     <!--       <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="arrow arrow-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="arrow arrow-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
	<?php } ?>


	<?php if (!empty($home['line_one'])): ?>
		<div class="overlay">
			<div class="wrap">
				<h3 class="tlt"><?php echo $home['line_one']; ?></h3>
			</div>
			<div class="wrap">
				<h2 class="tlt"><?php echo $home['line_two']; ?></h2>
			</div>
			<div class="wrap">
				<h1 class="tlt"><?php echo $home['line_three']; ?></h1>
			</div>
		</div>
	<?php endif ?>
</div>-->