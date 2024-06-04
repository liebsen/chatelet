var coupon = '';
function submitCoupon() {
  console.log('calculate_coupon(1)')
  $('.coupon-info').addClass('hidden')
  $('.coupon-info').removeClass('fadeInRight, fadeOutRight')
  // $('.coupon-info').html('')
  var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
  var coupon  = $('.input-coupon').val();
  if(!coupon.length) {
    onWarningAlert('Error','Por favor, ingresá un código de cupón')
    return false
  }
  var subtotal = parseFloat($('#subtotal_compra').val())
  var delivery_cost = $('#subtotal_envio').val() || 0
  var c2 = event.target.value

  if (!subtotal && carrito.subtotal_price) {
    //console.log('subtotal(2)')
    subtotal = carrito.subtotal_price
  }

  if (!freeShipping && !delivery_cost && carrito.shipping_price) {
    delivery_cost = carrito.shipping_price
  }

  $('#free_delivery').text('');
  $('.btn-calculate-shipping').button('loading')
  $.post('/carrito/coupon', { coupon: coupon }, function(json, textStatus) {
    $('.btn-calculate-shipping').button('reset')
    console.log('calculate_coupon(2)')
    if( json.status == 'success' ) {
      let coupon_type = json.data.coupon_type
      let discount = parseFloat(json.data.discount)
      let discounted = 0
      let total = 0
      if (coupon_type === 'percentage') {
        total = subtotal * (1 - discount / 100)
      } else {
        total = subtotal - discount
      }
      //console.log('total:',total)
      //console.log('total',total)
      //console.log('discount',discount)
      //total = parseFloat(total).toFixed(2)
      discounted = parseFloat(subtotal - total)

      discounted_formatted = formatNumber(discounted)

      $('.coupon_bonus').text( discounted_formatted )
      $('.products-total').removeClass('hidden')
      $('.coupon-discount').removeClass('hidden')
      $('.coupon-discount').addClass('fadeInRight')
      // console.log(parseFloat($('#cost').text()));
      $('.input-coupon').removeClass('wrong');
      $('.input-coupon').addClass('ok');
      onSuccessAlert(`${json.data.code.toUpperCase()}`, json.data.info);
      $('.coupon-info-title').text(json.data.code)
      $('.coupon-info-info').text(json.data.info)
      $('.coupon-info').removeClass('hidden')
      $('.coupon-info').addClass('fadeInRight')
      $('.promo-code').text(json.data.code)
      $('.free-shipping').addClass('hidden')
      var price = parseFloat(total) + parseFloat(delivery_cost)
      
      //console.log('subtotal',subtotal)
      //console.log('delivery_cost',delivery_cost)
      //console.log('discounted',discounted)
      //console.log('price',price)

      coupon = coupon.toUpperCase()

      format_total = formatNumber(price)
      //console.log('total:',total)
      //console.log('price:',price)
      //$('#cost').text( total );
      fxTotal(total)
      carrito.coupon = coupon
      carrito.coupon_bonus = discounted
      carrito.total_price = parseFloat(price.toFixed(2))

      save_preference([
        {'coupon':coupon},
        {'coupon_total':total},
      ])        
    }else{
      $('.coupon-discount').addClass('hidden')
      carrito.coupon = ''
      carrito.coupon_bonus = 0

      // fxTotal(formatNumber(subtotal))
      $('.input-coupon').removeClass('ok');
      $('.input-coupon').addClass('wrong');
      $('#cost').text( '0' );
      format_total = formatNumber(parseFloat(subtotal) + parseFloat(delivery_cost))            
      fxTotal(formatNumber(format_total), true)
      timeout = setTimeout( `onErrorAlert('${json.title}', '${json.message}')` , 200);
    }
    localStorage.setItem('carrito', JSON.stringify(carrito))

    // document.querySelector('processed-coupon-data').classList.remove('hidden')
    // document.querySelector('processed-coupon-data').classList.add('fadeIn')
    $('.input-coupon').attr( 'data-valid' , parseInt(json.valid) );
  })

  return false
}