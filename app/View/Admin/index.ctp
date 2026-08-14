<div class="bg-ocean min-height">
		<ul class="list-group list-group-hero animation-fadeIn animation-both delay">
	<?php foreach($navs as $name => $nav): ?>
		<a href="<?=$nav['url']?>">
			<li class="list-group-item text-center">
				<!--span class="badge is-large badge-success indicator"><?= $counts[$nav['id']]?></span-->
				<h1>
					<i class="<?= $nav['icon'] ?>"></i> 
				</h1>
				<h5><?= $name ?>
<?php if(!empty($nav['text'])):?>
<i class="fa fa-question-circle is-clickable ml-1" data-text="<?=$nav['text']?>" title="<?=$nav['text']?>"></i>
<?php endif ?>					
				</h5>
			</li>
		</a>
	<?php endforeach ?>
		<a href="/" target="_blank">
	    <li class="list-group-item text-center">
	    	<h1>
        	<i class="gi gi-shop"></i> 
        </h1>
        <h5>Ir a Tienda</h5>
		  </li>
	  </a>
		<a href="#" class="logout-btn dropdown-toggle">
		  <li class="list-group-item text-center">
	    	<h1>
	        <i class="gi gi-exit"></i> 
        </h1>
        <h5>Salir</h5>
		  </li>
    </a>
		</ul>
	</div>