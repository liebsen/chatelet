<?php
	echo $this->element('top-admin');
	echo $this->element('side-admin');
?>
	<!-- Pre Page Content -->
	<!--div id="pre-page-content">
	    <h1><i class="<?php echo $h1['icon'] ?> themed-color"></i><?php echo $h1['name']; ?><br>
	    	<?php if (isset($h1['sub'])): ?>
	    		<small><?php echo $h1['sub']; ?></small>
	    	<?php endif ?>	
	    </h1>
	</div-->
	<!-- END Pre Page Content -->

	<!-- Page Content -->
	<div id="page-content">
	    <?php echo $this->fetch('content'); ?>
	</div>
	<!-- END Page Content -->
<?php
	echo $this->element('footer-admin');
	echo $this->element('bottom-admin');
?>