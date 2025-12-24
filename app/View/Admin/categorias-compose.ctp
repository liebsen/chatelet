<?php
echo $this->element('admin-menu');
echo $this->Html->css('draggable-compose.css?v=' . Configure::read('APP_VERSION'), array('inline' => false));
echo $this->Html->script('draggable-compose.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
?>

<div class="block-section">
	<section id="listShop">
    <?php echo $this->element('shop_list_compose') ?>
  </section>
</div>

<style type="text/css">
	.p-0 {
		padding: 0;
	}
	.category-item {
		height: 200px;
	}
	.category-image {
		height: 200px;
    transition: all .3s ease-in-out;
	}
	.category-item-image {
		display: block;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: top center;
    transition: all 0.5s ease-in;
    outline: 4px solid #ccc;
    border: none;
}
</style>