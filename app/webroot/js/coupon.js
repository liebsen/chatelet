  var timeout = null;
  $('#coupon').keyup(function(event){
    if (timeout) {
      clearTimeout(timeout)
    }
    let t = this
    event.preventDefault();
    timeout = setTimeout(function () {
      var url = $(t).data('url');
      var coupon  = $('#coupon').val();
      $('#free_delivery').text('');
      document.querySelector('.coupon-loading').classList.remove('hide')
      document.querySelector('.coupon-discount').classList.add('hidden')
      $.post( url, { coupon: coupon }, function(json, textStatus) {
        document.querySelector('.coupon-loading').classList.add('hide')
        // document.querySelector('.processed-coupon-data').classList.add('hidden')
        // document.querySelector('.processed-coupon-data').classList.remove('fadeIn')
        clearTimeout(timeout)
        console.log(json)
        if( json.Coupon ){
          let coupon_type = json.Coupon.coupon_type
          let discount = parseFloat(json.Coupon.discount)
          let discounted = 0
          let total_orig = $('#subtotal_compra').val()
          let delivery_cost = $('#subtotal_envio').val() || 0
          let total = 0
          let subtotal = 0
          if (coupon_type === 'percentage') {
            total = total_orig * (1 - discount / 100)
          } else {
            total-= discount
          }
          total = parseInt(total)
          discounted = formatNumber(parseInt(total_orig - total))
          total = formatNumber(parseFloat(total + parseInt(delivery_cost)))

          $('#cost').text( total );
          $('.coupon_bonus').text( discounted )
          fxTotal(total)

          document.querySelector('.coupon-discount').classList.remove('hidden')
          document.querySelector('.coupon-discount').classList.add('fadeIn')

          // console.log(parseFloat($('#cost').text()));
          $('#coupon').removeClass('wrong');
          $('#coupon').addClass('ok');
          onSuccessAlert('Cupón válido');
          $('.coupon-text').html(`<h3>${json.Coupon.code}</h3><p>${json.Coupon.info}</p>`)
          $('.coupon-text').removeClass('fadeIn')
          $('.coupon-text').addClass('fadeIn')
        }else{
          $('#coupon').removeClass('ok');
          $('#coupon').addClass('wrong');
          $('#cost').text( parseInt(0) );
          timeout = setTimeout( "onErrorAlert('Cupón inexistente')" , 200);
        }
        // document.querySelector('processed-coupon-data').classList.remove('hidden')
        // document.querySelector('processed-coupon-data').classList.add('fadeIn')
        $('#coupon').attr( 'data-valid' , parseInt(json.valid) );
      });
    }, 2000)
  });