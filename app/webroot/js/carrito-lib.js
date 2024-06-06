var updateCart = (carrito) => {
  if(!carrito) {
    carrito = JSON.parse(localStorage.getItem('carrito')) || {}
  }
  Object.keys(carrito).forEach(e => {
    const h = $('#checkoutform').find(`input[name='${e}']`)
    if (h.length && carrito[e]) {
      h.val(carrito[e])
    }
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
  $.post('/carrito/preference', $.param(settings))
    .success(function(res) {
      var response = JSON.parse(res)
      if (response.success) {
        var data = response.data
        if(data){
          carrito_items = data
        }
        getTotals()
      }
    })
    .fail(function() {
      $.growl.error({
        title: 'Ocurrió un error al actualizar el carrito',
        message: 'Por favor, intente nuevamente en unos instantes'
      });
  }); 
}

var getItems = () => {
  var subtotal = 0
  if(carrito_items){
    carrito_items.map((e) => {
      subtotal+= parseFloat(e.price)
    })
  }
  return subtotal
}

var getTotals = () => {
  //console.log('getTotals')
  var payment_method = carrito_config.payment_method
  var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
  var subtotal = getItems()
  $('.subtotal_price').text(formatNumber(subtotal))
  if(carrito.freeShipping) {
    $('.paid-shipping-block').addClass('hidden')
    $('.free-shipping-block').removeClass('hidden')
  } else {
    if(carrito.shipping_price) {
      subtotal+= carrito.shipping_price
    }
    $('.free-shipping-block').addClass('hidden')
    $('.paid-shipping-block').removeClass('hidden')
  }
  if(window.coupon_bonus){ 
    subtotal-= window.coupon_bonus
  }
  if(bank.enable && bank.discount && payment_method == 'bank') {
    subtotal-= subtotal * (parseFloat(bank.discount) / 100)
  }
  if(subtotal < 1) {
    subtotal = 1
  }
  //console.log('total_price(1)', subtotal)
  $('.calc_total').text("$ " + formatNumber(subtotal))
  localStorage.setItem('carrito', JSON.stringify(carrito))  
  return subtotal
}


var select_radio = (name, value) => {
  const e = $(`input[name=${name}][value=${value}]`)
  e.prop("checked",true)
  $(`.${name} .option-rounded`).removeClass('is-selected')
  e.parent().addClass('is-selected')
}

