<?php 
	echo $this->element('top');
	echo $this->element('short-header');

	/* Page Content */
	echo $this->fetch('content');
	/* END Page Content */

