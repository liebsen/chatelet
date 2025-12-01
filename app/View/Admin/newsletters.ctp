<?php 
	echo $this->element('admin-menu');
	echo $this->Html->script('admin-delete', array('inline' => false));	
?>
<div class="row hide-print toolnav-right">
  <div class="col-xs-12 text-right p-2">
		<div class="d-inline dropdown">
		  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    Exportar
		  </button>
		  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
		    <a class="dropdown-item" href="/admin/newsletter_export_emails?limit=100">100</a>
		    <a class="dropdown-item" href="/admin/newsletter_export_emails?limit=250">250</a>
		    <a class="dropdown-item" href="/admin/newsletter_export_emails?limit=500">500</a>
		    <a class="dropdown-item" href="/admin/newsletter_export_emails?limit=1000">1000</a>
		    <a class="dropdown-item" href="/admin/newsletter_export_emails?limit=5000">5000</a>
		    <a class="dropdown-item" href="/admin/newsletter_export_emails?limit=0">Todos</a>
		  </div>
		</div>

    <?php if(!isset($_GET['extended'])) :?>
    <a href="/admin/newsletters?extended=1">
      <button class="btn btn-success" type="button">Ver todas</button>
    </a>
    <?php endif ?>
  </div>
</div>
<div class="block-section">
	<table id="example-datatables" class="table table-bordered table-hover">
		<thead>
			<tr>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Título'); ?></th>
     		<th class="hidden-phone hidden-tablet"><?php echo __('Estado'); ?></th>
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($newsletters as $key => $newsletter): ?>        
				<tr>
					<td>
						<?=$newsletter['Newsletter']['email_title']?>
					</td>
					<td>
						<?=$newsletter['Newsletter']['status']??'waiting'?>
					</td>
					<td>            
						<a 
							href="#" 
							data-toggle="tooltip" 
							title="" 
							class="btn btn-xs btn-danger deletebutton" 
							data-original-title="Eliminar" 
							data-id="<?=$newsletter['Newsletter']['id']?>" 
							data-url-back="<?=$this->Html->url(array('action'=>'newsletters'))?>" 
							data-delurl="<?=$this->Html->url(array('action'=>'newsletters', 'delete'))?>" 
							data-msg="<?=__('¿Eliminar Newsletter?')?>"                   
							>
							<i class="gi gi-remove"></i>
						</a>
				</td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
</div>