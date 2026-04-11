<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
	<table id="example-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th class="hidden-phone hidden-tablet"><?php echo __('Página'); ?></th>    
				<th class="hidden-phone hidden-tablet"><?php echo __('Items en Carrito'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Usuario'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($items as $key => $item) : $cart = json_decode($item['Stat']['cart']); $cart_totals = json_decode($item['Stat']['cart_totals']); ?>
				<tr data-id="<?= $item['Stat']['id'] ?>">
					<td>
						<span class="badge badge-lg badge-info"><?=$item['Stat']['page']?></span>
					</td>
					<td>
						<strong class="d-flex flex-column">
							<span>Items: <?=count($cart)?></span>
							<span>Monto: <?=price_format($cart_totals->grand_total)?></span>
						</strong>
					</td>
					<td> 
					<?php if($item['Stat']['user_id']): ?>
						<?=$item['User']['name']?> <?=$item['User']['surname']?> (<?=date('Y')-date('Y',strtotime($item['User']['birthday']))?> años)
					<?php else: ?>
						<span>Anónimo</span>
					<?php endif ?>
					</td> 
					<td> 
						<?=$item['Stat']['created']?>
					</td> 
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
