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
			$images[] 	= Router::url('/',true).'files/uploads/'.$value;
	}
?>
<div id="main" class="main">	
	<?php if (count($images) == 1){ ?>
		<img class="img-responsive" src="<?php echo $images[0]; ?>" />
	<?php }else{ ?>
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
		  	<?php foreach ($images as $key => $value): ?>
		  		<li data-target="#carousel-example-generic" data-slide-to="<?php echo $key ?>" class="<?php echo (!$key)?'active':''; ?>"></li>
		  	<?php endforeach ?>
		  </ol>

		  <!-- Wrapper for slides -->
		  <div class="carousel-inner">
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
		  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left"></span>
		  </a>
		  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right"></span>
		  </a>
		</div>
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
</div>