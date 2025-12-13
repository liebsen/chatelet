var dues_selected = ''
var requesting_coupon = false

function updateTotals(res) {
  total = parseFloat(res.cart_totals.grand_total)      
  discounted_formatted = formatNumber(res.cart_totals.coupon_benefits)

  $('.coupon_bonus').text( "$ " + formatNumber(discounted_formatted))
  $('.subtotal_price').text( "$ " + formatNumber(res.cart_totals.total_products))

  fxTotal(total)

  $(res.cart).each(function(i,e) {
  	$('.price-'+e.id).text("$ " + formatNumber(parseFloat(e.price)))
  })
}

$(function(){
	const payment_method = localStorage.payment_method && localStorage.payment_method != 'undefined' ? 
		localStorage.payment_method :
		'bank'

	localStorage.continue_shopping_url = window.location.pathname

	/* click handlers */

	$('#submitcheckoutbutton').click(e => {
		fbq('track', 'AddPaymentInfo', { value: cart_totals.grand_total, currency: 'ARS' });
		if(dues_selected && dues_selected > 1){ // show legend
			$('#dues_message').addClass('show')
			$('.dues-message-dues').text(dues_selected)
		} else {
			$('#submitform').click()
		}
	})

	$('.dues-select-option').click((e) => {
		const target = $(e.target).hasClass('dues-select-option') ? 
			$(e.target) : 
			$(e.target).parents('.dues-select-option')

		e.preventDefault()
		e.stopPropagation()

		var json = target.data('json')
		dues_selected = json.dues

		if(!dues_selected) {
			return false
		}

		if(!$('#mercadopago').is(':checked') && dues_selected > 1) {
			select_radio('payment_method', 'mercadopago')
		}

		$('input[name="payment_dues"]').val(dues_selected)
		$('.dues-select-option').removeClass('selected secondary')
		$('.dues-select-option').addClass('secondary')

		target.addClass('selected')
	})

	$('.select-payment-option').click((e) => {
		const target = $(e.target).hasClass('select-payment-option') ? 
			$(e.target) : 
			$(e.target).parents('.select-payment-option')

		var total = 0
		var selected = target.find('input').val()
		const payment_dues = document.querySelector('.select-payment-option')

		cart_totals.payment_method = selected

		$('.dues-block').hide()

		target.find('input').prop('checked', true)
		var bank_bonus = 0

		if(!selected || requesting_coupon) {
			return false
		}

		requesting_coupon = true

	  $.post('/checkout/payment_method', { 
	  	coupon: cart_totals.coupon,
	  	payment_method: selected,
	  }, function(res, textStatus) {
	    if( res.status == 'success' ) {
	    	updateTotals(res)
				total = getTotals()	
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
							document.querySelectorAll('.select-payment-option .bronco-select').forEach((e,i) => {
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

							$('.dues-select-option').each(function(){
								const data = $(this).data('json')
								$(this).find('.due-option-price').text("$ " + formatNumber(total / data.dues))
							})
							
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
					bank_bonus = total * (parseFloat(settings.bank_discount) / 100)
					$('.bank_bonus').text(formatNumber(bank_bonus))
					$('.bank-block').removeClass('hide')
					$('.bank-block').addClass('animated fadeIn')
					select_radio('payment_dues', 1)
					$('.payment_dues label').not(':first-child').addClass('hide')
				} else {
					$('.payment_dues label').removeClass('hide')
					$('.bank-block').addClass('hide')
				}
	      //cart_totals.total_products = parseFloat(total.toFixed(2))
	    }
	    requesting_coupon = false
	  })
		
		localStorage.payment_method = selected

		$('.payment_method .bronco-select').removeClass('is-selected is-secondary')
		$('.payment_method .bronco-select').addClass('is-secondary')
		target.addClass('is-selected')
	})
})