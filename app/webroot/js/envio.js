selectShipping = function (e, shipping, cost) {
	if (cost <= 0) {
		return setTimeout( `onErrorAlert('No disponible', 'El servicio de logística ${shipping.toUpperCase()} no está disponible en este momento, intente en unos instantes.')` , 200)
	}

	var total = 0
	var coupon_benefits = cart_totals.coupon_benefits || 0
	var total_products = cart_totals.total_products || 0
	var grand_total = cart_totals.grand_total || 0
	const shipping_price = parseInt(settings.shipping_price_min)

	$('.shipping-options li').removeClass('selected secondary')
	$('.takeaway-options li').removeClass('selected secondary')
	$('.shipping-options li').addClass('secondary')
	$(e).addClass('selected')
	$('.delivery-cost').addClass('hidden')
	$('.shipping-cargo').text(shipping.toUpperCase())	

	if (grand_total < shipping_price) {
		total =  total_products - coupon_benefits + cost
		$('#subtotal_envio').val(cost)
		$('.products-total').removeClass('hidden')
		$('.delivery-cost').removeClass('hidden')
		$('.delivery-cost').addClass('fadeIn')
		$('.cost_delivery').text( formatNumber(cost))
	}

	$('.cost_total').text('$ ' + formatNumber(total))

	total = formatNumber(total)
	let info = $(e).data('info')

	fxTotal(total)

	var cp_input = $('.input-cp').val().trim()
	var cp = parseInt(cp_input)

	$('.paying-with').delay(1000).fadeIn()
	$('.checkout-continue').fadeIn()
	$('input[name="shipping"]').val(shipping)
	$('input[name="cargo"]').val('shipment')
	$('input[name="postal_address"]').val(cp)
	localStorage.setItem('cargo', 'delivery')
	localStorage.setItem('delivery_select', shipping)
}

selectStore = function(e) {
	$('.takeaway-options li').removeClass('selected secondary')
	$('.shipping-options li').removeClass('selected secondary')
	$('.takeaway-options li').addClass('secondary')
	$('.free-shipping').addClass('hidden')
	$('#cost_container').html('')
	$(e).addClass('selected')
  $('.delivery-cost').addClass('hidden')
  var grand_total = cart_totals.grand_total 
  format_total = formatNumber(grand_total)
  fxTotal(format_total)
  	
  const storeProps = ['store', 'store-address', 'store-lat', 'store-lng']
  let store = {}
  storeProps.forEach((i,j) => {
  	store[i] = $(e).attr(i)
  })

  localStorage.setItem('cargo', 'takeaway')
  localStorage.setItem('takeaway_store', JSON.stringify(store))

  var cart_takeaway_text = $('.cart_takeaway_text').text()
  const suc = e.textContent.split(' ')[0]
  initMap(e)

  $('a[href="#retiro"]').click()
  $('.checkout-continue').fadeIn()
	$('input[name="shipping"]').val("")
  $('input[name="cargo"]').val('takeaway')
  $('input[name="store"]').val($(e).attr('store'))
  $('input[name="store_address"]').val($(e).attr('store-address'))
  $('input[name="postal_address"]').val("")
}

