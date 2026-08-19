	<ul class="list-group list-group-hero animation-fadeIn animation-both delay">
	<?php foreach($navs as $name => $nav): ?>
		<a href="<?=$nav['url']?>">
			<li class="list-group-item text-center">
<?php if(!empty($counts[$nav['id']])):?>				
				<span class="badge is-large badge-info">
					<span class="indicator"><?= $counts[$nav['id']]?></span>
				</span>
<?php endif ?>
				<h1>
					<i class="<?= $nav['icon'] ?>"></i> 
				</h1>
				<h5><?= $name ?>
<?php if(!empty($nav['text'])):?>
<i class="fa fa-question-circle is-clickable ml-1" data-text="<?=$nav['text']?>"></i>
<?php endif ?>
				</h5>
			</li>
		</a>
	<?php endforeach ?>
	</ul>