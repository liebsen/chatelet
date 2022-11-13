<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->element('admin-menu'); ?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
<div class="block-section">
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
			<?php foreach ($searches as $key => $search): ?>
				<tr data-id="<?= $search['Search']['id'] ?>" class="<?=$search['Search']['results']?'bg-success':'bg-danger'?>">
					<td>
						<span class="badge badge-lg badge-info"><?=$search['Search']['name']?></span>
					</td>
					<td>
						<span><?=$search['Search']['results']?></span>
					</td>
					<td> 
					<?php if($search['Search']['user_id']): ?>
						<?=$search['UserJoin']['name']?> <?=$search['UserJoin']['surname']?> (<?=date('Y')-date('Y',strtotime($search['UserJoin']['birthday']))?> años)
					<?php else: ?>
						<span>Anónimo</span>
					<?php endif ?>
					</td> 
					<td> 
						<?=$search['Search']['created']?>
					</td> 
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>