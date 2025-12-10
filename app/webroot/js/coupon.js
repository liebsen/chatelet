function showCouponInput() {
  $('.calc-coupon').show(); 
  $('.coupon-click').hide(); 
  $('.input-coupon').focus();
}

function resetCoupon() {
  var cart = JSON.parse(localStorage.getItem('cart')) || {}
  $('.calc-coupon').hide(); 
  $('.coupon-click').show();
  $('#coupon_name').val('')

  if(!window.coupon_bonus) return false
  window.coupon_bonus = 0

  var subtotal = getTotals()
  var delivery_cost = 0

  if (!subtotal && cart.subtotal_price) {
    subtotal = cart.subtotal_price
  }

  if (!freeShipping && cart_totals.delivery_cost) {
    delivery_cost = cart_totals.delivery_cost
  }  
  var price = parseFloat(subtotal)
  
  fxTotal(price)

  $('.coupon-discount').addClass('hidden')

  cart.total_price = parseFloat(price.toFixed(2))
  localStorage.setItem('cart', JSON.stringify(cart))
}

function submitCoupon() {
  $('.coupon-info').addClass('hidden')
  $('.coupon-info').removeClass('fadeIn, fadeOutRight')
  var coupon  = $('.input-coupon').val();
  if(!coupon.length) {
    onWarningAlert('Error','Por favor, ingresá un código de cupón')
    return false
  }

  var items = getItems()
  var subtotal = getTotals()
  var delivery_cost = cart_totals.delivery_cost || 0

  if (!subtotal && cart_totals.total_products) {
    subtotal = cart_totals.total_products
  }

  $('#free_delivery').text('');
  $('.btn-calculate-coupon').button('loading')
  $.post('/carrito/coupon', { coupon: coupon.trim() }, function(res, textStatus) {
    $('.btn-calculate-coupon').button('reset')
    if( res.status == 'success' ) {
      let coupon_type = res.data.coupon_type
      var price = parseFloat(res.data.total)      
      let discount = parseFloat(res.data.discount)
      let discounted = 0
      let total = 0

      discounted_formatted = formatNumber(res.data.coupon_benefits)

      $('.coupon_bonus').text( "$ " + discounted_formatted )
      $('.input-coupon-status').removeClass('wrong');
      $('.input-coupon-status').addClass('ok');
      const paying_with = res.paying_with ? ` Pagando con ${res.paying_with}` : ''

      onSuccessAlert(`${res.data.code.toUpperCase()}`, res.data.info + paying_with.toUpperCase());

      $('.coupon-info-info').html(`<span class="text-success text-bold">${res.data.code}</span> - ${res.data.info} ${paying_with.toUpperCase()}`)
      $('.promo-code').text(res.data.code)
      
      coupon = coupon.toUpperCase()
      format_total = formatNumber(price)

      fxTotal(price)
      calcDues(price)
      window.coupon_bonus = discounted

      cart_totals.total_products = parseFloat(price.toFixed(2))

      $('input[name="coupon"]').val(coupon)
      $('.coupon-discount').removeClass('hidden')
    }else{
      $('.input-coupon-status').removeClass('ok');
      $('.input-coupon-status').addClass('wrong');
      $('#cost').text( '0' );
      timeout = setTimeout( `onErrorAlert('${res.title}', '${res.message}')` , 200);
    }
    $('.input-coupon').attr( 'data-valid' , parseInt(res.valid) );
  })

  return false
}