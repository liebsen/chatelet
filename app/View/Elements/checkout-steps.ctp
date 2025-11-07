<style>
	.wizard-container {
		position: absolute;
	}
	.wizard-progress {
	  display: table;
	  width: 100%;
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
    border-radius: 36px;
    height: 36px;
    width: 36px;
    position: absolute;
    top: 20px;
    left: 50%;
    padding-top: 8px;
    margin-left: -18px;
    font-weight: 600;
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
<div class="wizard-container bg-transparent p-3">
	<div class="wizard-progress is-flex-center justify-content-around w-100">
	<?php foreach($checkout_steps as $i => $step) : ?>
		<div class="wizard-step <?= $i < $checkout_index ? 'complete' : '' ?> <?= $i == $checkout_index ? 'current' : '' ?>">
			<?php echo $step['label'] ?>
			<a href="<?= $i < $checkout_index ? $step['url'] : '#' ?>" class="wizard-node"><?php echo $i + 1 ?></a>
		</div>
	<?php endforeach ?>
	</div>
</div>