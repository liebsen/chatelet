<?php // echo $this->Html->script('newsletters-lists', array('inline' => false)); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->Html->script('logs', array('inline' => false)); ?>


<div class="d-flex flex-column gap-05">
<?php if(empty($lines)):?>
		<div class="notification">
			<h4>Nada de listas por aquí</h4>
			<p class="text-theme">No hay nada que mostrar por ahora aquí. <?=empty($this->request->query('extended')) ?'<hr><a href="#"><i class="gi gi-lightbulb mr-1"></i> Intenta presionando en Ver todo</a>' : ''?></p>
		</div>
	<?php else: ?>
		<form name="form-logs" method="get">
			<label>fsize: <?=$fsize?>Mb - lines: <?=$lines_count?></label>
			<div class="d-flex flex-center gap-05">
				<input type="number" class="form-control" name="lines" placeholder="lines" value="<?=$lines_count?>">
				<input type="submit" class="btn btn-light" value="Actualizar">
			</div>
		</form>
		<pre class="log">
<?php echo implode("", $lines) ?>
		</pre>
<?php endif ?>
</div>
<div class="form-actions">
  <button class="btn button-update-schedules animation-fadeIn animation-both delay3">
    <i class="gi gi-repeat"></i> 
    <span class="ml-1">Actualiza </span> 
    <small>(</small><small class="update-countdown">-</small><small>s)</small>
  </button>	
<?php if(empty($this->params->query['extended'])): ?>
	<a href="?lines=0">
    <button class="btn" type="button"><i class="gi gi-inbox_plus"></i> <span class="ml-1">Ver todo</span></button>
  </a>
<?php else: ?>
	<a href="?lines=10">
    <button class="btn" type="button"><i class="gi gi-inbox_minus"></i><span class="ml-1">Ver menos</span></button>
  </a>
<?php endif ?>
</div>