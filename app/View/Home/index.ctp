<?php

	echo $this->Session->flash();

	$images 	= array();
	$images_aux = explode(';', $home['img_url']);
	foreach ($images_aux as $key => $value) {
		if(!empty($value))
			$images[] 	= Configure::read('imageUrlBase').$value;
	}
    
    $img_url_one = str_replace(';', '', $home['img_url_one']);  
 
    $img_url_two = str_replace(';', '', $home['img_url_two']); 
    
    $img_url_three = str_replace(';', '', $home['img_url_three']); 
    $img_url_four = str_replace(';', '', $home['img_url_four']); 
   
?>

        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
      
          <!-- Wrapper for slides -->
          <div class="carousel-inner " role="listbox">
             
              
            <?php foreach ($images as $key => $value): ?> 
                <div  class="item <?php echo (!$key) ? 'active' : is_null('') ; ?>"  >
                    <a href="<?php echo router::url(array('controller' => 'Shop', 'action' => 'index')) ?>">
                        <img  src=<?php echo $value; ?>   img-responsive>
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

        
        <section id="today">   
            <?php if(!empty($home['category_mod_one'])){
                echo '<a href='.router::url(array('controller' => 'shop', 'action' => 'product',$home['category_mod_one'])).'>';
                }else{
                echo '<a href='.router::url(array('controller' => 'shop', 'action' => 'index')).'>' ;
                } 
                echo '<div class="rectangle" img-responsive style="background-image: url('.Configure::read('imageUrlBase').$img_url_one.');">'.'<h1>'.$home['module_one'].'</h1>'.'</div>'.'</a>';
            ?>  
        </section>
        <section id="opts">
            <div class="col-md-6 box-imgs no-padding" >
                <?php if(!empty($home['category_mod_two'])){
                    echo '<a href='.router::url(array('controller' => 'shop', 'action' => 'product',$home['category_mod_two'])).'>';
                    }else{
                    echo '<a href='.router::url(array('controller' => 'shop', 'action' => 'index')).'>' ;
                    } 
                    echo $home['module_two'].'<img  class="mod" src='.Configure::read('imageUrlBase').$img_url_two.'  style="padding-left: 0px;padding-right: 0px;"  img-responsive>'.'</a>';
                ?>
            </div>

            <div class="col-md-6 box-imgs no-padding">
            
            <?php if(!empty($home['category_mod_three'])){
                  echo '<a  class="margin" href='.router::url(array('controller' => 'shop', 'action' => 'product',$home['category_mod_three'])).'>';
                 }else{
                  echo '<a  class="margin" href='.router::url(array('controller' => 'shop', 'action' => 'index')).'>' ;
                 } 
                echo $home['module_three'].'<img  class="mod" src='.Configure::read('imageUrlBase').$img_url_three.'  style="padding-left: 0px;padding-right: 0px;"  img-responsive>'.'</a>';
            ?> 
            </div>
        </section>
 

        <!--section id="today">   
            <?php if(!empty($home['category_mod_one'])){
                echo '<a href='.router::url(array('controller' => 'shop', 'action' => 'product',$home['category_mod_one'])).'>';
                }else{
                echo '<a href='.router::url(array('controller' => 'shop', 'action' => 'index')).'>' ;
                } 
                echo '<div class="rectangle" img-responsive style="background-image: url('.Configure::read('imageUrlBase').$img_url_one.');">'.'<h1>'.$home['module_one'].'</h1>'.'</div>'.'</a>';
            ?>  
        </section-->
    <?php if(!empty($home['img_url_four']) && (!empty($home['url_mod_four']) || !empty($home['category_mod_four']))):?>
        <section id="today">
        <?php if(!empty($home['category_mod_four'])){
            echo '<a href='.router::url(array('controller' => 'shop', 'action' => 'product',$home['category_mod_four'])).'>';
        }else{
            if(!empty($home['url_mod_four'])){
                echo '<a href='.$home['url_mod_four'].'>' ;
            } else {
            echo '<a href='.router::url(array('controller' => 'shop', 'action' => 'index')).'>' ;
            }
        } 
            echo '<div class="rectangle" img-responsive style="background-image: url('.Configure::read('imageUrlBase').$img_url_four.');">'.'<h1>'.$home['module_four'].'</h1>'.'</div>'.'</a>';
        ?>  
        </section>
    <?php endif;?>
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
    <?php
    /*$popupBGToSplit=(strpos($home['img_popup_newsletter'], ';')===false)?$home['img_popup_newsletter']:substr($home['img_popup_newsletter'],1);*/
    $popupBG=explode(';', $home['img_popup_newsletter']);
die(pr($popupBG));
    if(empty($popupBG[0])){
        unset($popupBG[0]);
    }
    ?>        
        <div class="modal fade" tabindex="-1" id="myModal" role="dialog">
            <?php if(count($popupBG)>1):?>
            <div class="content">
                <a class="close" data-dismiss="modal">
                    <span></span>
                    <span></span>
                </a>
                <?php echo $this->Form->create('Contact'); ?>
                <?php if(empty($home['text_popup_newsletter'])):?>
                    <h1>Suscribite a nuestro<br /><span>Newsletter</span></h1>
                    <p>Y recibí las últimas novedades</p>
                <?php else:?>
                   <?php echo $home['text_popup_newsletter'];?>
                <?php endif;?>   
                  <input type="email" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
                  <input type="submit" id="enviar" value="ok">
                <?php echo $this->Form->end(); ?> 
                <div id="carousel-newsletter" class="carousel slide" data-ride="carousel">
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">
                    <div class="item active">
                      <img src="<?=Configure::read('imageUrlBase').$popupBG[0]?>">
                    </div>
                    <div class="item">
                      <img src="<?=Configure::read('imageUrlBase').$popupBG[1]?>">
                    </div>
                  </div>
                </div>
            </div>
            <?php else:?>
            <div class="content" style="<?=(!empty($home['img_popup_newsletter']))?'background: url('.Configure::read('imageUrlBase').$popupBG[0].');':''?>">
                <a class="close" data-dismiss="modal">
                    <span></span>
                    <span></span>
                </a>

                    <?php echo $this->Form->create('Contact'); ?>
                <?php if(empty($home['text_popup_newsletter'])):?>
                    <h1>Suscribite a nuestro<br /><span>Newsletter</span></h1>
                    <p>Y recibí las últimas novedades</p>
                <?php else:?>
                   <?php echo $home['text_popup_newsletter'];?>
                <?php endif;?>   
                      <input type="email" name="data[Subscription][email]" placeholder="Ingresá tu email" required>
                      <input type="submit" id="enviar" value="ok">
                    <?php echo $this->Form->end(); ?> 
            </div>
        <?php endif;?>
        </div><!-- /.modal -->
<script>
var myIndex = 0;
//carousel();

function carousel() {
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
