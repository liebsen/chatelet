<?php 
	echo $this->element('admin-menu');
	echo $this->Html->script('admin-delete', array('inline' => false));
?>
<div class="row hide-print">
  <div class="col-xs-12">
    <a href="/admin/subscription_export_mails" target="_blank">
      <button class="btn btn-success" type="button">Exportar Emails</button>
    </a> 
    <?php if(!isset($_GET['extended'])) :?>
    <a href="/admin/subscriptions?extended=1">
      <button class="btn btn-success" type="button">Ver todas</button>
    </a>
    <?php endif ?>
  </div>
</div>
<div class="block-section">
	<table id="example-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
     			<th class="hidden-phone hidden-tablet"><?php echo __('Email'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($subscriptions as $key => $subscription): ?>        
				<tr>
				                 
					<td>
						<?=$subscription['Subscription']['email']?>
					</td>
				
					<td>            
						<a 
						href="#" 
						data-toggle="tooltip" 
						title="" 
						class="btn btn-xs btn-danger deletebutton" 
						data-original-title="Eliminar" 
						data-id="<?=$subscription['Subscription']['id']?>" 
						data-url-back="<?=$this->Html->url(array('action'=>'subscriptions'))?>" 
						data-delurl="<?=$this->Html->url(array('action'=>'subscriptions', 'delete'))?>" 
						data-msg="<?=__('¿Eliminar Newsletter?')?>"                   
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