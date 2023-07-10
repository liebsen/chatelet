
var save_preference = (settings) => {
  console.log('preference',settings)
  $.post('/carrito/preference', $.param(settings))
    .success(function(res) {
      var response = JSON.parse(res)
      if (response.success) {
        var data = response.data
        //getTotals(settings.payment_method)
        console.log('preference ok!')
        console.log(data)
      }
    })
    .fail(function() {
      $.growl.error({
        title: 'Ocurrio un error al actualizar el carrito',
        message: 'Por favor, intente nuevamente en unos instantes'
      });
  }); 

  //getTotals(settings.payment_method)
  //var total = subtotal
  /*if (carrito.coupon_bonus) {
    total-= carrito.coupon_bonus
  }

  if (settings) { 
    if(settings.bank_bonus) { // general
      total-= settings.bank_bonus
    }
    if(settings.interest) {
      total*= (Number(settings.interest) / 100) + 1
    }
  }*/


  /*if(settings.payment_method === 'mercadopago' && carrito.mp_bonus) {
    total-= parseFloat(carrito.mp_bonus)
  }

  if(settings.payment_method === 'bank' && carrito.bank_bonus) {
    total-= parseFloat(carrito.bank_bonus)
  }*/


  //console.log('subtotal',subtotal)
  //console.log('total',total)
  //console.log('bank_bonus',bank_bonus)
}
