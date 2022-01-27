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
      $.getJSON( url+'/'+cp , function(json, textStatus) {
        document.querySelector('.coupon-loading').classList.add('hide')
        clearTimeout(timeout);
        if( json.valid ){
          if (!json.price || parseInt(json.price) == 0){
            json.price = 114;
          }
          //free delivery
          if (json.freeShipping){  
            // console.log('Envio gratis');
            $('#cost').text( 0 );
            $('#free_delivery').text('Envio gratis!');
          }else{
            let cost = parseInt(json.price)
            let total = formatNumber(parseFloat($('#subtotal_compra').val()) + cost)

            $('#cost').text( cost );
            $('#cost_total').text( total )
            $('.cost_total').removeClass('hidden').css({opacity: 0}).fadeTo('slow', 1)
          }
          // console.log(parseFloat($('#cost').text()));
          $('#cp').removeClass('wrong');
          $('#cp').addClass('ok');
          onSuccessAlert('Codigo Postal válido');
        }else{
          $('#cp').removeClass('ok');
          $('#cp').addClass('wrong');
          $('#cost').text( parseInt(0) );
          timeout = setTimeout( "onErrorAlert('Codigo Postal inexistente.')" , 200);
        }
        $('#cp').attr( 'data-valid' , parseInt(json.valid) );
      });
    }, 2000)
  });