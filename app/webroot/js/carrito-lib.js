
function addToCart(data) {
  $.post('/carrito/add', $.param(data))
    .success(function(res) {
      console.log('res', res)
      if (res.success) {
        window.dataLayer = window.dataLayer || []
        fbq('track', 'AddToCart')
        /* @Analytics: addToCart */
        gtag('event', 'add_to_cart', {
          "items": [
            {
              "id": data.id,
              "name": $('.product').text(),
              // "list_name": "Search Results",
              // "brand": "Google",
              // "category": "Apparel/T-Shirts",
              "variant": data.alias,
              "list_position": 1,
              "quantity": data.count,
              "price": $('.price').text()
            }
          ]
        })

        /*$.growl.error({
          title: 'Agregado al carrito',
          message: 'Podés seguir agregando más productos o finalizar esta compra en la sección carrito'
        });*/

        var reload = function() {
          window.location.href = '/carrito'
        };

        setTimeout(reload, 1000);
        
        $('.growl-close').click(reload);

        dataLayer.push({
          'event': 'addToCart',
          'ecommerce': {
            'currencyCode': 'ARS',
            'add': {         
              'products': [{
                'name': $('.product').text(),
                'id': data.id,
                'price': $('.price').text(),
                'brand': 'Google',
                'category': 'Apparel',
                'variant': data.alias,
                'quantity': 1
               }]
            }
          },
          'eventCallback': function() {
            $.growl.notice({
              title: '(1)Producto agregado al carrito',
              message: 'Podés seguir agregando más productos o ir a la sección Pagar'
            });
            var reload = function() {
              window.location.href = '/carrito'
            };
            setTimeout(reload, 3000);
            $('.growl-close').click(reload);
          }
        })
      } else {
        $.growl.error({
          title: 'Ocurrió un error al agregar el producto al carrito',
          message: 'Por favor, intentá nuevamente en unos instantes'
        });
      }
    })
    .fail(function() {
      $.growl.error({
        title: 'Ocurrio un error al agregar el producto al carrito',
        message: 'Por favor, intente nuevamente'
      });
    }); 
}

var askremoveCart = (e) => {
  const item = $(e).parents('.carrito-data').data('json')
  let userInput = confirm(`Deseas eliminar ${item.name} del carrito?`);
  if(userInput){
    $.get(`/carrito/remove/${item.id}`).then((res) => {
      /* @Analytics: removeFromCart */
      fbq('track', 'RemoveFromCart')
      gtag('event', 'remove_from_cart', {
        "items": [
          {
            "id": item.id,
            "name": item.article,
            // "list_name": "Results",
            "brand": item.name,
            // "category": "Apparel/T-Shirts",
            "variant": item.alias,
            "list_position": 1,
            "quantity": 1,
            "price": item.discount
          }
        ]
      })
      console.log('refersh')
      window.location.href = window.location.href
    })
  }
}

var removeCart = (e) => {
  if(!removeElement) return
  const block = $(removeElement).parent()
  const json = $(block).find('.carrito-data').data('json')
  block.addClass('flash infinite')
  let item = JSON.parse(JSON.stringify(json))
  $('#carrito-remove-btn').button('loading')
  $.get(`/carrito/remove/${item.id}`).then((res) => {
    /* @Analytics: removeFromCart */
    fbq('track', 'RemoveFromCart')
    gtag('event', 'remove_from_cart', {
      "items": [
        {
          "id": item.id,
          "name": item.article,
          // "list_name": "Results",
          "brand": item.name,
          // "category": "Apparel/T-Shirts",
          "variant": item.alias,
          "list_position": 1,
          "quantity": 1,
          "price": item.discount
        }
      ]
    })

    block.removeClass('flash infinite')
    block.addClass('fadeOut')
    setTimeout(() => {
      $('#carrito-remove-btn').button('reset')
      location.href = '/carrito'
      //block.remove()
    }, 500)
  })
}

var updateCart = (carrito) => {
  console.log('updateCart', carrito)
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
      if (res.success) {
        var data = res.data
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

