<?php

	echo $this->Session->flash();
	$images 	= array();
	$images_aux = explode(';', @$home['img_url']);
	foreach ($images_aux as $key => $value) {
		if(!empty($value))
			$images[] 	= Configure::read('imageUrlBase').$value;
	}

  $img_url_one = str_replace(';', '', @$home['img_url_one']);
  $img_url_two = str_replace(';', '', @$home['img_url_two']);
  $img_url_three = str_replace(';', '', @$home['img_url_three']);
  $img_url_four = str_replace(';', '', @$home['img_url_four']);

?>

        <div id="carousel-example-generic" class="carousel slide" data-interval="3000" data-ride="carousel">

          <!-- Wrapper for slides -->
          <div class="carousel-inner " role="listbox">

            <?php foreach ($images as $key => $value): ?>
                <div  class="item <?php echo (!$key) ? 'active' : is_null('') ; ?>"  >
                    <a href="<?php echo router::url(array('controller' => 'Shop', 'action' => 'index')) ?>">
                        <div class="slider-full" style="background-image:url(<?php echo $value; ?>)"></div>
                    </a>

                    <div class="carousel-caption">
                        <h1> <?php echo $home['line_one']; ?></h1>
                       <?php if(!empty($home['line_two'])){
                        echo '<span>'.$home['line_two'].'</span>';
                        } ?>
                        <p><?php echo $home['line_three']; ?></p>

                        <a href="<?php echo router::url(array('controller' => 'Shop', 'action' => 'index')) ?>">Visitar</a>
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

        <section id="listShop">
          <div class="wrapper">
            <div class="row m-0">
              <div class="col-xs-12">
                <div class="row">
              <?php foreach($categories as $category): ?>
              <div class="p-1 col-xs-12 col-md-<?= !empty($category['Category']['colsize']) ? $category['Category']['colsize'] : 'auto' ?>">
                <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($category['Category']['name'])))); ?>" class="pd1 text-center">
                  <img src="<?php echo Configure::read('imageUrlBase').$category['Category']['img_url']?>" class="img-responsive img-cover">
                  <span class="name p-1 text-uppercase">
                     <?php echo $category['Category']['name']?><br>
                  </span>
                </a>
              </div>
              <?php endforeach ?>
              </div></div>
            </div>
          </div>
        </section>

        <section id="suscribe">
            <div class="wrapper container is-flex-end">
                <div class="col-md-6">
                    <h2 class="h4 mt-0 mb-1 text-uppercase">Newsletter - Estemos <strong>conectad@s</strong></h2>
                    <p class="text-uppercase">Enterate de nuestras novedades, descuentos y beneficios exlusivos solo para clientas</p>
                </div>
                <div class="col-md-6">
                    <?php echo $this->Form->create('Contact', array('class' => 'contacto')); ?>
                      <input class="p-1" type="email" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
                      <input type="submit" id="enviar" value="confirmar">
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </section>
    <?php
    $popupBG=explode(';', @$home['img_popup_newsletter']);
    if(empty($popupBG[0])){
        $aux = array();
        foreach($popupBG as $key=>$value){
            if(!empty($value)){
                $aux[] = $value;
            }
        }
        $popupBG = $aux;
    }
    ?>
        <div class="modal fade" tabindex="-1" id="myModal" role="dialog" style="background-color: #262427;">

        <?php if(count($popupBG)>1):?>

            <div class="content js-show-modal" data-dismiss="modal">

                <!--a class="close" data-dismiss="modal">
                    <span></span>
                    <span></span>
                </a-->
                <?php echo $this->Form->create('Contact'); ?>


                <?php if(empty($home['text_popup_newsletter'])):?>
                    <!--h1>Suscribite a nuestro<br /><span>Newsletter</span></h1>
                    <p>Y recibí las últimas novedades</p-->
                <?php else:?>
                   <?php echo $home['text_popup_newsletter'];?>
                <?php endif;?>

                <div class="ft___ml" <?php if(empty($home['display_popup_form'])):?> style="display: none;" <?php endif;?>>
                  <input type="email" name="data[Subscription][email]" required>
                  <input type="submit" id="enviar" value="ok">
                </div>
                <?php echo $this->Form->end(); ?>

                <div id="carousel-newsletter" class="carousel slide" data-ride="carousel" <?php if(!empty($home['display_popup_form_in_last'])){ echo " data-wrap='false' "; } ?> >
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner news-carousel" role="listbox">
                    <div class="item active">

                      <img src="<?=Configure::read('imageUrlBase').$popupBG[0]?>">
                         <?php if(!empty($home['display_popup_form_in_last'])):?>
                <div class="in_last">
                <?php echo $this->Form->create('Contact'); ?>
                        <input type="email" name="data[Subscription][email]" required>
                        <input type="submit" id="enviar" value="ok">
                <?php echo $this->Form->end(); ?>
                </div>
                <?php endif; ?>
                    </div>
                    <div class="item">
                      <img src="<?=Configure::read('imageUrlBase').$popupBG[1]?>">

                     <?php if(!empty($home['display_popup_form_in_last'])):?>

                <div class="in_last">
                <?php echo $this->Form->create('Contact'); ?>
                        <input type="email" name="data[Subscription][email]" required>
                        <input type="submit" id="enviar" value="ok">
                <?php echo $this->Form->end(); ?>
                </div>
                <?php endif; ?>

                    </div>
                    <?php if(isset($popupBG[2]) && !empty($popupBG[2])):?>
                    <div class="item">

                      <img src="<?=Configure::read('imageUrlBase').$popupBG[2]?>">

                         <?php if(!empty($home['display_popup_form_in_last'])):?>
                <div class="in_last">
                <?php echo $this->Form->create('Contact'); ?>
                        <input class="p-1" type="email" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
                        <input type="submit" id="enviar" value="ok">
                <?php echo $this->Form->end(); ?>
                </div>
                <?php endif; ?>
                    </div>
                    <?php endif;?>
                  </div>
                </div>
            </div>

        <?php elseif (count($popupBG)==1):?>

            <div class="content js-show-modal is-clickable" data-dismiss="modal" style="<?=(!empty($home['img_popup_newsletter']))?'background-image: url('.Configure::read('imageUrlBase').$popupBG[0].');background-position-x: center;background-repeat: no-repeat;':'background: url(images/livebox-bg.jpg);'?><?=(isset($popupBgWidth))?'background-size: cover;':''?>">
                <div class="tap-to-continue animated fadeIn delay3" title="Continuar a la tienda">
                    <i class="fa fa-chevron-right mr-0"></i> 
                    <span class="ml-2">Continuar<span class="d-none d-lg-block d-xl-block"> a la tienda</span></span>
                </div>

                <?php if(!empty($home['display_popup_form_in_last'])):?>
                <div class="in_last">
                <?php echo $this->Form->create('Contact'); ?>
                        <input class="p-1" type="email" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
                        <input type="submit" id="enviar" value="ok">
                <?php echo $this->Form->end(); ?>
                </div>
                <?php endif; ?>

                <!--a class="close" data-dismiss="modal">
                    <span></span>
                    <span></span>
                </a-->
                    <?php $formStyle=(isset($popupBgHeight))?array('style'=>'min-height:'.$popupBgHeight.'px;'):array();?>
                    <?php echo $this->Form->create('Contact', $formStyle); ?>
                <?php if(empty($home['text_popup_newsletter'])):?>
                    <!--div style="float: left; margin: 45px 0 75px 0; padding: 50px 35px; width: 100%;">
                    <h1>Suscribite a nuestro<br /><span>Newsletter</span></h1>
                    <p style="font-size: 16px;font-weight: 500;margin-bottom: 40px;position:inherit;">Y recibí las últimas novedades</p>
                    </div-->
                <?php else:?>
                   <?php echo $home['text_popup_newsletter'];?>
                <?php endif;?>
                <div class="ft___ml" <?php if(empty($home['display_popup_form'])):?> style="display: none;"<?php endif;?>>


                      <input class="p-1" type="email" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
                      <input type="submit" id="enviar" value="ok">
                </div>
                    <?php echo $this->Form->end(); ?>
            </div>
        <?php endif;?>
        </div><!-- /.modal -->


        <div class="social-bottom">
            <span class="text-uppercase"><p class="h4">Seguinos en nuestras redes</p></span>
            <a href="https://twitter.com/chateletmoda" target="_blank">
                <i class="fa fa-twitter"></i>
            </a>
            <a href="https://www.facebook.com/pages/Ch%C3%A2telet/114842935213442" target="_blank">
                <i class="fa fa-facebook"></i>
            </a>
            <a href="https://www.instagram.com/chateletmoda/" target="_blank">
                <i class="fa fa-instagram"></i>
            </a>
        </div>


<?php if(!empty($home['display_popup_form_in_last'])):?>
    <style type="text/css">

        .news-carousel .item:last-child .in_last form {
            position: absolute!important;
            top:0px;
        }

        .news-carousel .item:last-child .in_last form input[type="email"] {
            margin-top: 217px;
            margin-left: 36px;
            border: none!important;
        }

        .news-carousel .item:last-child .in_last form input[type="submit"] {
            margin-top: 30px;
            float: left!important;
            border: none!important;
            margin-left: 50px;
            clear: both;
            color: transparent!important;
        }

    </style>

<?php endif; ?>


<script>
var myIndex = 0;
//carousel();
function carousel() {
    //console.log('carousel executing')
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}
    x[myIndex-1].style.display = "block";
    setTimeout(carousel, 9000);
    $("#carousel-newsletter").carousel();
}
</script>