$(document).ready(function() {
	localStorage.setItem('continue_shopping_url', window.location.pathname)

	/* metrics start */
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

	/* metrics end */
	
	$('.btn-calculate-shipping').click(e => {
		$('.btn-calculate-shipping').prop('disabled', true)
		$('.btn-calculate-shipping').button('loading')

		var url = $(this).data('url')
		//var total_orig = $('#subtotal_compra').val()
		var cp_input = $('.input-cp').val().trim()
		var cp = parseInt(cp_input)
		var cost = 0
		var coupon = $('.coupon_bonus') ? 
			$('.coupon_bonus').text().split('.').join('').split(',').join('.') : 
			cart.coupon_bonus || 0
		var subtotal = parseFloat($('#subtotal_compra').val()) || cart.subtotal_price

		//console.log(coupon, subtotal)
		document.querySelector('.shipping-block').classList.add('hidden')

		$('.input-cp').removeClass('ok');				
		$('.delivery-cost').addClass('hidden')
		// $('.takeaway-options li').removeClass('selected')
		if(cp_input == '' || cp < 1000 || cp > 9999) {
			onErrorAlert('Código postal inválido', `Por favor ingresá un código postal válido`);
			return false
		}

		$('#free_delivery').text('');
		$.getJSON( '/checkout/deliveryCost/'+cp , function(json, textStatus) {
			$('.btn-calculate-shipping').button('reset')
			$('.btn-calculate-shipping').prop('disabled', false)
			window.freeShipping = json.freeShipping
			if( json.rates.length ){
				var rates = `<ul class="generic-select shipping-options">`
				json.rates.forEach(rate => {
					if (!isNaN(rate.price)) {
						var price = '<span class="text-success text-bold">Gratis</span>'
						if (!json.freeShipping) {
							price = `<span class="text-uppercase">$ ${parseInt(rate.price)}</span>`
						}
						rates+= `<li shipping="${rate.code}" data-info="${rate.info}" onclick="selectShipping(this, '${rate.code}',${parseInt(rate.price)})"><div class="shipping-logo" style="background-image: url('${rate.image}')">${price}</div></li>`
					}
				})
				rates+= `</ul>`
				document.querySelector('.shipping-block .slot').innerHTML = rates
				localStorage.lastcp = cp	
				setTimeout(() => {
					$('.input-status').removeClass('wrong');
					$('.input-status').addClass('ok');
					// onSuccessAlert(`Como querés recibir tu compra`,'Ingresaste código postal ' + cp, 0, true);
					document.querySelector('.shipping-block').classList.remove('hidden')	
					if (localStorage.cargo === 'delivery' && localStorage.delivery_select) {
						$(`.shipping-options li[shipping="${localStorage.delivery_select}"]`).click()
					} else {
						if (json.rates.length === 1) {
							$(`.shipping-options li:first-child`).click()
						}
					}
				}, 100)
			} else {
				$('.input-status').removeClass('ok');
				$('.input-status').addClass('wrong');
				setTimeout( "onErrorAlert('Sin cobertura en esta zona', 'El código postal es correcto pero no disponemos de servicio de entrega para tu área.')", 200)
			}
			$('.has-checkout-steps').addClass('done')
			$('.input-cp').attr( 'data-valid' , json.rates.length );
			$('.btn-calculate-shipping').button('reset')
		})
		return false
	})

	var takeaway_store = JSON.parse(localStorage.getItem('takeaway_store')) || []

	if (localStorage.getItem('cargo') === 'takeaway' && Object.keys(takeaway_store)?.length && !location.hash.includes('shipment-options.shipping')) {
		setTimeout(() => {
			$('a[href="#retiro"]').click()
			$('.has-checkout-steps').addClass('done')
			// $('label[for="shipment"]').click()
			$(`.takeaway-options li[store="${takeaway_store.store}"]`).click()
		}, 100)
	}

	if (localStorage.getItem('cargo') === 'delivery' && localStorage.getItem('lastcp')) {
		setTimeout(() => {
			$('a[href="#envio"]').click()
			//$('.shipment-block').show()
			$('.input-cp').val(localStorage.getItem('lastcp'))
			$('.btn-calculate-shipping').click()
			$('.has-checkout-steps').addClass('done')
			// const takeaway = $('.takeaway-options li.selected')
			// if(cargo === 'shipment' && !takeaway.length || freeShipping) {
				// $('#calulate_shipping').submit()	
				// onWarningAlert('Calculando envío', `Un segundo por favor, estamos calculando el costo de envío para el código postal ${lastcp}`, 5000, true)
			// } else {
				// onWarningAlert('Envío a domicilio disponible', `Puede solicitar envío a domicilio. Solo debe calcular los costos para el cód. postal ${lastcp} y seleccionar su opción.`, 5000, true)
			// }
		}, 100)
	} else {
		$('.has-checkout-steps').addClass('done')
	}
})