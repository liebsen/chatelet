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
    //console.log(e, carrito[e])
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
      onWarningAlert('Pagá con CBU/Alias', `Y obtené un ${bank.discount}% de descuento en tu compra`);    
    }, 2000)
  }
}

var save_preference = (settings) => {
  //console.log('preference',settings)
  $.post('/carrito/preference', $.param(settings))
    .success(function(res) {
      var response = JSON.parse(res)
      if (response.success) {
        var data = response.data
        /*data.forEach((e) => {
          console.log(e.name, e.price)
        })*/
        carrito_items = data
        getTotals()
        //console.log('preference ok!')
      }
    })
    .fail(function() {
      $.growl.error({
        title: 'Ocurrio un error al actualizar el carrito',
        message: 'Por favor, intente nuevamente en unos instantes'
      });
  }); 
}


var getTotals = () => {
  var payment_method = carrito_config.payment_method
  var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
  var subtotal = 0
  carrito_items.map((e) => {
    var price = e.price
    //console.log(price)
    subtotal+= parseFloat(price)
  })

  $('.subtotal_price').text(formatNumber(subtotal))
  var free_shipping = subtotal >= shipping_price
  if(free_shipping) {
    $('.paid-shipping-block').addClass('hidden')
    $('.free-shipping-block').removeClass('hidden')
  } else {
    if (carrito.shipping_price) {
      subtotal+= carrito.shipping_price
    }
    $('.free-shipping-block').addClass('hidden')
    $('.paid-shipping-block').removeClass('hidden')
  }
  carrito.freeShipping = free_shipping
  //console.log('free_shipping',free_shipping)
  //console.log(carrito)
  if(carrito.coupon_bonus){
    //console.log('coupon_bonus',carrito.coupon_bonus)
    subtotal-= carrito.coupon_bonus
  }
  if(subtotal < 1) {
    subtotal = 1
  }
  $('.total_price').text(formatNumber(subtotal))
  localStorage.setItem('carrito', JSON.stringify(carrito))  
  return subtotal
}


var select_radio = (name, value) => {
  const e = $(`input[name=${name}][value=${value}]`)
  e.prop("checked",true)
  $(`.${name} .option-rounded`).removeClass('is-selected')
  e.parent().addClass('is-selected')
  //console.log('save(1)')
  //save_preference({ [name]: value })
}


$(function () {
  /*$('#regalo').on('click', (e) => {
    if($(e.target).is(':checked')) {
      onErrorAlert('<i class="fa fa-gift"></i> Es para regalo', 'Prepararemos tu pedido con cuidado para que sea una entrega especial')
    }
  })*/
})



