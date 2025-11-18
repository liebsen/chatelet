var cargo = ''

selectShipping = function (e, shipping, cost) {
	if (cost <= 0) {
		return setTimeout( `onErrorAlert('No disponible', 'El servicio de logística ${shipping.toUpperCase()} no está disponible en este momento, intente en unos instantes.')` , 200)
	}

	// var cart = JSON.parse(localStorage.getItem('cart')) || {}
	var coupon = cart_totals.coupon_benefits || 0
	var subtotal = cart_totals.total_products || 0
	//var subtotal = cart.subtotal_price
	cargo = 'shipment'
	const shipping_price = parseInt(settings.shipping_price_min)
	$('.shipping-options li').removeClass('selected secondary')
	$('.takeaway-options li').removeClass('selected secondary')
	$('.shipping-options li').addClass('secondary')
	$(e).addClass('selected')
	$('.delivery-cost').addClass('hidden')
	$('.shipping-cargo').text(shipping.toUpperCase())	
	var price = subtotal - coupon
	if (price < shipping_price) {
		price+= cost
		$('#subtotal_envio').val(cost)
		$('.delivery-cost').removeClass('hidden')
		$('.delivery-cost').addClass('fadeIn')
		$('.cost_delivery').text( formatNumber(cost))
	}

	console.log({subtotal, coupon, price, cost, shipping_price})

	$('.cost_total').text('$ ' + formatNumber(price))

  /* var cart = JSON.parse(localStorage.getItem('cart')) || {}
	cart.shipping = shipping
  cart.cargo = cargo
  cart.shipping_price = cost
  cart.total_price = price
  cart.subtotal_price = subtotal
  localStorage.setItem('cart', JSON.stringify(cart)) */

  //console.log('price',price)
	let total = formatNumber(price)
	let info = $(e).data('info')
	fxTotal(total)
	$('.paying-with').delay(1000).fadeIn()
	$('.checkout-continue').fadeIn()

	localStorage.setItem('shipping_method', 'delivery')
	localStorage.setItem('delivery_select', shipping)
	// onErrorAlert(`Como querés recibir tu compra`, `Te lo llevamos por ${shipping.toUpperCase()}`, 0, true);
}

selectStore = function(e) {
	var cart = JSON.parse(localStorage.getItem('cart')) || {}
	var total_orig = parseFloat($('#subtotal_compra').val())
	//console.log('total_orig',total_orig)
	//console.log(document.querySelector('.coupon_bonus').innerHTML)
	var coupon = Number(cart.coupon_bonus || 0)
	$('.takeaway-options li').removeClass('selected secondary')
	$('.shipping-options li').removeClass('selected secondary')
	$('.takeaway-options li').addClass('secondary')
	$('.free-shipping').addClass('hidden')
	// $('.input-status').removeClass('ok')
	// $('.input-cp').val('')
	$('#cost_container').html('')
	$(e).addClass('selected')
  $('.delivery-cost').addClass('hidden')
  var price = parseFloat((total_orig - coupon).toFixed(2))
  // $('.cost_total').text('$ ' + formatNumber(total_orig))
  // $('.calc_total').text('$ ' + formatNumber(total_orig))
  format_total = formatNumber(price)
  // fxTotal(format_total)
  /* cart.cargo = 'takeaway'
  //console.log('total_price(2)', price)
  cart.total_price = price
  cart.shipping_price = 0
  cart.subtotal_price = total_orig
  cart.store = $(e).attr('store')
  cart.store_lat = $(e).attr('store-lat')
  cart.store_lng = $(e).attr('store-lng')
  cart.store_address = $(e).attr('store-address')
  localStorage.setItem('cart', JSON.stringify(cart)) */
  	
  const storeProps = ['store', 'store-address', 'store-lat', 'store-lng']
  let store = {}
  storeProps.forEach((i,j) => {
  	store[i] = $(e).attr(i)
  })

  localStorage.setItem('shipping_method', 'takeaway')
  localStorage.setItem('takeaway_selected', JSON.stringify(store))

  var cart_takeaway_text = $('.cart_takeaway_text').text()
  const suc = e.textContent.split(' ')[0]
  initMap(cart)
  // onSuccessAlert(`Como querés recibir tu compra`, `Seleccionaste la opción retirar en sucursal ${suc.replace(',','')}. Puedes pasar a retirar tu producto por nuestra sucursal en ${e.textContent}. <br><br> ${cart_takeaway_text}`);
  console.log('click(7)')
  $('a[href="#retiro"]').click()
  $('.checkout-continue').fadeIn()
	cargo = 'takeaway'
}

