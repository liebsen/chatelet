var getItems = (payment_method) => {
  var subtotal = 0
  payment_method = payment_method || cart_totals.payment_method
  console.log('getItems(payment_method)',payment_method)
  if(cart_items){
    cart_items.map((e) => {
      if(payment_method == 'bank' && e.bank_discount) {
        const price = Math.ceil(Math.round(e.old_price * (1 - parseFloat(e.bank_discount) / 100)))
        console.log('price(1)', price)
        subtotal+= price
      } else {
        console.log('price(2)', e.old_price)
        subtotal+= parseFloat(e.old_price)
      }
    })
  }
  return subtotal
}

var getTotals = () => {
  var payment_method = cart_totals.payment_method || 'bank'
  var subtotal = getItems(payment_method)

  $('.subtotal_price').text("$ " + formatNumber(subtotal))
  
  if(cart_totals.free_shipping) {
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

  if(
    payment_method == 'bank' && 
    settings.bank_enable && 
    settings.bank_discount_enable && 
    settings.bank_discount
  ) {
    subtotal-= subtotal * (parseFloat(settings.bank_discount) / 100)
  }

  if(subtotal < 1) {
    subtotal = 1
  }

  // console.log('getTotals(2)', subtotal)
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

  $(document).on('click', '.giftchecks',function(e) {
    var gifts = localStorage.gifts ? JSON.parse(localStorage.gifts) : []
    var target_id = parseInt($(e.target).attr('data-id'))
    
    gifts = gifts.filter((id) => id != target_id)

    if($(e.target).is(':checked')){
      gifts.push(target_id)
    }

    localStorage.setItem('gifts', JSON.stringify(gifts))  
  })

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
    
    addToCart(data).then(() => {
      location.href = location.href
    })
  })
})
