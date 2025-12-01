<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->element('admin-menu'); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
<div class="block-section">
	<?php if($view == 'searches'): ?>
	<table id="searches-datatables" class="table table-bordered table-hover table-condensed draggable-table" data-url="/admin/search_order">
		<thead>
			<tr>
				<th class="hidden-phone hidden-tablet"><?php echo __('Palabra clave'); ?></th>    
				<th class="hidden-phone hidden-tablet"><?php echo __('Resultados'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Usuario'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($items as $key => $item): ?>
				<tr data-id="<?= $item['Search']['id'] ?>" class="<?=$item['Search']['results']?'bg-success':'bg-danger'?>">
					<td>
						<span class="badge badge-lg badge-info"><?=$item['Search']['name']?></span>
					</td>
					<td>
						<span><?=$item['Search']['results']?></span>
					</td>
					<td> 
					<?php if($item['Search']['user_id']): ?>
						<?=$item['UserJoin']['name']?> <?=$item['UserJoin']['surname']?> (<?=date('Y')-date('Y',strtotime($item['UserJoin']['birthday']))?> años)
					<?php else: ?>
						<span>Anónimo</span>
					<?php endif ?>
					</td> 
					<td> 
						<?=$item['Search']['created']?>
					</td> 
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<?php endif ?>

	<?php if($view == 'analytics'): ?>
	<table id="searches-datatables" class="table table-bordered table-hover table-condensed draggable-table" data-url="/admin/search_order">
		<thead>
			<tr>
				<th class="hidden-phone hidden-tablet"><?php echo __('Página'); ?></th>    
				<th class="hidden-phone hidden-tablet"><?php echo __('Items en Carrito'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Usuario'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($items as $key => $item) : $cart_totals = json_decode($item['Analytic']['cart_totals']); ?>
				<tr data-id="<?= $item['Analytic']['id'] ?>" class="<?=$item['Analytic']['results']?'bg-success':'bg-danger'?>">
					<td>
						<span class="badge badge-lg badge-info"><?=$item['Analytic']['page']?></span>
					</td>
					<td>
						<code class="d-flex flex-column">
							<span>Items: <?=$cart_totals->cart_items?></span>
							<span>Monto: <?=price_format($cart_totals->grand_total)?></span>
						</code>
					</td>
					<td> 
					<?php if($item['Analytic']['user_id']): ?>
						<?=$item['UserJoin']['name']?> <?=$item['UserJoin']['surname']?> (<?=date('Y')-date('Y',strtotime($item['UserJoin']['birthday']))?> años)
					<?php else: ?>
						<span>Anónimo</span>
					<?php endif ?>
					</td> 
					<td> 
						<?=$item['Analytic']['created']?>
					</td> 
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<?php endif ?>

</div>