<?php 

echo $this->element('top');
echo $this->element('fbp');
echo $this->element('ga');
echo $this->element(!empty($short_header) ? 'short-header' : 'header');
echo $this->fetch('content');

if(empty($short_header)) {
	echo $this->element('footer');
}

echo $this->element('bottom');
