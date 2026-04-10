<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
	<table id="example-datatables" class="table table-bordered table-hover">
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
				<tr data-id="<?= $item['Search']['id'] ?>">
					<td>
						<span class="badge badge-lg badge-info"><?=$item['Search']['name']?></span>
					</td>
					<td>
						<span><?=$item['Search']['results']?></span>
					</td>
					<td> 
					<?php if($item['Search']['user_id']): ?>
						<?=$item['UserJoin']['name']?> <?=$item['UserJoin']['surname']?> (<?=date('Y', strtotime('last year'))-date('Y',strtotime($item['UserJoin']['birthday']))?> años)
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
