<?php
	echo $this->Session->flash();
?>
<style>
.verifying-stock {
	position: absolute;
	text-align:center;
	width: 100%;
	z-index:1000;
	font-size: 13px;padding:8px;
	background: rgba(255,255,255,0.5);
	color: #999;
}
.desc-prod {
	text-align: center;
	font-weight: normal;
	text-transform: uppercase;
	color: #333;
	line-height: 1.5;
	-webkit-font-smoothing: antialiased;
	font-size: 16px;

	overflow: hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-box-orient: vertical;
	-webkit-line-clamp: 3; /* number of lines to show */
	line-height: 1.4;        /* fallback */
	max-height: 3;       /* fallback */
}
.desc-cont {
	height: 114px;
	overflow: hidden;
}
.price {
	text-align:center;
	height:60px;
	font-size:24px;
	font-family: 'Poppins', Verdana, Arial, sans-serif;
	margin:10px auto 20px;
	color: #444;
}
.antes-str {
	color: #999;
	font-size:24px;
}
.midscore{
	text-decoration:line-through;
}
</style>

<div id="headabrigos" >
      <h1 class="name_shop"><?php echo $name_categories; ?></h1>
 <img class="img_resp" src="<?php echo Configure::read('imageUrlBase').$image_prodshop ?>"  img-responsive>
</div>



<section id="productOptions">
    <div class="container-fluid">
        <div class="row">
            <div class="hidden-xs hidden-sm col-sm-3">
                <nav>
                    <ul>
                        <?php
                    foreach ($categories as $category) {
                        $category = $category['Category'];
                        $slug =  str_replace(' ','-',strtolower($category['name']));
	                      if (strpos($slug, 'trajes')!==false){
	                        $slug = 'trajes-de-bano';
	                      }
                        echo '<li>';
                        echo $this->Html->link(
                            $category['name'],
                            array(
                                'controller' => 'tienda',
                                'action' => 'productos',
                                $slug
                            )
                        );
                        echo '</li>';
                    }
                   ?>
                    </ul>
                </nav>
            </div>

            <div class="col-sm-9">

	<?php
		function createSection($item, $ctrl, $isProduct = false) {
			$stock = (!empty($item['stock_total']))?(int)$item['stock_total']:0;
			$content = '<img class="img-responsive contain-xs"  src="'. Configure::read('imageUrlBase') . $item['img_url'] .'" />';

			if ($isProduct){
				 $content.='<span class="hover">'.
         '<small>'. $item['name'] .'</small>'.
         '</span>';
			}
			$url = array(
				'controller' => 'tienda',
				intval($item['id'])
			);

			if (!empty($item['category_id'])) {
				$url[] = ($item['category_id']);
				$url[] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $item['name'])));

			}

			if ($isProduct) {
				$url['action'] = 'producto';
				$priceStr = '';
				if (!empty($item['price'])){
					$priceStr = $ctrl->Number->currency($item['price'], 'USD', array('places' => 0));
					if (!empty((float)@$item['discount']) && @$item['discount']!==$item['price']){
						$priceStr = $ctrl->Number->currency($item['discount'], 'USD', array('places' => 2)).' <span class="antes-str"><span class="midscore">'.$ctrl->Number->currency($item['price'], 'USD', array('places' => 2)).'</span></span>';
					}
				}

			} else {
				$url['action'] = 'productos';
			}

				if(!$stock && $isProduct){
				echo '<div class="col-xs-12 col-lg-4 col-md-6 col-sm-6" >'.
				     '<img src="'.Router::url('/').'images/agotado3.png" class="out_stock" />'.
				     $ctrl->Html->link(
					$content,
				    $url,
					array('escape' => false)
				).
				'<div class="desc-cont">'.
				'<div class="desc-prod">'.
					'<small>'. $item['name'] .'</small>'.
				'</div>'.
				'<div class="price">'.$priceStr.'</div>
				</div></div>';
      }else{
				$discount_flag = 	(@$_GET['testing']=='1' && @$item['category_id']!='128' || @$item['category_id']!='128' && (int)gmdate('Ym')>201910 && (int)gmdate('Ymd')<20191106)?'<div class="discount-flag">20% OFF</div>':'';
        echo '<div data-id="'.$item["id"].'" class="col-xs-12 col-lg-4 col-md-6 col-sm-6 add-no-stock">'.
			$discount_flag.
					 $ctrl->Html->link(
						$content,
						$url,
						array('escape' => false)
					). '<div class="price">'.$priceStr.'</div>
					</div>';
			}
		}

		if (isset($products)) {
			foreach ($products as $product) {
				createSection($product['Product'], $this, true);
			}
		} else {
			foreach ($categories as $category) {
				createSection($category['Category'], $this);
			}
		}
	?>



            </div>
            <div class="hidden-lg hidden-md visible-xs-* visible-sm-* col-sm-3 col-xs-12">
                <nav>
                    <ul>
                        <?php
                            foreach ($categories as $category) {
                                $category = $category['Category'];
                                $slug =  str_replace(' ','-',strtolower($category['name']));
	                      if (strpos($slug, 'trajes')!==false){
	                        $slug = 'trajes-de-bano';
	                      }
                                echo '<li>';
                                echo $this->Html->link(
                                    $category['name'],
                                    array(
                                        'controller' => 'tienda',
                                        'action' => 'productos',
                                        $slug
                                    )
                                );
                                echo '</li>';
                            }
                           ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>

<section id="infoShop">
    <div class="wrapper">
        <div class="row">
            <div class="col-md-4 bx1">
                Las prendas que estan en el Shop como principal en cada rubro, no estan a la venta.
            </div>
            <div class="col-md-4 bx2 blr">
                Los cambios se realizan dentro de los 30 días de efectuada la compra en cualquiera de las sucursales presentando el ticket correspondiente.
            </div>
            <div class="col-md-4 bx3">
                Las prendas deben estar sin uso y con la etiqueta de código de barras correspondiente adherida.
            </div>
        </div>
    </div>
</section>
<script>
window.baseUrl = "<?=Router::url('/',true)?>";
// check stock
function checkStock(i){
	var item = $(product_list[i]);
	var product_id = $(item).data('id') || $(item).attr('data-id');
	var $html = '<img src="' + baseUrl + 'images/agotado3.png" class="out_stock" />';

	 $.ajax({
        type: "GET",
        url: baseUrl + 'shop/check_stock/' + product_id,
        processData: false,
        contentType: false,
        cache: false,
        success: function(stock){
        	if (stock=='empty'){
        		$(item).prepend($html);
        	}else{
        		console.log(product_id + ' in stock')
        	}
        	$(item).find('.verifying-stock').remove();
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
   });
}
window.product_list = new Array();
$(function(){
	/*
	$('.add-no-stock').each(function(i,item){
		product_list[i] = item;
		setTimeout(function(){
			checkStock(i);
		},500*i)
	})
	*/
})
</script>
<?php

if (!empty($category_id) && (int)$category_id == 57){
?>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 853044157;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/853044157/?guid=ON&amp;script=0"/>
</div>
</noscript>

<?php
}

if (!empty($category_id) && (int)$category_id == 14){
?>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 853044157;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/853044157/?guid=ON&amp;script=0"/>
</div>
</noscript>
<?php
}
?>
