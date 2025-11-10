$(function(){
	selectShipping = function (e, shipping, cost) {
		if (cost <= 0) {
			return setTimeout( `onErrorAlert('No disponible', 'El servicio de logística ${shipping.toUpperCase()} no está disponible en este momento, intente en unos instantes.')` , 200)
		}

		var cart = JSON.parse(localStorage.getItem('cart')) || {}
		var coupon = $('.coupon_bonus') ? 
			$('.coupon_bonus').text().split('.').join('').split(',').join('.') : 
			cart.coupon_bonus || 0
		var subtotal = cart_totals.total_products
		//var subtotal = cart.subtotal_price
		cargo = 'shipment'
		var shipping_price = window.shipping_price
		$('.shipping-options li').removeClass('selected secondary')
		$('.takeaway-options li').removeClass('selected secondary')
		$('.shipping-options li').addClass('secondary')
		$(e).addClass('selected')
		$('.delivery-cost').addClass('hidden')
		$('.shipping-cargo').text(shipping)	

		var price = subtotal - coupon
		if (price < shipping_price) {
			price+= cost
			$('#subtotal_envio').val(cost)
			$('.delivery-cost').removeClass('hidden')
			$('.delivery-cost').addClass('fadeIn')
			$('.cost_delivery').text( formatNumber(cost))
		}

		$('.cost_total').text('$ ' + formatNumber(price))

	  var preferences = JSON.parse(localStorage.getItem('cart')) || {}
		preferences.shipping = shipping
	  preferences.cargo = cargo
	  preferences.shipping_price = cost
	  preferences.total_price = price
	  preferences.subtotal_price = subtotal
	  localStorage.setItem('cart', JSON.stringify(preferences))

	  //console.log('price',price)
		let total = formatNumber(price)
		let info = $(e).data('info')
		fxTotal(total)
		$('.paying-with').delay(1000).fadeIn()
		// onErrorAlert(`Como querés recibir tu compra`, `Te lo llevamos por ${shipping.toUpperCase()}`, 0, true);
	}

	$('.select-cargo-option').click(e => {
		const target = $(e.target).hasClass('select-cargo-option') ? 
			$(e.target) : 
			$(e.target).parents('.select-cargo-option')

		var selected = target.find('input').val()

		$('.cargo-blocks').hide()
		$(`.${selected}-block`).show()

		$('.shipment-options .option-rounded').removeClass('is-selected is-secondary')
		$('.shipment-options .option-rounded').addClass('is-secondary')
		target.addClass('is-selected')
	});

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
					$('.input-cp-container').removeClass('wrong');
					$('.input-cp-container').addClass('ok');
					// onSuccessAlert(`Como querés recibir tu compra`,'Ingresaste código postal ' + cp, 0, true);
					document.querySelector('.shipping-block').classList.remove('hidden')	
					if (cart.cargo === 'shipment' && cart.shipping) {
						$(`.shipping-options li[shipping="${cart.shipping}"]`).click()
					} else {
						if (json.rates.length === 1) {
							$(`.shipping-options li:first-child`).click()
						}
					}
				}, 750)
			} else {
				$('.input-cp-container').addClass('wrong');
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

