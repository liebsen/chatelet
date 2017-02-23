<?php 
	echo $this->element('top');
	echo $this->element('header');

	/* Page Content */
	echo $this->fetch('content');
	/* END Page Content */

	//echo $this->element('registro-modal');
    echo $this->element('particular-login');
    echo $this->element('particular-password');
    echo $this->element('particular-modal');
 
    echo $this->element('particular-email');


	//echo $this->element('mayorista-modal');
	echo $this->element('footer');

	echo $this->element('bottom');
//    echo $this->element('particular-modal');

?>
