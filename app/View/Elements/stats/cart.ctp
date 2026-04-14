<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
	<table id="example-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th class="hidden-phone hidden-tablet"><?php echo __('#'); ?></th>    
				<th class="hidden-phone hidden-tablet"><?php echo __('Página'); ?></th>    
				<th class="hidden-phone hidden-tablet"><?php echo __('Items en Carrito'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Usuario'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($items as $key => $item) : $context = json_decode($item['Stat']['context']);?>
				<tr data-id="<?= $item['Stat']['id'] ?>">
					<td>
						<span class="badge badge-lg badge-info"><?=$item['Stat']['id']?></span>
					</td>
					<td>
						<span class="badge badge-lg badge-info"><?=$context->page?></span>
					</td>
					<td>
						<strong class="d-flex flex-column">
							<span>Items: <?=count($context->cart)?></span>
							<span>Monto: <?=price_format($context->cart_totals->grand_total)?></span>
						</strong>
					</td>
					<td>
					<?php if($item['Stat']['user_id']): ?>
						<span class="badge badge-success"><?=$item['User']['name']?> <?=$item['User']['surname']?></span> <span class="badge"><?=date('Y')-date('Y',strtotime($item['User']['birthday']))?> años)</span>
					<?php else: ?>
						<span class="badge badge-danger">Anónimo</span>
					<?php endif ?>
					</td> 
					<td> 
						<span class="badge"><?=$this->Time->format($item['Stat']['created'], '%d/%m/%Y %H:%M')?></span><span class="badge is-rounded"><?=\readable_time_ago(strtotime($item['Stat']['created'])) ?></span>
					</td> 
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
