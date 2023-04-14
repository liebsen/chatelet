var last_selected = ''
var calculateTotal = (settings) => {
	var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
	var subtotal = carrito.subtotal_price
	var total = subtotal
	if (!carrito.freeShipping && carrito.shipping_price) {
		total+= carrito.shipping_price
	}
	if (carrito.coupon_bonus) {
		total-= carrito.coupon_bonus
	}
	if (settings) { 
		if(settings.bank_bonus) {
			total-= settings.bank_bonus
		}
		if(settings.interest) {
			total*= (Number(settings.interest) / 100) + 1
		}
	}
	$('.total_price').text(formatNumber(total))

  //console.log('subtotal',subtotal)
  //console.log('total',total)
  //console.log('bank_bonus',bank_bonus)
}
var select_dues = (e) => {
	var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
	var selected = $(e).find(':checked').val()
	if(!selected) {
		return false
	}	
	$('#mercadopago').click()
	var interest = $(e).data('interest')

  calculateTotal({interest: interest})
  onSuccessAlert(`${selected} cuotas`, '✓ Cantidad de cuotas seleccionado');
  localStorage.setItem('pd', selected)
	$('.payment-dues .option-rounded').removeClass('is-selected')
	$(e).addClass('is-selected')
}

var select_payment = (e) => {
	var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
	var subtotal = carrito.subtotal_price

	var selected = $(e).find(':checked').val()
	var bank_bonus = 0
	if(!selected) {
		return false
	}
	last_selected = selected	
	if (selected === 'bank' && bank.enable && bank.discount_enable && bank.discount) {
		bank_bonus = subtotal * (parseFloat(bank.discount) / 100)
		$('.bank_bonus').text(formatNumber(bank_bonus))
		$('.bank-block').removeClass('hide')
		$('.bank-block').addClass('animated fadeIn')
	} else {
		$('.bank-block').addClass('hide')
	}
  calculateTotal({ bank_bonus: bank_bonus})
  onSuccessAlert((selected === 'bank' ? 'CBU/Alias' : 'Mercadopago'), '✓ Método de pago seleccionado');
  localStorage.setItem('pm', selected)
	$('.payment-method .option-rounded').removeClass('is-selected')
	$(e).addClass('is-selected')
}

$(function(){
	$(`.cargo-${carrito.cargo}`).removeClass('hide')
	$(`.cargo-${carrito.cargo}`).addClass('animated fadeIn')
	$('#regalo').prop('checked', carrito.regalo)

	Object.keys(carrito).forEach(e => {
		const h = $('#checkoutform').find(`input[name='${e}']`)
		//console.log('?',e)
		if (h.length && carrito[e]) {
			console.log(e,carrito[e])
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

	if(lastpm) {
		setTimeout(() => {
			$('#'+lastpm).click()
		}, 100)
		// $('input[name=payment_method]').val(lastpm)
	}
	if (carrito.cargo === 'takeaway') {
		$('.cargo-takeaway').removeClass('hide')
		$('.cargo-takeaway').addClass('animated fadeIn')
	}

	if (carrito.cargo === 'shipment') {
		var price = ''
		if (carrito.freeShipping) {
			price = '<span class="text-success">Gratis</span>'
		} else {
			price = `$${formatNumber(carrito.shipping_price)}`
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

	$('#checkoutform').submit(form => {
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