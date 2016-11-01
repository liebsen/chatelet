<?php $this->Html->css('ayuda', array('inline' => false)); ?>
<div id="main" class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <ul class="list-inline menu">
                <li class="active">
                    <div class="arrow_box">
                        <?php echo $this->Html->link('¿Como Comprar?', array( 'controller' => 'ayuda', 'action' => 'como_comprar' )); ?>
                    </div>
                </li>
                <li>
                    <?php echo $this->Html->link('Envios', array( 'controller' => 'ayuda', 'action' => 'envios')); ?>
                </li>
                <li>
                    <?php echo $this->Html->link('Metodos de Pago', array( 'controller' => 'ayuda', 'action' => 'metodos_de_pago' )); ?>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo $this->Html->image('ayudin3-01-02-01.jpg', array( 'class' => 'img-responsive step' )); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4 content">
            <?php echo $this->Html->link('Continuar', array( 'controller' => 'ayuda', 'action' => 'como_comprar', 3 ), array( 'class' => 'continuar' )); ?>
        </div>
        <div class="col-md-4"></div>
    </div>
    <?php echo $this->element('aclarations') ?>
    <br />
    <br />
    <br />
</div>