  var timeout = null;
  $('#coupon').keyup(function(event){
    if (timeout) {
      clearTimeout(timeout)
    }
    let t = this
    event.preventDefault();
    timeout = setTimeout(function () {
      var url = $(t).data('url');
      var cp  = $('#coupon').val();
      $('#free_delivery').text('');
      document.querySelector('.coupon-loading').classList.remove('hide')
      $.post( url, { coupon: cp }, function(json, textStatus) {
        document.querySelector('.coupon-loading').classList.add('hide')
        document.querySelector('processed-coupon-data').classList.add('hidden')
        document.querySelector('processed-coupon-data').classList.remove('fadeIn')
        clearTimeout(timeout)
        console.log(json)
        if( json.Coupon ){
          let coupon_type = json.Coupon.coupon_type
          let discount = parseFloat(json.Coupon.discount)
          let total_orig = $('#subtotal_compra').val()
          let total = 0
          let subtotal = 0
          if (coupon_type === 'percentage') {
            total = total_orig * (1 - discount / 100)
          } else {
            total-= discount
          }
          console.log(total_orig)
          console.log(total)
          console.log('---')
          total = formatNumber(parseFloat(total.toFixed(2)))

          $('#cost').text( total );
          $('#cost_total').text( total )
          $('#coupon_bonus').text( total )
          $('.cost_total').removeClass('hidden').css({opacity: 0}).fadeTo('slow', 1)


          // console.log(parseFloat($('#cost').text()));
          $('#cp').removeClass('wrong');
          $('#cp').addClass(json.Coupon.code);
          onSuccessAlert(json.Coupon.info);
        }else{
          $('#cp').removeClass('ok');
          $('#cp').addClass('wrong');
          $('#cost').text( parseInt(0) );
          timeout = setTimeout( "onErrorAlert('Cupón inválido.')" , 200);
        }
        document.querySelector('processed-coupon-data').classList.remove('hidden')
        document.querySelector('processed-coupon-data').classList.add('fadeIn')
        $('#cp').attr( 'data-valid' , parseInt(json.valid) );
      });
    }, 2000)
  });