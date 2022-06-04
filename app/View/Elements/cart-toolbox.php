
  <!-- bottom bar carrito resume and checkout -->
  <div class="is-bottom is-mobile-resume">
    <div class="field animated speed slideInUp">
      <div class="price text-white">
        <input type="text" name="" placeholder="ej. CHA10" value="" class="input-coupon both input-rounded" data-valid="0" data-url="<?php echo $this->Html->url(array('action'=>'coupon')) ?>" autocomplete="off" />
        <br>
        <span class="cart-bottom-label">Ingrese Cupón</span>
      </div>
    </div>
    <div class="field animated speed slideInUp">
      <div class="price text-white">
        <input type="text" name="" placeholder="ej. 1425" value="" class="input-cp both input-rounded" data-valid="0" data-url="<?php echo $this->Html->url(array('action'=>'delivery_cost')) ?>" />
        <br>
        <span class="cart-bottom-label">Envío (CP)</span>
      </div>
    </div>
    <div class="field">
      <div class="cost_total-container animated speed fadeIn">
        <div class="price text-right text-white">
          <span class="cost_total animated speed delay"><?= $this->Number->currency($total, 'ARS', array('places' => 2)) ?></span>
          <br>
          <span class="cart-bottom-label">Total</span>
        </div>
      </div>
    </div>
    <div class="field">
      <div id="siguiente-block" class="animated speed scaleIn delay2">
        <a href="javascript:void(0)" class="disabled cart-btn-green shrink has-icons cart-go-button" link-to="<?=Router::url('/carrito/checkout',true)?>" id="siguiente">
          <span class="icon"><span class="glyphicon glyphicon-chevron-right"></span>
        </a>
      </div>
    </div>
  </div>
  <!-- end subtotals exlusive mobile -->  