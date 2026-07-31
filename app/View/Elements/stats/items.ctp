<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->Html->script('schedules', array('inline' => false)); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
	<table id="prods-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
     		<th class="hidden-phone hidden-tablet"><?php echo __('#'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Producto'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Audiencia'); ?></th>
			</tr>
		</thead>
		<tbody>
<?php $j=0; foreach ($items as $key => $item): $j++; ?>
			<tr>
				<td><?=$j?></td>
				<td>
					<?=$item['Product']['name']?> (<?=$item['Product']['id']?>)
				</td>
				<td>
					<span class="badge badge-success is-rounded">
						<?=!empty($item[0]['ProdCount']) ? $item[0]['ProdCount'] : ''?>
					</span>
				</td>
			</tr>
<?php endforeach ?>
		</tbody>
	</table>
	<div class="form-actions">
<?php if(empty($this->params->query['extended'])): ?>
	<a href="/admin/newsletters/schedules?extended=1">
    <button class="btn" type="button"><i class="gi gi-inbox_plus"></i> <span>Ver todo</span></button>
  </a>
<?php else: ?>
	<a href="/admin/newsletters/schedules">
    <button class="btn" type="button"><i class="gi gi-inbox_minus"></i> <span>Ver menos</span></button>
  </a>
<?php endif ?>
  <a class="btn btn-success dropdown-toggle" href="<?=$this->Html->url(array('action'=>'newsletters', 'schedules', 'edit'))?>">
    <i class="gi gi-send"></i> <span class="ml-1">Nueva campaña</span>
  </a>
  <!--a class="btn btn-success btn-update-schedules" href="#">
    <i class="gi gi-repeat"></i> <span class="ml-1">Actualizar</span>
  </a-->
</div>