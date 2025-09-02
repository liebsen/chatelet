$(function(){
	var subtotal = $('#subtotal_compra').val()
	selectShipping = function (e, shipping, cost) {

		if (cost <= 0) {
			return setTimeout( `onErrorAlert('No disponible', 'El servicio de logística ${shipping.toUpperCase()} no está disponible en este momento, intente en unos instantes.')` , 200)
		}

		var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
		var coupon = $('.coupon_bonus') ? 
			$('.coupon_bonus').text().split('.').join('').split(',').join('.') : 
			carrito.coupon_bonus || 0
		var subtotal = $('#subtotal_compra') ? 
			parseFloat($('#subtotal_compra').val()) : 
			carrito.subtotal_price
		//var subtotal = carrito.subtotal_price
		cargo = 'shipment'
		var shipping_price = carrito.shipping_price
		$('.shipping-options li').removeClass('selected secondary')
		$('.takeaway-options li').removeClass('selected secondary')
		$('.shipping-options li').addClass('secondary')
		$(e).addClass('selected')
		$('.delivery-cost').addClass('hidden')
		$('.shipping-cargo').text(shipping)	

		var price = subtotal + cost - coupon
		//console.log('cost_total(2)', subtotal, cost)
		$('.cost_total').text('$ ' + formatNumber(subtotal + cost))
		if(log){
			console.log('subtotal', subtotal)
			console.log('cost', cost)
		}

		if (price < shipping_price) {
			price+= cost
			$('#subtotal_envio').val(cost)
			$('.delivery-cost').removeClass('hidden')
			$('.delivery-cost').addClass('fadeIn')
			//console.log('cost',cost)
			$('.cost_delivery').text( formatNumber(cost))
		}

	  var preferences = JSON.parse(localStorage.getItem('carrito')) || {}
		preferences.shipping = shipping
	  preferences.cargo = cargo
	  if(log)
	  	console.log('shipping_price(1)', cost)
	  preferences.shipping_price = cost
	  preferences.total_price = price
	  preferences.subtotal_price = subtotal
	  localStorage.setItem('carrito', JSON.stringify(preferences))

	  //console.log('price',price)
		let total = formatNumber(price)
		let info = $(e).data('info')
		fxTotal(total)
		$('.paying-with').delay(1000).fadeIn()
		onErrorAlert(`Te lo llevamos por ${shipping.toUpperCase()}`, info || `Seleccionaste ${shipping.toUpperCase()} como servicio de entrega`);
	}

	$('#calulate_shipping').submit(e => {
		var url = $('#calulate_shipping').data('url')
		//var total_orig = $('#subtotal_compra').val()
		var cp_input = $('.input-cp').val().trim()
		var cp = parseInt(cp_input)
		var cost = 0
		var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
		var coupon = $('.coupon_bonus') ? 
			$('.coupon_bonus').text().split('.').join('').split(',').join('.') : 
			carrito.coupon_bonus || 0
		var subtotal = parseFloat($('#subtotal_compra').val()) || carrito.subtotal_price

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
		$('.delivery-cost').addClass('hidden')
		callStart()
		$.getJSON( url+'/'+cp , function(json, textStatus) {
			callEnd()
			window.freeShipping = json.freeShipping
			if( json.rates.length ){
				$('.products-total').removeClass('hidden')
				//free delivery
				if (json.freeShipping){  
					//console.log('Envio gratis!')
					// $('#subtotal_envio').val( 0 );
					// $('#free_delivery').text('Envio gratis!');
				}
				var rates = `<ul class="generic-select shipping-options">`
				json.rates.forEach(rate => {
					if (!isNaN(rate.price)) {
						var price = '<span class="text-success text-bold">Gratis</span>'
						if (!json.freeShipping) {
							price = `<span class="text-uppercase">$${parseInt(rate.price)}</span>`
						}
						rates+= `<li shipping="${rate.code}" data-info="${rate.info}" onclick="selectShipping(this, '${rate.code}',${parseInt(rate.price)})"><div class="shipping-logo" style="background-image: url('${rate.image}')">${price}</div></li>`
					}
				})
				rates+= `</ul>`
				document.querySelector('.shipping-block .slot').innerHTML = rates
				$('#delivery_cp').html( `<span class="shipping-cargo text-uppercase"></span>` );
				localStorage.setItem('lastcp', cp)	
				setTimeout(() => {
					$('.input-cp').removeClass('wrong');
					$('.input-cp').addClass('ok');
					onSuccessAlert(cp, '✓ Código Postal válido');
					document.querySelector('.shipping-block').classList.remove('hidden')	
					if (carrito.cargo === 'shipment' && carrito.shipping) {
						$(`.shipping-options li[shipping="${carrito.shipping}"]`).click()
					} else {
						if (json.rates.length === 1) {
							$(`.shipping-options li:first-child`).click()
						}
					}
				}, 750)
			} else {
				$('.input-cp').addClass('wrong');
				$('#cost').text( parseInt(0) );
				//console.log(':::',subtotal,coupon)
				let total = formatNumber(subtotal - coupon)
				fxTotal(formatNumber(total))
				setTimeout( "onErrorAlert('Sin cobertura en esta zona', 'El código postal es correcto pero no disponemos de servicio de entrega para tu área.')", 200)
			}
			$('.input-cp').attr( 'data-valid' , json.rates.length );
			$('.btn-calculate-shipping').button('reset')
		})
		return false
	})
})

