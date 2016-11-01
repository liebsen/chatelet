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

<div id="main" class="container-fluid">
	<div class="row">
		<div class="col-md-5 grey-column hidden-sm hidden-xs">
			<h1 class="heading no-touch"> 
				<?php echo ucfirst($catalog_first_line) ?><br/><?php echo ucfirst($catalog_second_line) ?></span>
			</h1>
			<p class="subheading"> 
			 <?php echo ucfirst($catalog_text) ?>
			</p>
			<div class="slider-viewport"> <!-- works as a viewport for the 3D transitions -->
				<div id="content-box"><!-- the 3d box -->
					<?php
						$images = explode(';', $cat['Catalog']['images']);
						foreach($images as $key => $image) {
							if (empty($image))
								continue;
							echo ' <figure><!-- slide -->';
								echo '<a id="testing'.$key.'" href="'. $this->webroot . 'files/uploads/' . $image .'" data-lightbox="slider">';
									echo '<img class="img-catalogo" src="'. $this->webroot . 'files/uploads/' . $image .'" />';
								echo '</a>';
							echo '</figure>';
						}
					?>
				</div>
			</div>
		</div>
		<div class="col-md-7 text-center">
			<br />
			<br />
			<br />
			<p>
				<iframe width="640" height="430" src="<?php echo $page_video."?wmode=transparent" ?>" frameborder="0" wmode="Opaque" allowfullscreen></iframe>
			</p>
		</div>
	</div>
</div>