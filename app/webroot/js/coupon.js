var coupon = '';
$(function(){
  $('#calculate_coupon').submit(event => {
    var url = $('#calculate_coupon').data('url');    
    $('.coupon-info').addClass('hidden')
    $('.coupon-info').removeClass('fadeInRight, fadeOutRight')
    // $('.coupon-info').html('')
    event.preventDefault();
    var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
    var coupon  = $('.input-coupon').val();
    var total_orig = $('#subtotal_compra').val()
    var delivery_cost = $('#subtotal_envio').val() || 0
    var c2 = event.target.value
    $('#free_delivery').text('');
    $('.btn-calculate-shipping').button('loading')
    $.post( url, { coupon: coupon }, function(json, textStatus) {
      $('.btn-calculate-shipping').button('reset')
      if( json.status == 'success' ) {
        let coupon_type = json.data.coupon_type
        let discount = parseFloat(json.data.discount)
        let discounted = 0
        let total = 0
        let subtotal = 0
        if (coupon_type === 'percentage') {
          total = total_orig * (1 - discount / 100)
        } else {
          total-= discount
        }
        total = parseFloat(total).toFixed(2)
        discounted = parseFloat(parseFloat(total_orig - total).toFixed(2))
        discounted_formatted = formatNumber(discounted)

        $('.coupon_bonus').text( discounted_formatted )
        $('.products-total').removeClass('hidden')
        $('.coupon-discount').removeClass('hidden')
        $('.coupon-discount').addClass('fadeInRight')


        // console.log(parseFloat($('#cost').text()));
        $('.input-coupon').removeClass('wrong');
        $('.input-coupon').addClass('ok');
        onSuccessAlert(`${json.data.code}`, '✓ Cupón válido');
        $('.coupon-info-title').text(json.data.code)
        $('.coupon-info-info').text(json.data.info)
        $('.coupon-info').removeClass('hidden')
        $('.coupon-info').addClass('fadeInRight')
        $('.promo-code').text(json.data.code)
        $('.free-shipping').addClass('hidden')
        var price = parseFloat(total) + parseFloat(delivery_cost)
        format_total = formatNumber(price)
        $('#cost').text( format_total );
        fxTotal(format_total)
        carrito.coupon = coupon.toUpperCase()
        carrito.coupon_bonus = discounted
        carrito.total_price = price
        localStorage.setItem('carrito', JSON.stringify(carrito))
      }else{
        $('.coupon-discount').addClass('hidden')

        // fxTotal(formatNumber(total_orig))
        $('.input-coupon').removeClass('ok');
        $('.input-coupon').addClass('wrong');
        $('#cost').text( '0' );
        format_total = formatNumber(parseFloat(total_orig) + parseFloat(delivery_cost))            
        fxTotal(formatNumber(format_total), true)
        timeout = setTimeout( `onErrorAlert('${json.title}', '${json.message}')` , 200);
      }
      // document.querySelector('processed-coupon-data').classList.remove('hidden')
      // document.querySelector('processed-coupon-data').classList.add('fadeIn')
      $('.input-coupon').attr( 'data-valid' , parseInt(json.valid) );
    })

    return false
  })
})