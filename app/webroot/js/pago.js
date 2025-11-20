var dues_selected = ''
// var cart = JSON.parse(localStorage.getItem('cart')) || {}

//var select_dues = (e,item) => {
$('.dues-select-option').click((e) => {
	const target = $(e.target).hasClass('dues-select-option') ? 
		$(e.target) : 
		$(e.target).parents('.dues-select-option')
	e.preventDefault()
	e.stopPropagation()
	var json = target.data('json')
	// var cart = JSON.parse(localStorage.getItem('cart')) || {}
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
	// save_preference([
		// { 'payment_method': 'mercadopago'},
		// { 'payment_dues': dues_selected }
	// ])
	$('input[name="payment_dues"]').val(dues_selected)
	$('.dues-select-option').removeClass('selected secondary')
	$('.dues-select-option').addClass('secondary')
	target.addClass('selected')
	prevent_default = false
})

$(function(){
	localStorage.setItem('continue_shopping_url', window.location.pathname)
	const payment_method = localStorage.getItem('payment_method') || 'mercadopago'

	$('.select-payment-option').click(e => {
		const target = $(e.target).hasClass('select-payment-option') ? 
			$(e.target) : 
			$(e.target).parents('.select-payment-option')

		// e.preventDefault()
		// e.stopPropagation()
		// var cart = JSON.parse(localStorage.getItem('cart')) || {}
		var selected = target.find('input').val()

		const payment_dues = document.querySelector('.select-payment-option')

		// console.log('select-payment-option', selected)
		// console.log('payment_dues', payment_dues)

		$('.dues-block').hide()
		// cart_totals.payment_method = selected
		target.find('input').prop('checked', true)
		var bank_bonus = 0

		if(!selected) {
			return false
		}

		var totals = getTotals()
		if(payment_dues) {
			// console.log('a(1)')
			switch(selected){
				case 'bank':
					// console.log('a(2)')
					if(payment_dues.classList.contains('scaleIn')){
						payment_dues.classList.remove('scaleIn')
						payment_dues.classList.add('scaleOut')
						setTimeout(() => {
							payment_dues.classList.add('hide-element')
						}, 500)
					}
					document.querySelectorAll('.select-payment-option .bronco-select').forEach((e,i) => {
						if(i) {
							e.classList.add('hide')
						}
					})
				break;

				case 'mercadopago':
					// console.log('a(3)')
				if(payment_dues.classList.contains('scaleOut')){
					payment_dues.classList.remove('scaleOut', 'hide-element')
					payment_dues.classList.add('scaleIn')
				}
				$('.dues-block').show()
				document.querySelectorAll('.select-payment-option .bronco-select').forEach((e) => e.classList.remove('hide'))

				break;
			}
		}

		if (
			selected === 'bank' && 
			settings.bank_enable && 
			settings.bank_discount_enable && 
			settings.bank_discount
		) {
			bank_bonus = totals.total * (parseFloat(settings.bank_discount) / 100)
			$('.bank_bonus').text(formatNumber(bank_bonus))
			$('.bank-block').removeClass('hide')
			$('.bank-block').addClass('animated fadeIn')
			select_radio('payment_dues', 1)
			$('.payment_dues label').not(':first-child').addClass('hide')
		} else {
			$('.payment_dues label').removeClass('hide')
			$('.bank-block').addClass('hide')
		}
		localStorage.setItem('payment_method', selected)
	  // onSuccessAlert(`Como querés pagar`,'Seleccionaste pagar con ' + (selected === 'bank' ? 'Transferencia' : 'Mercado Pago'));
	  // save_preference({payment_method: selected})

		$('.payment_method .bronco-select').removeClass('is-selected is-secondary')
		$('.payment_method .bronco-select').addClass('is-secondary')
		target.addClass('is-selected')
	})

	$('#submitcheckoutbutton').click(e => {
		fbq('track', 'AddPaymentInfo', { value: cart_totals.grand_total, currency: 'ARS' });
		if(dues_selected && dues_selected > 1){ // show legend
			$('#dues_message').addClass('show')
			$('.dues-message-dues').text(dues_selected)
		} else {
			$('#submitform').click()
		}
	})

	/*$('#checkoutform').submit(form => {
		// mostrar leyenda solicitando la elección correcta de cuotas.
		// Asegurate de seleccionar {cuotas} cuotas.
		const submit = $('.checkout-btn')
		//var cart = JSON.parse(localStorage.getItem('cart')) || {}
		submit.prop('disabled', true)
		submit.addClass('disabled')
		submit.text('Por favor espere...')
		$('.checkoutform-container').removeClass('hide')

		// localStorage.removeItem('cart')
		localStorage.removeItem('continue_shopping_url')
		//localStorage.setItem('cart', JSON.stringify(cart))
		//localStorage.removeItem('cart')
	})*/
});