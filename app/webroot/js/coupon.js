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
          discounted = formatNumber(parseInt(total_orig - total))
          console.log(total_orig)
          console.log(delivery_cost)
          console.log(total)
          console.log(discounted)
          console.log('---')
          total = formatNumber(parseFloat(total + parseInt(delivery_cost)))


          $('#cost').text( total );
          $('.cost_total').text( total )
          $('.coupon_bonus').text( discounted )
          $('.cost_total').removeClass('hidden').css({opacity: 0}).fadeTo('slow', 1)

          document.querySelector('.coupon-discount').classList.remove('hidden')
          document.querySelector('.coupon-discount').classList.add('fadeIn')


          // console.log(parseFloat($('#cost').text()));
          $('#coupon').removeClass('wrong');
          $('#coupon').addClass(json.Coupon.code);
          onSuccessAlert(json.Coupon.info);
        }else{
          $('#coupon').removeClass('ok');
          $('#coupon').addClass('wrong');
          $('#cost').text( parseInt(0) );
          timeout = setTimeout( "onErrorAlert('Cupón inválido.')" , 200);
        }
        // document.querySelector('processed-coupon-data').classList.remove('hidden')
        // document.querySelector('processed-coupon-data').classList.add('fadeIn')
        $('#coupon').attr( 'data-valid' , parseInt(json.valid) );
      });
    }, 2000)
  });