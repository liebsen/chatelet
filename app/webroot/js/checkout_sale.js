var dues_selected = ''
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

	if (bank.enable && bank.discount_enable && bank.discount && carrito_config.payment_method !== 'bank') {
		setTimeout(() => {
  		onWarningAlert('Pagá con Transferencia', `Y obtené un ${bank.discount}% de descuento en tu compra`);		
  	}, 2000)
	}
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

  onSuccessAlert(`${dues_selected} cuotas`, '✓ Cantidad de cuotas seleccionado');
  save_preference([
  	{'payment_method': 'mercadopago'},
  	{'payment_dues': dues_selected}
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
	carrito_config.payment_method = selected
	$(item).find('input').prop('checked', true)
	var bank_bonus = 0
	if(!selected) {
		return false
	}
	var totals = getTotals()

	switch(selected){
		case 'bank':
		if(document.querySelector('.payment-dues').classList.contains('scaleIn')){
			document.querySelector('.payment-dues').classList.remove('scaleIn')
			document.querySelector('.payment-dues').classList.add('scaleOut')
		}
		document.querySelectorAll('.payment-dues .option-rounded').forEach((e,i) => {
			console.log(e,i)
			if(i) {
				e.classList.add('hide')
			}
		})
		break;

		case 'mercadopago':

		if(document.querySelector('.payment-dues').classList.contains('scaleOut')){
			document.querySelector('.payment-dues').classList.remove('scaleOut')
			document.querySelector('.payment-dues').classList.add('scaleIn')
		}

		document.querySelectorAll('.payment-dues .option-rounded').forEach((e) => e.classList.remove('hide'))

		break;
	}

	if (selected === 'bank' && bank.enable && bank.discount_enable && bank.discount) {
		bank_bonus = totals.total * (parseFloat(bank.discount) / 100)
		$('.bank_bonus').text(formatNumber(bank_bonus))
		$('.bank-block').removeClass('hide')
		$('.bank-block').addClass('animated fadeIn')
		select_radio('payment_dues', 1)
		$('.payment_dues label').not(':first-child').addClass('hide')
	} else {
		$('.payment_dues label').removeClass('hide')
		$('.bank-block').addClass('hide')
	}

  onSuccessAlert('' + (selected === 'bank' ? 'Transferencia' : 'Mercado Pago'), '✓ Método de pago seleccionado');

  save_preference({payment_method: selected})

	$('.payment_method .option-rounded').removeClass('is-selected is-secondary')
	$('.payment_method .option-rounded').addClass('is-secondary')
	$(item).addClass('is-selected')
}

$(function(){
	$(`.cargo-${carrito.cargo}`).removeClass('hide')
	$(`.cargo-${carrito.cargo}`).addClass('animated fadeIn')

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
		//var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
		submit.prop('disabled', true)
		submit.addClass('disabled')
		submit.text('Por favor espere...')
		$('.checkoutform-container').removeClass('hide')

		localStorage.removeItem('carrito')
		//localStorage.setItem('carrito', JSON.stringify(carrito))

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