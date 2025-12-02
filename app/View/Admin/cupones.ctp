<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->element('admin-menu'); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>

<div class="block-section table-responsive">
	<table id="cupones-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
				<th class="hidden-phone hidden-tablet"><?php echo __('Código'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Beneficio'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Comprando mínimo'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Categorías'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Productos'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Pagando con'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Activo'); ?></th>
				<th class="hidden-phone hidden-tablet"><?php echo __('Vigente'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($coupons as $key => $coupon): ?> 
				<tr>
					<td>
						<?=$coupon['Coupon']['code']?>
					</td>
					<td>
						<?=$coupon['Coupon']['discount']?><?=$coupon['Coupon']['coupon_type'] === 'percentage' ? '%': 'ARS'?>
					</td>
					<td>
						<?=(int) $coupon['Coupon']['min_amount'] ? "$" . $coupon['Coupon']['min_amount'] : ""?>
					</td>
					<td>
						<?php foreach($coupon['cats'] as $cat):?>
							<span class="badge"><?= $cat["name"] ?></span>
						<?php endforeach ?>
					</td>
					<td>
						<?php foreach($coupon['prods'] as $prod):?>
							<span class="badge"><?= $prod["name"] ?></span>
						<?php endforeach ?>
					</td>
					<td>
						<div class="d-flex justify-content-center align-center gap-1">
							<span title="Pagando con transferencia">
								<?=strpos($coupon['Coupon']['coupon_payment'], 'bank') !== false ? '<i class="gi gi-bank fa-lg text-success"></i>' : '<i class="gi gi-bank fa-lg muted"></i>'?>
							</span>
							<span title="Pagando con Mercadopago">
								<?=strpos($coupon['Coupon']['coupon_payment'], 'mercadopago') !== false ? '<i class="gi gi-credit_card fa-lg text-success"></i>' : '<i class="gi gi-credit_card fa-lg muted"></i>'?>
							</span>
						</div>
					</td>
					<td align="center">
						<?=$coupon['Coupon']['enabled'] ? '<i class="gi gi-check fa-lg text-success"></i>' : '<i class="gi gi-unchecked fa-lg muted"></i>'?>
					</td>

					<td align="center">
						<?=\filtercoupon($coupon)->status !== 'error' ? '<i class="gi gi-check fa-lg text-success"></i>' : '<i class="gi gi-unchecked fa-lg muted"></i>'?>
					</td>
					<td align="center">
						<div class="btn-group">   
							<a 
							href="<?=$this->Html->url(array('action'=>'cupones','edit',$coupon['Coupon']['id']))?>" 
							data-toggle="tooltip" 
							title="" 
							class="btn btn-sm btn-success" 
							data-original-title="Editar">
							<i class="gi gi-pencil"></i>
						</a>             
						<a 
						href="#" 
						data-toggle="tooltip" 
						title="" 
						class="btn btn-sm btn-danger deletebutton" 
						data-original-title="Eliminar" 
						data-id="<?=$coupon['Coupon']['id']?>" 
						data-url-back="<?=$this->Html->url(array('action'=>'cupones'))?>" 
						data-delurl="<?=$this->Html->url(array('action'=>'cupones', 'delete'))?>" 
						data-msg="<?=__('¿Eliminar cupon?')?>"                   
						>
						<i class="gi gi-remove"></i>
					</a>
				</div> 
			</td>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>
</div>