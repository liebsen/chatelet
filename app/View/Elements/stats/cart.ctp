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
			<?php foreach ($items as $key => $item) : $context = json_decode($item['Stat']['context'], true);?>
				<tr data-id="<?= $item['Stat']['id'] ?>">
					<td>
						<span class="badge badge-lg badge-info">#<?=$item['Stat']['id']?></span>
					</td>
					<td>
						<span class="badge badge-lg badge-info text-lowercase"><?=$context['page']?></span>
					</td>
					<td>
						<strong class="d-flex flex-column toggle-display is-clickable" data-target=".cart-details">
							<span class="badge badge-info text-left"><i class="gi gi-shopping_cart"></i> <?=count($context['cart'])?></span>
							<span class="badge badge-info text-left"><i class="gi gi-money"></i> <?=price_format($context['cart_totals']['grand_total'])?></span>
						</strong>
						<div class="cart-details d-none">
							<ul class="list-group">
							<?php foreach($context['cart'] as $item2):?>
								<li class="list-group-item"><?=$item2['name']?></li>
							<?php endforeach ?>
							</ul>
						</div>
					</td>
					<td>
					<?php if(!empty($item['User']['id']) && $item['User']['id'] > 1): ?>
						<?php if(strlen($item['User']['name'])):?>
						<span class="badge badge-success" title="<?=$item['User']['name']?> <?=$item['User']['surname']?>">
							<?=$item['User']['name']?> <?=$item['User']['surname']?>
						</span>
						<?php endif ?>
						<span class="badge text-lowercase"><?=$item['User']['email']?></span>
						<span class="badge"><?=date('Y', strtotime('last year'))-date('Y',strtotime($item['User']['birthday']))?> años</span>
					<?php else: ?>
						<span class="badge badge-danger">Anónimo</span>
					<?php endif ?>
					</td> 
					<td> 
						<span class="badge text-capitalize"><?=$this->Time->format($item['Stat']['created'], '%d/%m/%Y %H:%M')?></span><span class="badge text-lowercase"><?=\readable_time_ago($item['Stat']['created']) ?></span>
					</td> 
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
