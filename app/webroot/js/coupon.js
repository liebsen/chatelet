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
  var delivery_cost = $('#subtotal_envio').val() || 0
  var c2 = event.target.value

  if (!subtotal && cart.subtotal_price) {
    subtotal = cart.subtotal_price
  }

  if (!freeShipping && !delivery_cost && cart.shipping_price) {
    delivery_cost = cart.shipping_price
  }  
  //console.log('subtotal(2)',subtotal)
  //console.log('delivery_cost(2)',delivery_cost)
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

  var cart = JSON.parse(localStorage.getItem('cart')) || {}
  var items = getItems()
  var subtotal = getTotals()
  var delivery_cost = cart.shipping_price
  var c2 = event.target.value

  if (!subtotal && cart.subtotal_price) {
    subtotal = cart.subtotal_price
  }

  $('#free_delivery').text('');
  $('.btn-calculate-coupon').button('loading')
  $.post('/carrito/coupon', { coupon: coupon.trim() }, function(res, textStatus) {
    $('.btn-calculate-coupon').button('reset')
    if( res.status == 'success' ) {
      console.log(res)
      let coupon_type = res.data.coupon_type
      var price = parseFloat(res.data.total)      
      let discount = parseFloat(res.data.discount)
      let discounted = 0
      let total = 0

      discounted_formatted = formatNumber(res.data.bonus)

      $('.coupon_bonus').text( "$ " + discounted_formatted )
      $('.input-coupon').removeClass('wrong');
      $('.input-coupon').addClass('ok');

      onSuccessAlert(`${res.data.code.toUpperCase()}`, res.data.info);

      $('.coupon-info-info').html(`<span class="text-success text-bold">${res.data.code}</span> - ${res.data.info}`)
      $('.promo-code').text(res.data.code)
      
      coupon = coupon.toUpperCase()
      format_total = formatNumber(price)

      fxTotal(price)
      calcDues(price)
      window.coupon_bonus = discounted

      cart.total_price = parseFloat(price.toFixed(2))

      $('input[name="coupon"]').val(coupon)
      // $('#coupon_name').val("")
      // $('.calc-coupon').hide(); 
      // $('.coupon-click').show();
    }else{
      // $('.coupon-discount').addClass('hidden')
      $('.input-coupon').removeClass('ok');
      $('.input-coupon').addClass('wrong');
      $('#cost').text( '0' );
      timeout = setTimeout( `onErrorAlert('${res.title}', '${res.message}')` , 200);
    }
    localStorage.setItem('cart', JSON.stringify(cart))
    $('.input-coupon').attr( 'data-valid' , parseInt(res.valid) );
  })

  return false
}