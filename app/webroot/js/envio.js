var currentCartIndex = 0
var cargo = ''
var itemData = null
var removeElement = null

var selectStore = e => {
	var preferences = JSON.parse(localStorage.getItem('cart')) || {}
	var total_orig = parseFloat($('#subtotal_compra').val())
	//console.log('total_orig',total_orig)
	//console.log(document.querySelector('.coupon_bonus').innerHTML)
	var coupon = Number(preferences.coupon_bonus || 0)
	$('.takeaway-options li').removeClass('selected secondary')
	$('.shipping-options li').removeClass('selected secondary')
	$('.takeaway-options li').addClass('secondary')
	$('.free-shipping').addClass('hidden')
	$('.input-cp-container').removeClass('ok')
	$('.input-cp').val('')
	$('#cost_container').html('')
	$(e).addClass('selected')
  $('.delivery-cost').addClass('hidden')
  var price = parseFloat((total_orig - coupon).toFixed(2))
  // $('.cost_total').text('$ ' + formatNumber(total_orig))
  // $('.calc_total').text('$ ' + formatNumber(total_orig))
  format_total = formatNumber(price)
  // fxTotal(format_total)
  preferences.cargo = 'takeaway'
  //console.log('total_price(2)', price)
  preferences.total_price = price
  preferences.shipping_price = 0
  preferences.subtotal_price = total_orig
  preferences.store = $(e).attr('store')
  preferences.store_address = $(e).attr('store_address')
  localStorage.setItem('cart', JSON.stringify(preferences))
  var carrito_takeaway_text = $('.carrito_takeaway_text').text()
  const suc = e.textContent.split(' ')[0]
  onSuccessAlert(`Como querés recibir tu compra`, `Seleccionaste la opción retirar en sucursal ${suc.replace(',','')}. Puedes pasar a retirar tu producto por nuestra sucursal en ${e.textContent}. <br><br> ${carrito_takeaway_text}`);
	cargo = 'takeaway'
}

