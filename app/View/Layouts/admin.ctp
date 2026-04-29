<?php
	echo $this->element('admin/navbar');
	echo $this->element('admin/sidebar');
?>
	<!-- Page Content -->
	<div id="page-content">
	    <?php echo $this->fetch('content'); ?>
	</div>
	<!-- END Page Content -->
<?php
	echo $this->element('admin/footer');
	echo $this->element('admin/bottom');
?>
