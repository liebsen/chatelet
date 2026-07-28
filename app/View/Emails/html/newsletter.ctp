<style type="text/css">
	html, body {
		padding: 0;
		margin: 0;
	}
	.content img, 
	.content table {
		max-width: 100%!important;
	}
</style>    

<?php echo $data['Newsletter']['parsed_body']?>
<?php if($data['NewsletterList']['filter_type'] == 'sales_abandoned_carts'):?>
  <table border="0">
    <tr>
      <td align="center" valign="center" style="text-align: center;">
        <a href="<?=$self_link?>" style="background-color: #333333; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Ver carrito</a>  
      </td>
    </tr>
  </table>
<?php elseif($data['Newsletter']['show_cta'] == '1' && strlen($data['Newsletter']['cta_url'])):?>
  <table border="0">
    <tr>
      <td align="center" valign="center" style="text-align: center;">
        <a href="<?=$data['Newsletter']['cta_url']?>" style="background-color: #333333; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;"><?=$data['Newsletter']['cta_text']?></a>	
      </td>
    </tr>
  </table>
<?php endif ?>
<?php if(!empty($products)): ?>
  <table border="0" cellpadding="0" cellspacing="10">
<?php foreach($products as $i => $product): ?>
<?php if($i%2 == 0||$i==0):?>
  <tr>
<?php endif ?>
    <td valign="top" width="50%">
      <div style="width: 100%; height: 100%; background-color: #ffffff; overflow: hidden;">
        <a href="<?=$product['Product']['link']?>" style="text-decoration: none;">
           <div style="background-repeat: no-repeat;background-position: center center; background-size: cover; background-image: url('<?=$cdn_url?><?=$product['Product']['img_url']?>'); width: 100%; height: 350px; display: block;" alt="<?= $product['Product']['name'] ?>"></div>
        </a>
        <div style="padding: 16px; text-align: center;">
          <h3 style="margin: 0 0 10px 0; font-size: 15px; color: #333333;"><?= $product['Product']['name'] ?></h3>
    <?php if($data['Newsletter']['show_price'] == '1'): ?>
      <p style="font-size: 18px; font-weight: bold; color: #000000; margin: 0 0 10px 0;"><?= \price_format($product['Product']['discount']??$product['Product']['price']) ?></p>
    <?php endif ?>          
          <p style="margin: 0 0 10px 0; font-size: 12px; color: #666666;">🏷️ <?= $product['Category']['name'] ?></p>
    <?php if($data['Newsletter']['show_text'] == '1'): ?>
          <p style="margin: 0 0 15px 0; font-size: 12px; color: #666666;"><?= $product['Product']['desc'] ?></p>
    <?php endif ?>
    <?php if($data['Newsletter']['show_price'] == '1'): ?>
    <?php if(!empty($product['Product']['mp_discount'])): ?>
    	<p style="margin: 0 0 5px 0; font-size: 12px; color: #666666;"><?=$product['Product']['mp_discount']?>% OFF Mercado pago</p>
    <?php endif ?>
    <?php if(!empty($product['Product']['bank_discount'])): ?>
    	<p style="margin: 0 0 5px 0; font-size: 12px; color: #666666;"><?=$product['Product']['bank_discount']?>% OFF Transferencia</p>
    <?php endif ?>
    <?php endif ?>
    	  </div>
    	</div>
    </td>
<?php if(($i%3 == 0 && $i > 1) || ($i == count($products))):?>
  </tr>
<?php endif ?>
<?php endforeach ?>
</table>
<?php endif ?>

<?php if(!empty($newsletter_text)):?>
	<small><?=$newsletter_text?></small>
<?php endif?>
<?php if(!empty($data['NewsletterScheduleItem']['id'])):?>
<?php echo $this->html->image("{$site_url}/newsletter/markread/{$data['NewsletterScheduleItem']['id']}?t=".time(), ['width' => '1px']);?>
<?php endif ?>

<a href="<?="{$site_url}/newsletter/unsubscribe/{$data['NewsletterScheduleItem']['id']}"?>">Deseo desuscribirme de este Newsletter</a>
