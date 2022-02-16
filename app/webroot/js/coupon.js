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
      // document.querySelector('.coupon-discount').classList.add('hidden')
      $.post( url, { coupon: coupon }, function(json, textStatus) {
        document.querySelector('.coupon-loading').classList.add('hide')
        clearTimeout(timeout)
        if( json.status == 'success' ){
          let coupon_type = json.data.coupon_type
          let discount = parseFloat(json.data.discount)
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
          $('.coupon-text').html(`<h3>${json.data.code}</h3><p>${json.data.info}</p>`)
          $('.coupon-text').removeClass('fadeIn')
          $('.coupon-text').addClass('fadeIn')
        }else{
          $('#coupon').removeClass('ok');
          $('#coupon').addClass('wrong');
          $('#cost').text( '0' );
          console.log(json.message)
          timeout = setTimeout( `onErrorAlert('${json.message}')` , 200);
        }
        // document.querySelector('processed-coupon-data').classList.remove('hidden')
        // document.querySelector('processed-coupon-data').classList.add('fadeIn')
        $('#coupon').attr( 'data-valid' , parseInt(json.valid) );
      });
    }, 2000)
  });