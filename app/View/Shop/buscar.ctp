<?php 
echo $this->Session->flash();
$this->Html->script('vendor/jquery.touchSwipe.min', array('block' => 'script'));
$this->Html->script('carousel-swipe.js?v='.$version['ver'], array('block' => 'script'));
?>
<section id="productOptions">
  <div class="wrapper">
    <div class="row">
      <form name="search">
        <div class="is-flex-center flex-column gap-05 min-h-8">
          <div class="is-flex justify-content-center align-items-center gap-05">
            <div class="form-group">
              <input class="form-control textbig m-0" type="text" name="q" placeholder="Buscar en Châtelet..." value="<?= $q ?>" autofocus required>
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-chatelet" id="enviar" value="Buscar">
            </div>
          </div>
          <span class="text-sm">
          <?php if (count($results ?? [])) : ?>
            Se <?=count($results) > 1 ? 'hallaron' : 'halló'?> <?php echo count($results) ?> producto<?=count($results) > 1 ? 's' : ''?> para <b><?php echo $q ?>.
          <?php else : ?>
            <?php if ( !empty($q) ) : ?>
            No se hallaron productos para <b><?php echo $q ?></b>
          <?php else : ?>
            Ingresa una palabra clave para iniciar la búsqueda, <i>ej: blusa, saco, pantalón, etc... </i>
          <?php endif ?>
          <?php endif ?>
          </span>
        </div>
      </form>
      <div class="container-list">
	      <div class="row">
	        <div class="col-md-3 btBig-container desktop">
            <a href="<?php echo router::url(array('controller' => 'tienda', 'action' => 'index')) ?>" class="btBig">
              volver <br>al <span>SHOP</span>
            </a>
	        </div>
	        <div class="col-md-9 product-list posnum-3">
	          <div class="row w-100">
<?php
foreach($results as $row){ 
	echo $this->App->tile($row['Product'], $settings, 1, $legends, $row['Category']);
}
?>
	          </div>
	        </div>
	      </div>
	    </div>
    </div>
  </div>
</section>

<footer>
	<?php echo $this->element('signature') ?>
</footer>