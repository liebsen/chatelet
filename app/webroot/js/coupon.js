  var timeout = null;
  var coupon = '';

  $('.input-coupon').keyup(function(event){
    if (timeout) {
      clearTimeout(timeout)
    }
    var url = $(this).data('url');    
    document.querySelector('.coupon-loading').classList.remove('fadeIn')
    document.querySelector('.coupon-loading').classList.add('fadeIn')
    document.querySelector('.coupon-loading').classList.remove('hide')
    $('.coupon-info').addClass('hidden')
    $('.coupon-info').removeClass('fadeInRight, fadeOutRight')
    // $('.coupon-info').html('')
    event.preventDefault();
    timeout = setTimeout(function () {
      var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
      var coupon  = $('.input-coupon').val();
      var total_orig = $('#subtotal_compra').val()
      var delivery_cost = $('#subtotal_envio').val() || 0
      var c2 = event.target.value
      $('#free_delivery').text('');
      $.post( url, { coupon: coupon }, function(json, textStatus) {
        setTimeout(() => {
          document.querySelector('.coupon-loading').classList.remove('fadeOut', 'fadeIn')
          document.querySelector('.coupon-loading').classList.add('fadeOut')
          document.querySelector('.coupon-loading').classList.add('hide')
        }, 800)
        setTimeout(() => {
          document.querySelector('.coupon-loading').classList.add('hide')
        }, 900)
        clearTimeout(timeout)
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
          discounted = formatNumber(parseFloat(total_orig - total).toFixed(2))

          $('.coupon_bonus').text( discounted )
          $('.products-total').removeClass('hidden')
          $('.coupon-discount').removeClass('hidden')
          $('.coupon-discount').addClass('fadeInRight')

          // console.log(parseFloat($('#cost').text()));
          $('.input-coupon').removeClass('wrong');
          $('.input-coupon').addClass('ok');
          onSuccessAlert(`${json.data.code}`, 'Cupón válido');
          $('.coupon-info-title').text(json.data.code)
          $('.coupon-info-info').text(json.data.info)
          $('.coupon-info').removeClass('hidden')
          $('.coupon-info').addClass('fadeInRight')
          $('.promo-code').text(json.data.code)
          if(!freeShipping) {
            $('.free-shipping').addClass('hidden')
            format_total = formatNumber(parseFloat(total) + parseFloat(delivery_cost))
            $('#cost').text( format_total );
          } else {
            format_total = formatNumber(parseFloat(total_orig) + parseFloat(delivery_cost))
            $('.coupon-discount').addClass('hidden')            
          }
          fxTotal(format_total)
          carrito.coupon = coupon.toUpperCase()
          localStorage.setItem('carrito', JSON.stringify(carrito))
        }else{
          $('.coupon-discount').addClass('hidden')
          fxTotal(formatNumber(total_orig))
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
      });
    }, 2000)
  });