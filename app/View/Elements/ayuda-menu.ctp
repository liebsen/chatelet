<?php
	$action = $this->request->action;
?>
<ul class="list-inline menu">
	<li class="<?php if ($action === 'como_comprar') echo 'active' ?>">
		<div class="<?php if ($action === 'como_comprar') echo 'arrow_box' ?>">
	        <?php
	        	echo $this->Html->link('¿Como Comprar?', array(
	        			'controller' => 'ayuda',
	        			'action' => 'como_comprar'
	        		));
	        ?>
        </div>
    </li>
   	<li class="<?php if ($action === 'envios') echo 'active' ?>">
   		<div class="<?php if ($action === 'envios') echo 'arrow_box' ?>">
	       	<?php
	    		echo $this->Html->link('Envios', array(
	    			'controller' => 'ayuda', 
	    			'action' => 'envios'));
	        ?>
        </div>
    </li>
   	<li class="<?php if ($action === 'metodos_de_pago') echo 'active' ?>">
   		<div class="<?php if ($action === 'metodos_de_pago') echo 'arrow_box' ?>">
	       	<?php
        		echo $this->Html->link('Metodos de Pago', array(
        		 		'controller' => 'ayuda',
        		 		'action' => 'metodos_de_pago'
        		 	));
		 	?>
	 	</div>
    </li>
    <li class="<?php if ($action === 'faq') echo 'active' ?>">
   		<div class="<?php if ($action === 'faq') echo 'arrow_box' ?>">
	       	<?php
        		echo $this->Html->link('Preguntas Frecuentes', array(
        		 		'controller' => 'ayuda',
        		 		'action' => 'faq'
        		 	));
		 	?>
	 	</div>
    </li>
</ul>