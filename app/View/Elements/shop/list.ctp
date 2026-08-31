<script type="text/javascript">
	function loadFont(font){
		const filename = 'https://fonts.googleapis.com/css?family='+encodeURIComponent(font)+':300,400,500,600,700,800,900,1000';
		var link = document.createElement('link');
	  link.rel = 'stylesheet';
	  link.type = 'text/css';
	  link.href = filename;
	  document.getElementsByTagName('head')[0].appendChild(link);
	}
</script>
    <div class="wrapper-fluid">
      <div class="row m-0">
        <div class="col-xs-12">
          <div class="row category-item-container">
          <?php $loaded_fonts = []; foreach($categories as $category): ?>
<?php if(!empty($category['Category']['text_style'])) {
	$temp = @json_decode($category['Category']['text_style']);
	$category['Category']['text_style'] = $temp;
	if(!empty($category['Category']['text_style']->font_family) && !in_array($category['Category']['text_style']->font_family, $loaded_fonts)) {
		?><script type="text/javascript">loadFont('<?=$category['Category']['text_style']->font_family?>');</script><?php 
		$loaded_fonts[]= $category['Category']['text_style']->font_family;
	}
} ?>
            <div class="category-item p-1 col-xs-12 col-md-<?= !empty($category['Category']['colsize']) ? $category['Category']['colsize'] : 'auto' ?>">
              <div class="category-content posnum-<?=$category['Category']['posnum'] ?? 'auto' ?>" style="background-image: url('<?php echo $settings['upload_url'].$category['Category']['img_url']?>')">
                <a href="<?php echo $this->Html->url(array('controller' => 'tienda', 'action' => 'productos', str_replace(array('ñ',' '),array('n','-'),strtolower($category['Category']['name'])))); ?>" class="pd1 text-center">
                  <div class="category-image alignnum-<?=$category['Category']['alignnum'] ?? '0' ?> p-3 w-100">  
                  	<?php if($category['Category']['show_text'] == '1'):?>
                    <span class="p-1 text-catalog" style="color: <?=$category['Category']['text_style']->color ?? 'white'?>">
                    	<?php if($category['Category']['show_name'] == '1'):?>
                      <span class="text-uppercase"><?=$category['Category']['name']?></span>
                      <?php endif ?>
                      <span class="p-1 p-catalog" style="font-size: <?=$category['Category']['text_style']->font_size ?? '12'?>px; font-weight: <?=$category['Category']['text_style']->font_weight ?? '300'?>;font-family: <?=$category['Category']['text_style']->font_family ?? 'inherit'?>; -webkit-text-stroke: <?=$category['Category']['text_style']->shadow_width ?? '0'?>px <?=$category['Category']['text_style']->shadow_color ?? 'transparent'?>;"><?=$category['Category']['text']?></span>
                    </span>
                  	<?php endif ?>
                  </div>
                </a>
              </div>
            </div>
          <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>