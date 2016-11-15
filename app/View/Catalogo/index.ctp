<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<?php
	echo $this->Html->css('catalogo', array('inline' => false));
	echo $this->Html->script('catalogo', array('inline' => false));
	/* Slider */
	echo $this->Html->script('box-slider/box-slider-all.jquery.min', array('inline' => false));
	/* Lightbox */
	echo $this->Html->css('lightbox', array('inline' => false));
	echo $this->Html->script('lightbox.min', array('inline' => false));
	echo $this->Session->flash();
?>
  <div id="video">
            <div class="col-md-6">
                <h1>Lookbook</h1>
                <p>Primavera / Verano<br>2017</p>
            </div>
            <div class="col-md-6">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe width="640" height="430" src="<?php echo $page_video."?wmode=transparent" ?>" frameborder="0" wmode="Opaque" allowfullscreen></iframe>
                </div>
            </div>
        </div>

       <section id="lookbook">
           <div class="col-md-5">
            <div id="carousel2" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                       <?php $images = explode(';', $cat['Catalog']['images']);

                       foreach ($images as $key => $value): 
                       	 if (empty($value))
								continue;?> 

                        <div class="item <?php echo (!$key) ? 'active' : null ; ?>">
                        <img src="<?php echo Configure::read('imageUrlBase').$value ?>" alt="...">
                  <div class="carousel-caption"></div>
                </div>
            <?php endforeach ?>
                        
                    </div>
                 
                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel2" role="button" data-slide="prev">
                        <span class="arrow arrow-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel2" role="button" data-slide="next">
                        <span class="arrow arrow-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
           </div>
           <div class="col-md-7">
               <h3>Elegí tu look para vivir tu momento.</h3>
               <ul>
                   <li>
                       <div class="row">
                           <div class="col-sm-3">
                               <img src="images/lookbook_sm_1.jpg" class="img-responsive">
                           </div>
                           <div class="col-sm-9">
                                <span class="price">$539</span>
                                <h2>Spolverino medio hombro</h2>
                                <p>Seleccionar talle</p>
                                <p class="prices"><a href="#">42</a> <a href="#">44</a> <a href="#" class="active">46</a> <a href="#">48</a> <a href="#">50</a> <a href="#">52</a> <a href="#">54</a> <a href="#">56</a></p>
                                <a href="#" class="add">Agregar al carrito</a>
                                <div class="social">
                                    <a href="#" class="fb"></a>
                                    <a href="#" class="tt"></a>
                                    <a href="#" class="pr"></a>
                                </div>
                           </div>
                       </div>
                   </li>

                   <li class="lc">
                       <div class="row">
                           <div class="col-sm-3">
                               <img src="images/lookbook_sm_2.jpg" class="img-responsive">
                           </div>
                           <div class="col-sm-9">
                                <span class="price">$720</span>
                                <h2>Short jean</h2>
                                <p>Seleccionar talle</p>
                                <p class="prices"><a href="#">42</a> <a href="#">44</a> <a href="#" class="active">46</a> <a href="#">48</a> <a href="#">50</a> <a href="#">52</a> <a href="#">54</a> <a href="#">56</a></p>
                                <a href="#" class="add">Agregar al carrito</a>
                                <div class="social">
                                    <a href="#" class="fb"></a>
                                    <a href="#" class="tt"></a>
                                    <a href="#" class="pr"></a>
                                </div>
                           </div>
                       </div>
                   </li>
               </ul>
           </div>
       </section>





