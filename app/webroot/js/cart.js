
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
              title: 'Producto agregado al carrito',
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


var save_preference = (settings) => {
  $.post('/carrito/preference', $.param(settings))
    .success(function(res) {
      if (res.success) {
        var data = res.data
        if(data){
          cart_items = data
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
  if(cart_items){
    cart_items.map((e) => {
      subtotal+= parseFloat(e.price)
    })
  }
  return subtotal
}

var getTotals = () => {
  var payment_method = 
  var subtotal = getItems()

  // var carrito = JSON.parse(localStorage.getItem('cart')) || {}
  $('.subtotal_price').text(formatNumber(subtotal))
  
  if(freeShipping) {
    $('.paid-shipping-block').addClass('hidden')
    $('.free-shipping-block').removeClass('hidden')
  } else {
    if(cart_totals.delivery_cost) {
      subtotal+= cart_totals.delivery_cost
    }
    $('.free-shipping-block').addClass('hidden')
    $('.paid-shipping-block').removeClass('hidden')
  }

  if(cart_totals.coupon_benefits){ 
    subtotal-= cart_totals.coupon_benefits
  }

  if(settings.bank_enable && settings.bank_discount && cart_totals.payment_method == 'bank') {
    subtotal-= subtotal * (parseFloat(settings.bank_discount) / 100)
  }

  if(subtotal < 1) {
    subtotal = 1
  }
  //console.log('total_price(1)', subtotal)
  $('.calc_total').text("$ " + formatNumber(subtotal))
  // localStorage.setItem('cart', JSON.stringify(carrito))  
  return subtotal
}

var select_radio = (name, value) => {
  const e = $(`input[name=${name}][value=${value}]`)
  e.prop("checked",true)
  $(`.${name} .bronco-select`).removeClass('is-selected')
  e.parent().addClass('is-selected')
}


$(document).ready(function() {

  $(document).on('click', '.btn-change-count',function(e) {
    let count = $(this).parent().find('input').first().val()
    var json = $(this).parents('.carrito-data').data('json')
    var item = JSON.parse(JSON.stringify(json))
    
    if($(e.target).hasClass('disable') || count == 0) {
      return false
    }

    if($(this).is(':first-child')) {
      count--
    } else {
      count++
    }

    var data = {
      count: parseInt(count),
      id: item.id,
      color: item.color,
      color_code: item.color_code,
      size: item.size,
      alias: item.alias,
    }
    
    addCart(data)
  })
})
