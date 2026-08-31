<?php echo $this->Html->script('admin-delete', array('inline' => false));
echo $this->element('admin/menu');
echo $this->Html->css('draggable-table', array('inline' => false));
echo $this->Html->script('draggable-table', array('inline' => false));
echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));
echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));
echo $this->Html->script('admin-categories.js?v=' . $version['ver'], array('inline' => false));
echo $this->Html->script('admin-checklist.js?v=' . $version['ver'], array('inline' => false)); 
?>

<!-- discount-layer -->
<div class="layer discount-layer">
  <span class="close is-clickable" onclick="layerClose()">
      <i class="gi gi-remove_2"></i>
  </span>
  <div class="row">
    <div class="col-xs-12">
      <form id="update_discount">
        <h1 class="discount_mode">
          <span class="category_name"></span>
          <span class="category_name"></span>
        </h1>
        <h3>Establecer productos de <span class="category_name"></span> con descuento por pago por transferencia </h3>
        <div class="form-group">
          <input class="form-control" type="number" id="discount" value="" style="max-width: 8rem;" />
          <label for="mark_all">
            Descuento (%)
          </label>
        </div>                  
        <!--div class="form-group">
          <input class="form-control" type="checkbox" id="expression" value="1" checked/>
          <label for="existent_only">
            Solo las que ya tienen descuento
          </label>
        </div-->
        <div class="form-group d-flex flex-start gap-1">
          <input type="checkbox" id="existent_only" value="1" checked/>
          <label for="existent_only">
            Solo las que ya tienen descuento
          </label>
        </div>                
        <div class="form-group">
            <button type="button" id="discount_btn" class="btn btn-primary" onclick="categoryDiscount()">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="block-section">
	<div class="block-tabs">
		<div class="tab-content">
			<p class="collapse alert alert-success result-message">...</p>
			<table id="categorias-datatables" class="table table-bordered table-hover draggable-table" data-url="/admin/ordernum/category">
				<thead>
					<tr>
						<th class="text-center hidden-phone"><input type="checkbox" name="checksAll" /></th>
						<th class="text-center hidden-phone"><?php echo __('Nombre'); ?></th>        
						<th class="text-center hidden-phone"><?php echo __('Texto'); ?></th>        
						<th class="hidden-phone hidden-tablet"><?php echo __('Ancho'); ?></th> 
						<th class="hidden-phone hidden-tablet"><?php echo __('Posición'); ?></th> 
						<th class="hidden-phone hidden-tablet"><?php echo __('Imagen'); ?></th>    
						<th class="hidden-phone hidden-tablet"><?php echo __('Talle'); ?></th>    
						<th class="text-center hidden-phone"><?php echo __('%OFF Tarjeta'); ?></th>        
						<th class="text-center hidden-phone"><?php echo __('%OFF Banco'); ?></th>
						<th class="span1 text-center"><i class="gi gi-flash"></i></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($cats as $key => $category): ?>
					<tr data-id="<?= $category['Category']['id'] ?>" data-order="<?= $category['Category']['ordernum'] ?>"  class="<?= $category['Category']['visible'] == '1' ? '' : 'bg-danger'?>">
						<td align="center">
							<input type="checkbox" name="checks" value="<?= $category['Category']['id']?>" />
						</td>
						<td>
							<a href="<?=$this->Html->url(array('action'=>'categorias','edit',$category['Category']['id']))?>">
								<span><?=$category['Category']['name']?></span>
							</a>
						</td>
						<td>
							<a href="#preview">
								<span><?=\word_limit($category['Category']['text'])?></span>
							</a>
						</td>
						<td>
							<?php if(empty(@$category['Category']['colsize'])) echo '<span class="text-muted">Auto</span>' ?>
							<?php if(@$category['Category']['colsize'] == '20') echo '20%' ?>
							<?php if(@$category['Category']['colsize'] == '3') echo '25%' ?>
							<?php if(@$category['Category']['colsize'] == '4') echo '33%' ?>
							<?php if(@$category['Category']['colsize'] == '40') echo '40%' ?>
							<?php if(@$category['Category']['colsize'] == '6') echo '50%' ?>
							<?php if(@$category['Category']['colsize'] == '60') echo '60%' ?>
							<?php if(@$category['Category']['colsize'] == '80') echo '80%' ?>
							<?php if(@$category['Category']['colsize'] == '12') echo '100%' ?>
						</td>
						<td>
							<?php if(empty(@$category['Category']['posnum'])) echo '<span class="text-muted">Auto</span>' ?>
							<?php if(@$category['Category']['posnum'] == '1') echo '<span class="text-muted">Auto</span>' ?>
							<?php if(@$category['Category']['posnum'] == '2') echo 'Arriba' ?>
							<?php if(@$category['Category']['posnum'] == '3') echo 'Abajo' ?>
						</td>
						<td>          
							<?php
								if(!empty($category['Category']['img_url'])){
									echo "<a target='_new' class='badge badge-inverse' href='". $settings['upload_url'] . $category['Category']['img_url'] ."''>LINK</a>";
								}
							?>
						</td> 
						<td>          
							<?php
								if(!empty($category['Category']['size'])){
									echo "<a target='_new' class='badge badge-inverse' href='". $settings['upload_url'] . $category['Category']['size'] ."''>LINK</a>";
								}
							?>     
						</td>
						<td>
							<?php
								if(
									!empty($category['Category']['mp_discount_enable'])
								){
									echo '<i class="fa fa-check text-success"></i> ' . ($category['Category']['mp_discount'] ?? '');
								} else {
									echo '<i class="fa fa-ban text-danger"></i>';
								}
							?>     
						</td> 
						<td>
							<?php
								if(
									!empty($category['Category']['bank_discount_enable'])
								){
									echo '<i class="fa fa-check text-success"></i> ' . ($category['Category']['bank_discount'] ?? '');
								} else {
									echo '<i class="fa fa-ban text-danger"></i>';
								}
							?>     
						</td> 
						<td>
							<div class="btn-group d-flex flex-nowrap">
								<!--a 
									href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($category['Category']['name'])))); ?>"
									data-toggle="tooltip" 
									title="Ver en la tienda (Nuevo tab)" 
									target="_blank"
									class="btn btn-info" 
									data-original-title="Editar">
									<i class="fa fa-eye"></i>
								</a--> 
								<a 
									href="<?=$this->Html->url(
										array(
											'action' => 'categorias', 
											'edit', 
											$category['Category']['id'],
											'#' => 'preview'
										)
									)?>"
									data-toggle="tooltip" 
									title="Editar contenido" 
									class="btn btn-info"><i class="gi gi-font"></i>
								</a>
								<a 
									href="<?=$this->Html->url(array('action'=>'categorias','edit',$category['Category']['id']))?>" 
									data-toggle="tooltip" 
									title="Editar" 
									class="btn btn-success" 
									data-original-title="Editar">
									<i class="fa fa-edit"></i>
								</a>
								<a 
									href="#"
									title="Establecer descuento por transferencia"
									class="btn btn-info" 
									onclick="showLayer(event,'discount','bank',<?= @$category['Category']['id'] ?>, '<?= @$category['Category']['name'] ?>')">
									<i class="gi gi-bank"></i>
								</a>
								<a 
									href="#"
									class="btn btn-warning" 
									title="Establecer descuento por mercadopago"
									onclick="showLayer(event,'discount','mp',<?= @$category['Category']['id'] ?>, '<?= @$category['Category']['name'] ?>')">
									<i class="gi gi-credit_card"></i>
								</a>
								<a 
									href="#" 
									data-toggle="tooltip" 
									title="" 
									class="btn btn-danger deletebutton" 
									data-original-title="Eliminar" 
									data-id="<?=$category['Category']['id']?>" 
									data-url-back="<?=$this->Html->url(array('action'=>'categorias'))?>" 
									data-delurl="<?=$this->Html->url(array('action'=>'categorias', 'delete'))?>" 
									data-msg="¿Eliminar categoria? Precación: Se borraran los productos que esten contenidos en esta categoria.">
									<i class="fa fa-trash-o"></i>
								</a>
							</div> 
						</td>
					</tr>
				<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="form-actions category-actions" data-url="/admin/batch_categorias/">
  <span class="selection-count"></span>
  <button class="toggle-selection disableselection btn btn-warning d-none" type="button"><i class="fa fa-eye-slash"></i><span class="ml-1">Desactivar</span></button>
  <button class="toggle-selection removeselection btn btn-danger d-none" type="button"><i class="fa fa-close"></i><span class="ml-1">Eliminar</span></button>
  <button class="toggle-selection enableselection btn btn-success d-none" type="button"><i class="fa fa-check"></i> <span class="ml-1">Activar</span></button>
  <a href="/admin/categorias/add" class="btn btn-success" type="button"><i class="fa fa-magic"></i> <span class="ml-1">Crear</span></a>
</div>
