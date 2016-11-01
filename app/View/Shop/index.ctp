<?php
	echo $this->Html->css('shop', array('inline' => false));
	echo $this->Session->flash();
?>
<div class="container hide">
	<div class="row">
		<div class="col-xs-12 text-center">
			<h1 class="heading" style="margin-top:100px;">Shop momentaneamente deshabilitado.</h1>
		</div>
	</div>
</div>
<div id="main" class="container">
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
</div>