$(document).ready(function() {
	/*if(cart_items?.length == 1) {
		$('.products-total').hide()
	} else {
		$('.products-total').show()
	}*/
	const submit = $('.checkout-btn')
	submit.prop('disabled', false)
	submit.removeClass('disabled')
	submit.text('Siguiente')

	$('.cart-go-button').click(function(event){
		event.preventDefault();
		var c = $('[product_row]').length;
		var preferences = JSON.parse(localStorage.getItem('cart')) || {}
		let shipping = ''
		let store = ''
		let store_address = ''
		let location = $(this).attr('link-to')||$(this).prop('link-to')

		if(!c){
			onWarningAlert('<i class="fa fa-warning"></i> Cart vacío','No tienes productos en el carrito', 5000)
			return false;
		}

		if (cargo === 'shipment') {
			const shipping_cargo = $('.shipping-options li.selected')
			if (!shipping_cargo.length) {
				onErrorAlert('¿Cómo querés recibir tu compra?', 'Por favor seleccioná un tipo de envío para tu compra, también podés elegir Retiro en Sucursal para evitar cargos de envío', 0, true);
				location.hash = 'f:.como-queres-recibir-tu-compra'
				return false;
			} else {
				if (shipping_cargo.attr('shipping')) {
					shipping = shipping_cargo.attr('shipping')
				} else {
					onErrorAlert('¿Cómo querés recibir tu compra?','Por favor introducí tu código postal, también podés elegir Retiro en Sucursal para evitar cargos de envío', 0, true);
					location.hash = 'f:.como-queres-recibir-tu-compra'
					return false;
				}
			}

			var a = $('.input-cp').val();
			var b = parseInt($('.input-cp').attr('data-valid'));
			// if((!a || !b || !c || (1>parseFloat($('#cost').text()) && !freeShipping ))){ // && isDateBeforeToday(new Date(2019, 11, 4)) )) {

			if(!b || !c){ // && isDateBeforeToday(new Date(2019, 11, 4)) )) {
				$('.input-cp').focus();
				$('.input-cp-container').removeClass('ok');
				$('.input-cp-container').addClass('wrong');
				onErrorAlert('¿Cómo querés recibir tu compra?', 'Por favor ingresá tu código postal, la opción  Retiro en Sucursal evita cargos de envío', 0, true);
				return false;
			}
		} else if(cargo === 'takeaway') {
			const takeaway = $('.takeaway-options li.selected')
			if (!takeaway.length) {
				onErrorAlert('<i class="fa fa-map-marker"></i> Seleccioná sucursal', 'Por favor seleccioná una sucursal para retirar tu compra', 0, true);	
				return false;
			} else {
				if (takeaway.attr('store')) {
					store = takeaway.attr('store')
					store_address = takeaway.attr('store-address')
				} else {
					onErrorAlert('¿Cómo querés recibir tu compra?','Por favor indicá tu código postal, la opción  Retiro en Sucursal evita cargos de envío');
					return false;
				}
			}
		} else {
			if (freeShipping) {
				cargo = 'shipment'
			} else {
				onErrorAlert('¿Cómo querés recibir tu compra?','Por favor introducí tu código postal, la opción  Retiro en Sucursal evita cargos de envío', 0, true);
				return false
			}
		}

		const submit = $('.cart-go-button')
		submit.prop('disabled', true)
		submit.addClass('disabled')
		submit.text('Por favor espere...')

		preferences.freeShipping = freeShipping
		//preferences.shipping = shipping
		preferences.cargo = cargo
		preferences.store = store
		preferences.store_address = store_address
		preferences.regalo = $('#regalo').is(':checked') ? 1 : 0
		localStorage.setItem('cart', JSON.stringify(preferences))
		window.location.href = location;
	});

	$(document).on('click', '.giftchecks',function(e) {
		var carrito = JSON.parse(localStorage.getItem('cart')) || {}
		var target_id = parseInt($(e.target).attr('data-id'))
		if(!carrito.gifts) {
			carrito.gifts = []
		}

		carrito.gifts = carrito.gifts.filter((id) => id != target_id)
		if($(e.target).is(':checked')){
			carrito.gifts.push(target_id)
		}

		if(carrito.gifts.length) {
			$('.gift-area').removeClass('hidden')
			$('.gift-count').val(carrito.gifts.length)
		} else {
			$('.gift-area').addClass('hidden')
		}
		localStorage.setItem('cart', JSON.stringify(carrito))  
	})
	
	var carrito = JSON.parse(localStorage.getItem('cart')) || {}

	if (carrito.cargo === 'takeaway' && carrito.store.length && !location.hash.includes('shipment-options.shipping')) {
		setTimeout(() => {
			$(`.takeaway-options li[store="${carrito.store}"]`).click()
		}, 2000)
	}

	if (carrito.coupon && carrito.coupon.length) {
		$('.input-coupon').val(carrito.coupon)
		setTimeout(() => {
			$('.btn-calculate-coupon').click()
		}, 1000)
	}

	if(carrito.gifts && carrito.gifts.length) {
		$('.gift-area').removeClass('hidden')
		$('.gift-count').val(carrito.gifts.length)
	}

	if(!lastcp) {
		var lastcp = localStorage.getItem('lastcp')
	}

	if (lastcp && $('#subtotal_compra').val()) {
		setTimeout(() => {
			$('label[for="shipment"]').click()
			//$('.shipment-block').show()
			$('.input-cp').val(lastcp)
			$('.btn-calculate-shipping').click()

			const takeaway = $('.takeaway-options li.selected')
			if(cargo === 'shipment' && !takeaway.length || freeShipping) {
				// $('#calulate_shipping').submit()	
				// onWarningAlert('Calculando envío', `Un segundo por favor, estamos calculando el costo de envío para el código postal ${lastcp}`, 5000, true)
			} else {
				// onWarningAlert('Envío a domicilio disponible', `Puede solicitar envío a domicilio. Solo debe calcular los costos para el cód. postal ${lastcp} y seleccionar su opción.`, 5000, true)
			}
		}, 1000)
	}
})