$(document).ready(function() {
	localStorage.setItem('continue_shopping_url', window.location.pathname)

	$('#calulate_shipping').submit(e => {
		var url = $('#calulate_shipping').data('url')
		//var total_orig = $('#subtotal_compra').val()
		var cp_input = $('.input-cp').val().trim()
		var cp = parseInt(cp_input)
		var cost = 0
		var cart = JSON.parse(localStorage.getItem('cart')) || {}
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
		$('.btn-calculate-shipping').prop('disabled', true)
		$('.btn-calculate-shipping').button('loading')
		$.getJSON( url+'/'+cp , function(json, textStatus) {
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
				// $('#delivery_cp').html( `<span class="shipping-cargo text-uppercase"></span>` );
				localStorage.setItem('lastcp', cp)	
				setTimeout(() => {
					$('.input-status').removeClass('wrong');
					$('.input-status').addClass('ok');
					// onSuccessAlert(`Como querés recibir tu compra`,'Ingresaste código postal ' + cp, 0, true);
					document.querySelector('.shipping-block').classList.remove('hidden')	
					if (localStorage.getItem('shipping_method') === 'delivery' && localStorage.getItem('delivery_select')) {
						console.log('click(1)')
						$(`.shipping-options li[shipping="${localStorage.getItem('delivery_select')}"]`).click()
					} else {
						if (json.rates.length === 1) {
							console.log('click(2)')
							$(`.shipping-options li:first-child`).click()
						}
					}
				}, 750)
			} else {
				$('.input-status').removeClass('ok');
				$('.input-status').addClass('wrong');
				// $('#cost').text( parseInt(0) );
				//console.log(':::',subtotal,coupon)
				// let total = formatNumber(subtotal - coupon)
				// fxTotal(formatNumber(total))
				setTimeout( "onErrorAlert('Sin cobertura en esta zona', 'El código postal es correcto pero no disponemos de servicio de entrega para tu área.')", 200)
			}
			$('.has-checkout-steps').addClass('done')
			$('.input-cp').attr( 'data-valid' , json.rates.length );
			$('.btn-calculate-shipping').button('reset')
		})
		return false
	})
		
	/* $('#envio_form').submit(function(event){
		console.log('envio_form', 'submit');
		event.preventDefault();


		const submit = $('input[type="submit"]')
		submit.prop('disabled', true)
		submit.addClass('disabled')
		submit.text('Por favor espere...')

		var cart = JSON.parse(localStorage.getItem('cart')) || {}
		let shipping = ''
		let store = ''
		let store_address = ''
		let location = $(this).prop('href')

		if(!cart_items.length){
			onWarningAlert('Tu cart está vacío','No tienes productos en el cart', 5000)
			return false;
		}

		if (cargo === 'shipment') {
			const shipping_cargo = $('.shipping-options li.selected')
			if (!shipping_cargo.length) {
				onErrorAlert('Método de entrega', 'Por favor seleccioná un tipo de envío para tu compra, también podés elegir Retiro en Sucursal para evitar cargos de envío', 0, true);
				// location.hash = 'f:.como-queres-recibir-tu-compra'
				return false;
			} else {
				if (shipping_cargo.attr('shipping')) {
					shipping = shipping_cargo.attr('shipping')
				} else {
					onErrorAlert('Método de entrega','Por favor introducí tu código postal, también podés elegir Retiro en Sucursal para evitar cargos de envío', 0, true);
					// location.hash = 'f:.como-queres-recibir-tu-compra'
					return false;
				}
			}

			var a = $('.input-cp').val();
			var b = parseInt($('.input-cp').attr('data-valid'));
			// if((!a || !b || !c || (1>parseFloat($('#cost').text()) && !freeShipping ))){ // && isDateBeforeToday(new Date(2019, 11, 4)) )) {

			if(!b){ // && isDateBeforeToday(new Date(2019, 11, 4)) )) {
				$('.input-cp').focus();
				$('.input-status').removeClass('ok');
				$('.input-status').addClass('wrong');
				console.log('done(3)')
				$('.has-checkout-steps').addClass('done')
				onErrorAlert('Método de entrega', 'Por favor ingresá tu código postal, la opción  Retiro en Sucursal evita cargos de envío', 0, true);
				return false;
			}
		} else if(cargo === 'takeaway') {
			const takeaway = $('.takeaway-options li.selected')
			if (!takeaway.length) {
				onErrorAlert('Seleccioná sucursal', 'Por favor seleccioná una sucursal para retirar tu compra', 0, true);	
				return false;
			} else {
				if (takeaway.attr('store')) {
					store = takeaway.attr('store')
					store_address = takeaway.attr('store-address')
				} else {
					onErrorAlert('Método de entrega','Por favor indicá tu código postal, la opción  Retiro en Sucursal evita cargos de envío');
					return false;
				}
			}
		} else {
			if (freeShipping) {
				cargo = 'shipment'
			} else {
				onErrorAlert('Método de entrega','Por favor introducí tu código postal, la opción  Retiro en Sucursal evita cargos de envío', 0, true);
				return false
			}
		}

		cart.freeShipping = freeShipping
		//cart.shipping = shipping
		cart.cargo = cargo
		cart.store = store
		cart.store_address = store_address
		cart.regalo = $('#regalo').is(':checked') ? 1 : 0
		localStorage.setItem('cart', JSON.stringify(cart))
		window.location.href = '/checkout/pago';
	});

	$(document).on('click', '.giftchecks',function(e) {
		var cart = JSON.parse(localStorage.getItem('cart')) || {}
		var target_id = parseInt($(e.target).attr('data-id'))
		if(!cart.gifts) {
			cart.gifts = []
		}

		cart.gifts = cart.gifts.filter((id) => id != target_id)
		if($(e.target).is(':checked')){
			cart.gifts.push(target_id)
		}

		if(cart.gifts.length) {
			$('.gift-area').removeClass('hidden')
			$('.gift-count').val(cart.gifts.length)
		} else {
			$('.gift-area').addClass('hidden')
		}
		localStorage.setItem('cart', JSON.stringify(cart))  
	})
	*/
	var cart = JSON.parse(localStorage.getItem('cart')) || {}
	var shipping_method = getStorage('shipping_method')
	var takeaway_selected = getStorage('takeaway_selected', {})

	if(cart.gifts && cart.gifts.length) {
		$('.gift-area').removeClass('hidden')
		$('.gift-count').val(cart.gifts.length)
	}

	if(!lastcp) {
		var lastcp = localStorage.getItem('lastcp')
	}

	if (shipping_method === 'takeaway' && Object.keys(takeaway_selected)?.length && !location.hash.includes('shipment-options.shipping')) {
		setTimeout(() => {
			$('a[href="#retiro"]').click()
			$('.has-checkout-steps').addClass('done')
			// $('label[for="shipment"]').click()
			$(`.takeaway-options li[store="${takeaway_selected.store}"]`).click()
		}, 100)
	}

	if (shipping_method === 'delivery' && lastcp && $('#subtotal_compra').val()) {
		setTimeout(() => {
			$('a[href="#envio"]').click()
			//$('.shipment-block').show()
			$('.input-cp').val(lastcp)
			$('.btn-calculate-shipping').click()

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