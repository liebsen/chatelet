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
