var last_selected = ''
var dues_selected = ''
var itemData = null
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
			price = '<span class="text-success">Gratis</span>'
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

	if (bank.enable && bank.discount_enable && bank.discount && carrito_config.payment_method !== 'bank') {
		setTimeout(() => {
  		onSuccessAlert('<i class="fa fa-mobile"></i> Pagá con Transferencia', `Y obtené un ${bank.discount}% de descuento en tu compra`);		
  	}, 2000)
	}
}

var getTotals = (payment_method) => {
	var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
	var subtotal = 0
	carrito_items.map((e) => {
		var price = e.price
		if(payment_method === 'mercadopago' && e.mp_price) {
			price = e.mp_price
		}
		else if(payment_method === 'bank' && e.bank_price) {
			price = e.bank_price
		}
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
	//console.log(carrito.freeShipping)
	$('.total_price').text(formatNumber(subtotal))
	localStorage.setItem('carrito', JSON.stringify(carrito))	
	return subtotal
}


var select_radio = (name, value) => {
  const e = $(`input[name=${name}][value=${value}]`)
  e.prop("checked",true)
  $(`.${name} .option-rounded`).removeClass('is-selected')
  e.parent().addClass('is-selected')
  console.log('save(1)')
  //save_preference({ [name]: value })
}

var select_dues = (e,item) => {
	e.preventDefault()
	var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
	dues_selected = $(item).find('input').val()
	$(item).find('input').prop('checked', true) // force since preventdefault

	if(!dues_selected) {
		return false
	}	
	if(!$('#mercadopago').is(':checked') && dues_selected > 1) {
		select_radio('payment_method', 'mercadopago')
	}

	var interest = $(e).data('interest')

  onSuccessAlert(`<i class="fa fa-credit-card"></i> ${dues_selected} cuotas`, '✓ Cantidad de cuotas seleccionado');
  console.log('save(2)')
  save_preference([
  	{'payment_method':'mercadopago'},
  	{'payment_dues':dues_selected}
  ])

	$('.payment_dues .option-rounded').removeClass('is-selected is-secondary')
	$('.payment_dues .option-rounded').addClass('is-secondary')
	$(item).addClass('is-selected')
	prevent_default = false
}

var select_payment = (e,item) => {
	e.preventDefault()
	var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
	var selected = $(item).find('input').val()
	$(item).find('input').prop('checked', true)
	var bank_bonus = 0
	if(!selected) {
		return false
	}
	var subtotal = getTotals(selected)

	last_selected = selected	
	if (selected === 'bank' && bank.enable && bank.discount_enable && bank.discount) {
		bank_bonus = subtotal * (parseFloat(bank.discount) / 100)
		$('.bank_bonus').text(formatNumber(bank_bonus))
		$('.bank-block').removeClass('hide')
		$('.bank-block').addClass('animated fadeIn')
		select_radio('payment_dues', 1)
	} else {
		$('.bank-block').addClass('hide')
	}

  onSuccessAlert('<i class="fa fa-mobile"></i> ' + (selected === 'bank' ? 'Transferencia' : 'Mercadopago'), '✓ Método de pago seleccionado');

  console.log('save(4)')
  save_preference({payment_method: selected})

	$('.payment_method .option-rounded').removeClass('is-selected is-secondary')
	$('.payment_method .option-rounded').addClass('is-secondary')
	$(item).addClass('is-selected')
}

$(function(){
	$(`.cargo-${carrito.cargo}`).removeClass('hide')
	$(`.cargo-${carrito.cargo}`).addClass('animated fadeIn')
	$('#regalo').prop('checked', carrito.regalo)

	updateCart()


	$('#submitcheckoutbutton').click(e => {
		if(dues_selected && dues_selected > 1){ // show legend
			$('#dues_message').addClass('show')
			$('.dues-message-dues').text(dues_selected)
		} else {
			$('#submitform').click()
		}
	})

	$('#checkoutform').submit(form => {
		// mostrar leyenda solicitando la elección correcta de cuotas.
		// Asegurate de seleccionar {cuotas} cuotas.
		const submit = $('.checkout-btn')
		submit.prop('disabled', true)
		submit.addClass('disabled')
		submit.text('Por favor espere...')
		$('.checkoutform-container').removeClass('hide')

		//localStorage.removeItem('carrito')
		fbq('track', 'InitiateCheckout')
		let items = []
		if(carrito_items && carrito_items.length) {
			carrito_items.forEach(e => {
				items.push({
	        'name': e.article,
	        'id': e.id,
	        'price': e.discount,
	        'brand': e.name,
	        'category': e.name,
	        'variant': e.alias,
	        'quantity': 1
				})
			})
			gtag('event', 'begin_checkout', {
			  "items": items,
			  "coupon": ""
			})
		}
	})
});