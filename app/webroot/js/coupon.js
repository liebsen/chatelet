function showCouponInput() {
  $('.calc-coupon').show(); 
  $('.coupon-click').hide(); 
  $('.input-coupon').focus();
}

function resetCoupon() {
  var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
  $('.calc-coupon').hide(); 
  $('.coupon-click').show();
  $('#coupon_name').val('')

  if(!window.coupon_bonus) return false
  window.coupon_bonus = 0

  var subtotal = getTotals()
  var delivery_cost = $('#subtotal_envio').val() || 0
  var c2 = event.target.value

  if (!subtotal && carrito.subtotal_price) {
    subtotal = carrito.subtotal_price
  }

  if (!freeShipping && !delivery_cost && carrito.shipping_price) {
    delivery_cost = carrito.shipping_price
  }  
  //console.log('subtotal(2)',subtotal)
  //console.log('delivery_cost(2)',delivery_cost)
  var price = parseFloat(subtotal)
  
  fxTotal(price)

  $('.coupon-discount').addClass('hidden')

  carrito.total_price = parseFloat(price.toFixed(2))
  localStorage.setItem('carrito', JSON.stringify(carrito))
}

function submitCoupon() {
  $('.coupon-info').addClass('hidden')
  $('.coupon-info').removeClass('fadeIn, fadeOutRight')
  // $('.coupon-info').html('')
  var coupon  = $('.input-coupon').val();
  if(!coupon.length) {
    onWarningAlert('Error','Por favor, ingresá un código de cupón')
    return false
  }

  var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
  var items = getItems()
  var subtotal = getTotals()
  var delivery_cost = $('#subtotal_envio').val() || 0
  var c2 = event.target.value

  if (!subtotal && carrito.subtotal_price) {
    subtotal = carrito.subtotal_price
  }

  if (!freeShipping && !delivery_cost && carrito.shipping_price) {
    delivery_cost = carrito.shipping_price
  }

  $('#free_delivery').text('');
  $('.btn-calculate-coupon').button('loading')
  $.post('/carrito/coupon', { coupon: coupon }, function(res, textStatus) {
    $('.btn-calculate-coupon').button('reset')
    
    if( res.status == 'success' ) {

      let coupon_type = res.data.coupon_type
      let discount = parseFloat(res.data.discount)
      let discounted = 0
      let total = 0

      discounted_formatted = formatNumber(res.data.bonus)

      $('.coupon_bonus').text( "$ " + discounted_formatted )
      $('.products-total').removeClass('hidden')
      $('.coupon-discount').removeClass('hidden')
      $('.coupon-discount').addClass('fadeIn')
      // //console.log(parseFloat($('#cost').text()));
      $('.input-coupon').removeClass('wrong');
      $('.input-coupon').addClass('ok');
      onSuccessAlert(`${res.data.code.toUpperCase()}`, res.data.info);
      //$('.coupon-info-title').text(res.data.code)
      $('.coupon-info-info').html(`<span class="text-success text-bold">${res.data.code}</span> - ${res.data.info}`)
      $('.coupon-info').removeClass('hidden')
      $('.coupon-info').addClass('fadeIn')
      $('.promo-code').text(res.data.code)
      $('.free-shipping').addClass('hidden')
      var price = parseFloat(res.data.total) + parseFloat(delivery_cost)
      
      coupon = coupon.toUpperCase()

      //console.log('total(1)',total)
      //console.log('delivery_cost(1)',delivery_cost)
      format_total = formatNumber(price)
      fxTotal(price)

      window.coupon_bonus = discounted
      carrito.total_price = parseFloat(price.toFixed(2))
      $('input[name="coupon"]').val(coupon)
      $('#coupon_name').val("")
      $('.calc-coupon').hide(); 
      $('.coupon-click').show();      
    }else{
      $('.coupon-discount').addClass('hidden')
      //carrito.coupon = ''
      //carrito.coupon_bonus = 0

      // fxTotal(formatNumber(subtotal))
      $('.input-coupon').removeClass('ok');
      $('.input-coupon').addClass('wrong');
      $('#cost').text( '0' );
      //format_total = formatNumber(parseFloat(subtotal) + parseFloat(delivery_cost))            
      //fxTotal(formatNumber(format_total), true)
      timeout = setTimeout( `onErrorAlert('${res.title}', '${res.message}')` , 200);
    }
    localStorage.setItem('carrito', JSON.stringify(carrito))

    // document.querySelector('processed-coupon-data').classList.remove('hidden')
    // document.querySelector('processed-coupon-data').classList.add('fadeIn')
    $('.input-coupon').attr( 'data-valid' , parseInt(res.valid) );
  })

  return false
}