<?php echo $this->Html->script('admin-delete', array('inline' => false)); ?>
<?php echo $this->element('admin-menu'); ?>
<?php echo $this->Html->css('draggable-table', array('inline' => false));?>
<?php echo $this->Html->script('draggable-table', array('inline' => false));?>
<?php echo $this->Html->css('/Vendor/DataTables/datatables.min.css', array('inline' => false));?>
<?php echo $this->Html->script('/Vendor/DataTables/datatables.min.js', array('inline' => false));?>
<?php echo $this->Html->script('admin-categories.js?v=' . Configure::read('APP_VERSION'), array('inline' => false)); ?>

<!-- discount-layer -->
<div class="fullhd-layer discount-layer">
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
          <input class="form-input" type="number" id="discount" value=""/>
          <label for="mark_all">
            Descuento (%)
          </label>
        </div>                  
        <!--div class="form-group">
          <input class="form-input" type="checkbox" id="expression" value="1" checked/>
          <label for="existent_only">
            Solo las que ya tienen descuento
          </label>
        </div-->
        <div class="form-group">
          <input class="form-input" type="checkbox" id="existent_only" value="1" checked/>
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

<!-- end discount-layer -->
<!-- start template -->

<div class="block-section">
	<table id="categorias-datatables" class="table table-bordered table-hover table-condensed draggable-table" data-url="/admin/ordernum/category">
		<thead>
			<tr>
				<th class="text-center hidden-phone"><?php echo __('Nombre'); ?></th>        
				<th class="hidden-phone hidden-tablet"><?php echo __('Ancho'); ?></th> 
				<th class="hidden-phone hidden-tablet"><?php echo __('Posición'); ?></th> 
				<th class="hidden-phone hidden-tablet"><?php echo __('Imagen'); ?></th>    
				<th class="hidden-phone hidden-tablet"><?php echo __('Talle'); ?></th>    
				<th class="span1 text-center"><i class="gi gi-flash"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($cats as $key => $category): ?>
			<tr data-id="<?= $category['Category']['id'] ?>" data-order="<?= $category['Category']['ordernum'] ?>">
				<td>
					<a href="<?=$this->Html->url(array('action'=>'categorias','edit',$category['Category']['id']))?>">
            <div class="d-flex justify-content-start align-items-center gap-1">
              <img src="<?=Configure::read('uploadUrl'). $category['Category']['img_url']?>" width="200" />
						  <span><?=$category['Category']['name']?></span>
            </div>
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
							echo "<a target='_new' class='badge badge-inverse' href='". Configure::read('uploadUrl') . $category['Category']['img_url'] ."''>LINK</a>";
						}
					?>     
				</td> 
				<td>          
					<?php
						if(!empty($category['Category']['size'])){
							echo "<a target='_new' class='badge badge-inverse' href='". Configure::read('uploadUrl') . $category['Category']['size'] ."''>LINK</a>";
						}
					?>     
				</td>
				<td>
					<div class="btn-group">
						<a 
							href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($category['Category']['name'])))); ?>"
							data-toggle="tooltip" 
							title="" 
							target="_blank"
							class="btn btn-sm btn-info" 
							data-original-title="Editar">
							<i class="fa fa-eye"></i>
						</a> 
						<a 
							href="<?=$this->Html->url(array('action'=>'categorias','edit',$category['Category']['id']))?>" 
							data-toggle="tooltip" 
							title="" 
							class="btn btn-sm btn-success" 
							data-original-title="Editar">
							<i class="gi gi-pencil"></i>
						</a>
						<a 
							href="#"
							title="Establecer descuento por transferencia"
							class="btn btn-sm btn-warning" 
							onclick="showLayer(event,'discount','bank',<?= @$category['Category']['id'] ?>, '<?= @$category['Category']['name'] ?>')">
							<i class="gi gi-bank"></i>
						</a>
						<a 
							href="#"
							class="btn btn-sm btn-warning" 
							title="Establecer descuento por mercadopago"
							onclick="showLayer(event,'discount','mp',<?= @$category['Category']['id'] ?>, '<?= @$category['Category']['name'] ?>')">
							<i class="gi gi-credit_card"></i>
						</a>
						<a 
							href="#" 
							data-toggle="tooltip" 
							title="" 
							class="btn btn-sm btn-danger deletebutton" 
							data-original-title="Eliminar" 
							data-id="<?=$category['Category']['id']?>" 
							data-url-back="<?=$this->Html->url(array('action'=>'categorias'))?>" 
							data-delurl="<?=$this->Html->url(array('action'=>'categorias', 'delete'))?>" 
							data-msg="¿Eliminar categoria? Precación: Se borraran los productos que esten contenidos en esta categoria.">
							<i class="gi gi-remove"></i>
						</a>
					</div> 
				</td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
</div>