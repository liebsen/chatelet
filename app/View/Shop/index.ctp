<?php
	echo $this->Html->css('shop', array('inline' => false));
	echo $this->Session->flash();
?>
<!--<div class="container hide">
	<div class="row">
		<div class="col-xs-12 text-center">
			<h1 class="heading" style="margin-top:100px;">Shop momentaneamente deshabilitado.</h1>
		</div>
	</div>
</div>-->


        <div id="headshop">
            <h1>Shop</h1>
        </div>

        <section id="filters">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-4 colors">
                        <h3>Color</h3>
                        <a href="#" class="color celeste"></a>
                        <a href="#" class="color rosa"></a>
                        <a href="#" class="color grisclaro"></a>
                        <a href="#" class="color marron"></a>
                        <a href="#" class="color grisoscuro"></a>
                        <a href="#" class="color verde"></a>
                        <a href="#" class="color azul"></a>
                    </div>
                    <div class="col-md-4 size">
                        <h3>Talle</h3>
                        <a href="#">45</a>
                        <a href="#">44</a>
                        <a href="#">46</a>
                        <a href="#">48</a>
                        <a href="#">50</a>
                        <a href="#">52</a>
                        <a href="#">54</a>
                        <a href="#">56</a>
                    </div>
                    <div class="col-md-4 prices">
                        <h3>Precio</h3>
                        <label><span class="active"><i></i></span><input type="radio" name="price" checked="checked"> $150 - $400</label>
                        <label><span><i></i></span><input type="radio" name="price"> $400 - $700</label>
                        <label><span><i></i></span><input type="radio" name="price"> + $700</label>
                    </div>
                </div>
            </div>
        </section>

        <section id="listShop">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-7">
                                <a href="abrigos.html" class="pd1">
                                    <img src="images/cat1.jpg" class="img-responsive">
                                    <span class="hover">
                                        Abrigos<br>
                                        <small>Visitar categoría</small>
                                    </span>
                                </a>

                                <a href="abrigos.html" class="pd1">
                                    <img src="images/cat2.jpg" class="img-responsive">
                                    <span class="hover">
                                        Abrigos<br>
                                        <small>Visitar categoría</small>
                                    </span>
                                </a>

                                <a href="abrigos.html" class="pd4">
                                    <img src="images/cat7.jpg" class="img-responsive">
                                    <span class="hover">
                                        Abrigos<br>
                                        <small>Visitar categoría</small>
                                    </span>
                                </a>
                            </div>
                            <div class="col-sm-5">
                                <a href="abrigos.html" class="pd2">
                                    <img src="images/cat3.jpg" class="img-responsive">
                                    <span class="hover">
                                        Abrigos<br>
                                        <small>Visitar categoría</small>
                                    </span>
                                </a>

                                <a href="abrigos.html" class="pd2">
                                    <img src="images/cat8.jpg" class="img-responsive">
                                    <span class="hover">
                                        Abrigos<br>
                                        <small>Visitar categoría</small>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-5">
                                <a href="abrigos.html" class="pd3">
                                    <img src="images/cat4.jpg" class="img-responsive">
                                    <span class="hover">
                                        Abrigos<br>
                                        <small>Visitar categoría</small>
                                    </span>
                                </a>

                                <a href="abrigos.html" class="pd3">
                                    <img src="images/cat5.jpg" class="img-responsive">
                                    <span class="hover">
                                        Abrigos<br>
                                        <small>Visitar categoría</small>
                                    </span>
                                </a>
                            </div>
                            <div class="col-sm-7">
                                <a href="abrigos.html" class="pd4">
                                    <img src="images/cat6.jpg" class="img-responsive">
                                    <span class="hover">
                                        Abrigos<br>
                                        <small>Visitar categoría</small>
                                    </span>
                                </a>
                            </div><br clear="all">

                            <div class="col-sm-7">
                                <a href="abrigos.html" class="pd4">
                                    <img src="images/cat9.jpg" class="img-responsive">
                                    <span class="hover">
                                        Abrigos<br>
                                        <small>Visitar categoría</small>
                                    </span>
                                </a>
                            </div>
                            <div class="col-sm-5">
                                <a href="abrigos.html" class="pd2">
                                    <img src="images/cat10.jpg" class="img-responsive">
                                    <span class="hover">
                                        Abrigos<br>
                                        <small>Visitar categoría</small>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="infoShop">
            <div class="wrapper">
                <div class="row">
                    <div class="col-md-4 bx1">
                        Las prendas que estan en el Shop como principal en cada rubro, no estan a la venta.
                    </div>
                    <div class="col-md-4 bx2 blr">
                        Los cambios se realizan dentro de los 30 días de efectuada la compra en cualquiera de las sucursales presentando el ticket correspondiente. 
                    </div>
                    <div class="col-md-4 bx3">
                        Las prendas deben estar sin uso y con la etiqueta de código de barras correspondiente adherida.
                    </div>
                </div>
            </div>
        </section>
<!--<div id="main" class="container">
	<div class="row">
		<div class="col-md-2">
			<h1 class="heading">Shop</h1>
			<ul class="list-unstyled shop-menu">
				<?php
					foreach ($categories as $category) {
						$category = $category['Category'];
						echo '<li>';
						echo $this->Html->link(
							$category['name'], 
							array(
								'controller' => 'shop',
								'action' => 'index',
								intval($category['id'])
							)
						);
						echo '</li>';
					}
				?>
			</ul>
		</div>
		<div class="col-md-10">
			<strong>
				<?php echo $this->element('aclarations') ?>
			</strong>
			<br />
			<?php
				function createSection($item, $ctrl, $isProduct = false) {
					$stock = (!empty($item['stock']))?1:0;
					$content = '<img class="img-responsive" src="'. $ctrl->webroot . 'files/uploads/' . $item['img_url'] .'" />'.
						'<div class="overlay">'.
							'<span class="title" title="'. $item['name'] .'">'. $item['name'] .'</span>'.
						'</div>';
					$url = array(
						'controller' => 'shop',
						intval($item['id'])
					);

					if (!empty($item['category_id'])) {
						$url[] = intval($item['category_id']);
					}

					if ($isProduct) {
						$url['action'] = 'product';
					} else {
						$url['action'] = 'index';
					}

					echo '<span class="out">';
						if(!$stock && $isProduct){
							echo $ctrl->Html->link(
								'<img src="'.Router::url('/').'img/agotado3.png" class="out_stock" />',
								$url,
								array('escape' => false)
							);
						}
						echo '<div class="section">';
							echo $ctrl->Html->link(
								$content,
								$url,
								array('escape' => false)
							);
						echo '</div>';
					echo '</span>';
				}

				if (isset($products)) {
					foreach ($products as $product) {
						createSection($product['Product'], $this, true);
					}
				} else {
					foreach ($categories as $category) {
						createSection($category['Category'], $this);
					}
				}
			?>
		</div>
	</div>
	<br />
	<br />
</div> -->