<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false)) ?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false)) ?>
<?php echo $this->Html->script('bootstrap-datepicker', array('inline' => false)) ?>
<?php echo $this->Html->script('admin-delete.js?v=' . $version['ver'], array('inline'=>false)) ?>
<?php #echo $this->Html->script('admin-filters.js?v=' . $version['ver'], array('inline'=>false)) ?>
<?php echo $this->Html->css('bootstrap-datepicker') ?>
<?php echo $this->element('admin/sales-filter') ?>
	<table id="prods-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
     		<th class="hidden-phone hidden-tablet"><?php echo __('#'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Producto'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Ventas'); ?></th>
			</tr>
		</thead>
		<tbody>
<?php $j=0; foreach ($items as $key => $item): $j++; ?>
			<tr>
				<td style="white-space: nowrap;"><?=\parse_medal($j)?></td>
				<td>
					<?=$item['Product']['name'];?> (<?=$item['Product']['id']?>)
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
	  <a class="btn btn-success dropdown-toggle" href="#" onclick="$('.filter-sales').submit()">
	    <i class="gi gi-filter"></i> <span class="ml-1">Aplilcar filtro</span>
	  </a>
	</div>
