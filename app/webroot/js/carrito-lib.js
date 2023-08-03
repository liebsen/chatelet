var updateCart = (carrito) => {
  if(!carrito) {
    carrito = JSON.parse(localStorage.getItem('carrito')) || {}
  }
  Object.keys(carrito).forEach(e => {
    const h = $('#checkoutform').find(`input[name='${e}']`)
    //console.log('?',e)
    if (h.length && carrito[e]) {
      h.val(carrito[e])
    }
    console.log(e, carrito[e])
    if ($(`.${e}`).length) {
      let value = carrito[e]
      if (typeof value === 'number') {
        value = formatNumber(value) 
      }
      $(`.${e}`).html(value)
    }
  })

  if (carrito.cargo === 'takeaway') {
    $('.cargo-takeaway').removeClass('hide')
    $('.cargo-takeaway').addClass('animated fadeIn')
  }

  if (carrito.cargo === 'shipment') {
    var price = ''
    if (carrito.freeShipping) {
      price = '<span class="text-success text-bold">Gratis</span>'
    } else {
      price = `$ ${formatNumber(carrito.shipping_price)}`
    }
    $('.shipping_price').html(price)
    $('.shipping-block').removeClass('hide')
    $('.shipping-block').addClass('animated fadeIn')
  }

  if(!carrito.coupon) {
    $('.coupon-actions-block').removeClass('hide')
    $('.coupon-actions-block').addClass('animated fadeIn')
  } else {
    $('.coupon-block').removeClass('hide')
    $('.coupon-block').addClass('animated fadeIn')
  }

  if (bank.enable && bank.discount_enable && bank.discount) {
    setTimeout(() => {
      onSuccessAlert('Pagá con CBU/Alias', `Y obtené un ${bank.discount}% de descuento en tu compra`);    
    }, 2000)
  }
}

var save_preference = (settings) => {
  console.log('preference',settings)
  $.post('/carrito/preference', $.param(settings))
    .success(function(res) {
      var response = JSON.parse(res)
      if (response.success) {
        var data = response.data
        data.forEach((e) => {
          console.log(e.name, e.price)
        })
        carrito_items = data
        getTotals()
        console.log('preference ok!')
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

$(function () {
  $('#regalo').on('click', (e) => {
    if($(e.target).is(':checked')) {
      onErrorAlert('<i class="fa fa-gift"></i> Es para regalo', 'Prepararemos tu pedido con cuidado para que sea una entrega especial')
    }
  })
})



