<?php 

	$short = !empty($short_header);

	echo $this->element('top');
  echo $this->element('fbp');
  echo $this->element('mailchimp');
  echo $this->element('ga');
	echo $this->element($short ? 
		'short-header' : 
		'header'
	);

	/* Page Content */
	echo $this->fetch('content');
	/* END Page Content */

	// echo $this->element('registro-modal');
  // echo $this->element('particular-login');
  // echo $this->element('particular-password');
  // echo $this->element('particular-modal');
  // echo $this->element('particular-email');
	// echo $this->element('mayorista-modal');
	
	if(!$short) {
		echo $this->element('footer');
	}

	echo $this->element('bottom');
