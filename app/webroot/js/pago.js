var dues_selected = ''
var cart = JSON.parse(localStorage.getItem('cart')) || {}

var updateCart = (cart) => {
	if(!cart) {
		cart = JSON.parse(localStorage.getItem('cart')) || {}
	}

	Object.keys(cart).forEach(e => {
		const h = $('#checkoutform').find(`input[name='${e}']`)
		if (h.length && cart[e]) {
			h.val(cart[e])
		}
		if ($(`.${e}`).length) {
			let value = cart[e]
			if (typeof value === 'number') {
				value = formatNumber(value)	
			}
			$(`.${e}`).html(value)
		}
	})

	if (cart.cargo === 'takeaway') {
		$('.cargo-takeaway').removeClass('hide')
		$('.cargo-takeaway').addClass('animated fadeIn')
	}

	if (cart.cargo === 'shipment') {
		var price = ''
		if (cart.freeShipping) {
			price = '<span class="text-success text-bold">Gratis</span>'
		} else {
			price = `$ ${formatNumber(cart.shipping_price)}`
		}
		$('.shipping_price').html(price)
		$('.shipping-block').removeClass('hide')
		$('.shipping-block').addClass('animated fadeIn')
	}

	if(!cart.coupon) {
		$('.coupon-actions-block').removeClass('hide')
		$('.coupon-actions-block').addClass('animated fadeIn')
	} else {
		$('.coupon-block').removeClass('hide')
		$('.coupon-block').addClass('animated fadeIn')
	}

	if (bank.enable && bank.discount_enable && bank.discount && cart_totals.payment_method !== 'bank') {
		setTimeout(() => {
  		onWarningAlert('Pagá con Transferencia', `Y obtené un ${bank.discount}% de descuento en tu compra`);		
  	}, 2000)
	}
}

//var select_dues = (e,item) => {
$('.dues-select-option').click((e) => {
	const target = $(e.target).hasClass('dues-select-option') ? 
		$(e.target) : 
		$(e.target).parents('.dues-select-option')
	e.preventDefault()
	e.stopPropagation()
	var json = target.data('json')
	var cart = JSON.parse(localStorage.getItem('cart')) || {}
	dues_selected = json.dues
	//$(item).find('input').prop('checked', true) // force since preventdefault

	if(!dues_selected) {
		return false
	}	
	if(!$('#mercadopago').is(':checked') && dues_selected > 1) {
		select_radio('payment_method', 'mercadopago')
	}

	var interest = json.interest

	// onSuccessAlert(`Como querés pagar`,`Seleccionaste ${dues_selected} cuota${dues_selected > 1 ? 's' : ''}`);
	save_preference([
		// { 'payment_method': 'mercadopago'},
		{ 'payment_dues': dues_selected }
	])

	$('.dues-select-option').removeClass('selected secondary')
	$('.dues-select-option').addClass('secondary')
	target.addClass('selected')
	prevent_default = false
})


$(function(){

	localStorage.setItem('continue_shopping_url', window.location.pathname)

	$(`.cargo-${cart.cargo}`).removeClass('hide')
	$(`.cargo-${cart.cargo}`).addClass('animated fadeIn')

	updateCart()

	$('.select-payment-option').click(e => {
		const target = $(e.target).hasClass('select-payment-option') ? 
			$(e.target) : 
			$(e.target).parents('.select-payment-option')
		// e.preventDefault()
		// e.stopPropagation()
		var cart = JSON.parse(localStorage.getItem('cart')) || {}
		var selected = target.find('input').val()
		const payment_dues = document.querySelector('.payment-dues')
		$('.dues-block').hide()
		cart_totals.payment_method = selected
		target.find('input').prop('checked', true)
		var bank_bonus = 0

		if(!selected) {
			return false
		}

		var totals = getTotals()
		if(payment_dues) {
			switch(selected){
				case 'bank':
					if(payment_dues.classList.contains('scaleIn')){
						payment_dues.classList.remove('scaleIn')
						payment_dues.classList.add('scaleOut')
						setTimeout(() => {
							payment_dues.classList.add('hide-element')
						}, 500)
					}
					document.querySelectorAll('.payment-dues .bronco-select').forEach((e,i) => {
						if(i) {
							e.classList.add('hide')
						}
					})
				break;

				case 'mercadopago':

				if(payment_dues.classList.contains('scaleOut')){
					payment_dues.classList.remove('scaleOut', 'hide-element')
					payment_dues.classList.add('scaleIn')
				}
				$('.dues-block').show()
				document.querySelectorAll('.payment-dues .bronco-select').forEach((e) => e.classList.remove('hide'))

				break;
			}
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

	  // onSuccessAlert(`Como querés pagar`,'Seleccionaste pagar con ' + (selected === 'bank' ? 'Transferencia' : 'Mercado Pago'));

	  save_preference({payment_method: selected})

		$('.payment_method .bronco-select').removeClass('is-selected is-secondary')
		$('.payment_method .bronco-select').addClass('is-secondary')
		target.addClass('is-selected')
	})

	$('#submitcheckoutbutton').click(e => {
		fbq('track', 'AddPaymentInfo', { value: cart.total_price, currency: 'ARS' });
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
		//var cart = JSON.parse(localStorage.getItem('cart')) || {}
		submit.prop('disabled', true)
		submit.addClass('disabled')
		submit.text('Por favor espere...')
		$('.checkoutform-container').removeClass('hide')

		localStorage.removeItem('cart')
		localStorage.removeItem('continue_shopping_url')
		//localStorage.setItem('cart', JSON.stringify(cart))

		//localStorage.removeItem('cart')
		fbq('track', 'InitiateCheckout')
		let items = []
		if(cart_items && cart_items.length) {
			cart_items.forEach(e => {
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