		<ul class="list-group list-group-hero animation-fadeIn animation-both delay">
	<?php foreach($navs as $name => $nav): ?>
		<a href="<?=$nav['url']?>">
			<li class="list-group-item text-center">
				<h1>
					<i class="<?= $nav['icon'] ?>"></i> 
				</h1>
				<h5><?= $name ?></h5>
			</li>
		</a>
	<?php endforeach ?>
		</ul>