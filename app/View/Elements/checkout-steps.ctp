<?php $segs = 5 ?>
<?php if(empty($cart)) :?>

<div class="container">
	<span>Tu carrito está vacío. <a class="cart-empty-redirect" href="/shop">Te redireccionaremos automáticamente a la tienda</a> en <span class="segs"><?php echo $segs ?></span></span>
	<script type="text/javascript">
		let segs = <?php echo $segs ?>;
		let interval = 0;
		interval = setInterval(() => {
			$('.segs').text(segs)
			segs--
			if(segs == 0) {
				clearInterval(interval)
				$('.cart-empty-redirect').click()
			}
		}, 1000)
	</script>
</div>

<?php else : ?>

<div class="wizard-container d-flex flex-column justify-content-center align-items-center is-absolute top-0 animated slideInDown delay1">
	<span class="navbar-brand wizard-brand"></span>
	<div class="wizard-progress is-flex-center justify-content-around w-100">
	<?php foreach($checkout_steps as $i => $step) : ?>
		<div class="wizard-step <?= $i < $checkout_index ? 'complete' : '' ?> <?= $i == $checkout_index ? 'current' : '' ?>">
			<span class="wizard-label"><?php echo $step['label'] ?></span>
			<a href="<?= $i < $checkout_index ? $step['url'] : '#' ?>" class="wizard-node"><?php echo $i + 1 ?></a>
		</div>
	<?php endforeach ?>
	</div>
</div>

<style>
	.wizard-container {
		padding: 1.5rem;
	}

	.wizard-brand {
		display: none;
		position: relative;
    top: -0.5rem;		
	}
	
	body.top-fixed .wizard-brand {
		display: block;
	}

	body.top-fixed .wizard-container {
		position: fixed;
		background-color: white;
		padding: 0.5rem;
		z-index: 9;
		top: 0;
		left: 0;
		right: 0;
	}

	.wizard-progress {
	  display: table;
	  width: 100%;
	  min-height: 4rem;
	  table-layout: fixed;
	  position: relative;		
	}
	.wizard-step {
    display: table-cell;
    text-align: center;
    vertical-align: top;
    overflow: visible;
    position: relative;
    font-size: 14px;
    color: #ccc;
    font-weight: 300;
	}
	.wizard-label {
		position: relative;
		left: -2px;
	}
	.wizard-progress .wizard-step:not(:last-child):before {
		content: "";
    display: block;
    position: absolute;
    left: 50%;
    top: 37px;
    background-color: #ccc;
    height: 2px;
    width: 100%;
  }
  .wizard-progress .wizard-step.complete:before {
  	background-color: #333;
  }
	.wizard-progress .wizard-node {
		display: inline-block;
    border: 1px solid #ccc;
    background-color: #fff;
    color: #ccc;
    border-radius: 32px;
    height: 32px;
    width: 32px;
    position: absolute;
    top: 22px;
    left: 50%;
    padding-top: 6px;
    line-height: 1.3;
    margin-left: -18px;
    font-weight: 800;
	}
	.wizard-progress .wizard-step.complete {
		color: #333;
	}
	.wizard-progress .wizard-step.current {
		color: #333;
		font-weight: bold;
	}	
	.wizard-progress .wizard-step.complete .wizard-node {
		border-color: #333;
		color: white;
		background-color: #333;
	}
	.wizard-progress .wizard-step.current .wizard-node {
		border-color: #333;
		color: #333;
	}
</style>

<?php endif ?>