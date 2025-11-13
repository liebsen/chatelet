<?php 
	echo $this->element('top');
  echo $this->element('facebook-pixel-id');
  echo $this->element('google-analytics-code');
	echo $this->element(!empty($short_header) ? 'short-header' : 'header');

	/* Page Content */
	echo $this->fetch('content');
	/* END Page Content */

	// echo $this->element('registro-modal');
  // echo $this->element('particular-login');
  // echo $this->element('particular-password');
  // echo $this->element('particular-modal');
  // echo $this->element('particular-email');
	// echo $this->element('mayorista-modal');
	
	if(empty($short_header)) {
		echo $this->element('footer');
	}
	echo $this->element('bottom');
