var cargo = ''

var selectStore = e => {
	var total_orig = parseFloat($('#subtotal_compra').val())
	var coupon = parseInt(document.querySelector('.coupon_bonus').textContent) || 0

	/* if (document.querySelector('.shipping-options')) {
		document.querySelector('.shipping-options').classList.remove('zoomInRight')
		document.querySelector('.shipping-options').classList.add('zoomOutRight')
		setTimeout(() => {
			document.querySelector('.shipping-block').classList.add('hidden')		
		}, 500)
	} */
	$('.takeaway-options li').removeClass('selected')
	$('.shipping-options li').removeClass('selected')
	$('.free-shipping').addClass('hidden')
	$('.input-cp').removeClass('ok')
	$('.input-cp').val('')
	$('#cost_container').html('')
	$(e).addClass('selected')
  $('.delivery-cost').addClass('hidden')
  var price = parseFloat(total_orig - coupon)
  format_total = formatNumber(price)
  fxTotal(format_total)
  var preferences = JSON.parse(localStorage.getItem('carrito')) || {}
  preferences.cargo = 'takeaway'
  preferences.total_price = price.toFixed(2)
  preferences.shipping_price = 0
  preferences.subtotal_price = total_orig.toFixed(2)
  preferences.store = $(e).attr('store')
  preferences.store_address = $(e).attr('store_address')
  localStorage.setItem('carrito', JSON.stringify(preferences))
  var carrito_takeaway_text = $('.carrito_takeaway_text').text()
  onSuccessAlert('Seleccionaste takeaway', `Puede retirar su producto por sucursal - ${e.textContent} - ${carrito_takeaway_text}`);
	cargo = 'takeaway'
}

var currentCarritoIndex = 0
var show_cart_item = index => {
	var target = document.querySelectorAll('.carrito-item-row')[index]
	if (target) {
		if (!index) {
			$('#carritoItem .carousel-control.left').addClass('is-hidden')
		} else {
			$('#carritoItem .carousel-control.left').removeClass('is-hidden')
		}
		if (index >= document.querySelectorAll('.carrito-item-row').length-1) {
			$('#carritoItem .carousel-control.right').addClass('is-hidden')
		} else {
			$('#carritoItem .carousel-control.right').removeClass('is-hidden')
		}
		return new Promise((resolve, reject) => {
			if ($('#carritoItem').hasClass('active')) {
				$('#carritoItem').removeClass('scaleIn')
				$('#carritoItem').addClass('scaleOut')
				setTimeout(() => {
					resolve()
				}, 100)
			} else {
				resolve()
			}
		}).then(() => {
			$('#carritoItem').removeClass('scaleOut')
			$('.carrito-item-block').html($(target).html())
			$('body').css('overflow-y', 'hidden')
			if (!$('#carritoItem').hasClass('active')) {
				$('#carritoItem').addClass('active')
			}
			$('#carritoItem').addClass('scaleIn')
		})
	}
}

$(document).ready(function() {
	const submit = $('.checkout-btn')
	submit.prop('disabled', false)
	submit.removeClass('disabled')
	submit.text('Siguiente')
	/* carrito item viewer */
	$('.carrito-item-row').on('click', function(e) {
		if (e.target.className !== 'glyphicon glyphicon-remove') {
			currentCarritoIndex = [...document.querySelectorAll('.carrito-item-row')].indexOf(this)
			// var price = $(this).find('#carritoItemCount').val()
			show_cart_item(currentCarritoIndex)
		}
	})
	$('#carritoItem .carousel-control.left').on('click', function(e) {
    e.preventDefault()
		if (currentCarritoIndex > 0) {
			currentCarritoIndex--
		} else {
			currentCarritoIndex = document.querySelectorAll('.carrito-item-row').length
		}
		show_cart_item(currentCarritoIndex)
		console.log('prev')
	})

	$('#carritoItem .carousel-control.right').on('click', function(e) {
    e.preventDefault()
		if (currentCarritoIndex < document.querySelectorAll('.carrito-item-row').length) {
			currentCarritoIndex++
		} else {
			currentCarritoIndex = 0
		}
		show_cart_item(currentCarritoIndex)
	})

	$('#carritoItem .close').on('click', function(e) {
		$('body').css('overflow-y', 'auto')
		$('#carritoItem').removeClass('active')
		$('#carritoItem').removeClass('scaleIn')
	})

	$('#checkout-modal').on('click', 'a', function() {
		var me = $(this);

		$(window).scrollTop(0);
		me.parents('#checkout-modal').modal('hide');
		if (me.hasClass('login')) {
			setTimeout(function() {
				$('#iniciar-sesion').click();
			}, 200);
		}
	});

	$('.cart-go-button').click(function(event){
		event.preventDefault();
		var c = $('[product_row]').length;
		var preferences = JSON.parse(localStorage.getItem('carrito')) || {}
		let shipping = ''
		let store = ''
		let store_address = ''
		let location = $(this).attr('link-to')||$(this).prop('link-to')

		if(!c){
			onSuccessAlert('Carrito vacío','No tienes productos en el carrito', 5000)
			return false;
		}
		if (cargo === 'shipment') {
			const shipping_cargo = $('.shipping-options li.selected')
			if (!shipping_cargo.length) {
				onErrorAlert('¿Cómo querés recibir tu compra?', 'Por favor seleccioná un tipo de envío para tu compra, también podés elegir Retiro en Sucursal para evitar cargos de envío');	
				location.hash = 'f:.como-queres-recibir-tu-compra'
				return false;
			} else {
				if (shipping_cargo.attr('shipping')) {
					shipping = shipping_cargo.attr('shipping')
				} else {
					onErrorAlert('¿Cómo querés recibir tu compra?','Por favor introducí tu código postal, también podés elegir Retiro en Sucursal para evitar cargos de envío');
					location.hash = 'f:.como-queres-recibir-tu-compra'
					return false;
				}
			}

			var a = $('.input-cp').val();
			var b = parseInt($('.input-cp').attr('data-valid'));
			// if((!a || !b || !c || (1>parseFloat($('#cost').text()) && !freeShipping ))){ // && isDateBeforeToday(new Date(2019, 11, 4)) )) {
			if(!a || !b || !c){ // && isDateBeforeToday(new Date(2019, 11, 4)) )) {
				$('.input-cp').focus();
				$('.input-cp').removeClass('ok');
				$('.input-cp').addClass('wrong');
				onErrorAlert('¿Cómo querés recibir tu compra?', 'Por favor ingresá tu código postal, la opción  Retiro en Sucursal evita cargos de envío');
				return false;
			}
		} else if(cargo === 'takeaway') {
			const takeaway = $('.takeaway-options li.selected')
			if (!takeaway.length) {
				onErrorAlert('Seleccioná sucursal', 'Por favor seleccioná una sucursal para retirar tu compra');	
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
				onErrorAlert('¿Cómo querés recibir tu compra?','Por favor introducí tu código postal, la opción  Retiro en Sucursal evita cargos de envío');
				return false
			}
		}

		const submit = $('.cart-go-button')
		submit.prop('disabled', true)
		submit.addClass('disabled')
		submit.text('Por favor espere...')

		preferences.freeShipping = freeShipping
		preferences.shipping = shipping
		preferences.cargo = cargo
		preferences.store = store
		preferences.store_address = store_address
		preferences.regalo = $('#regalo').is(':checked') ? 1 : 0
		localStorage.setItem('carrito', JSON.stringify(preferences))
		window.location.href = location;
	});

	$(document).on('click', '.trash', e => {
		e.preventDefault()
		e.stopPropagation()
		if (confirm('Estás seguro que que querés borrar este producto del carrito?')) {
			const target = $(e.target).closest('.trash')
		  $.get(target.attr('href'), res => {

		  	let item = JSON.parse(res)
				/* @Analytics: removeFromCart */
				fbq('track', 'RemoveFromCart')
				gtag('event', 'remove_from_cart', {
				  "items": [
				    {
				      "id": item.id,
				      "name": item.article,
				      // "list_name": "Results",
				      "brand": item.name,
				      // "category": "Apparel/T-Shirts",
				      "variant": item.alias,
				      "list_position": 1,
				      "quantity": 1,
				      "price": item.discount
				    }
				  ]
				})

				setTimeout(() => {
					location.href = '/carrito'
				}, 1000)
			})
		}
	})

	$(document).on('click', '.btn-change-count',function(e) {
		var json = $('.has-item-counter.active .carrito-data').data('json')
		var item = JSON.parse(JSON.stringify(json))
		var count = $('.has-item-counter.active .product-count').val();
		var data = {
			count: parseInt(count),
			id: item.id,
			color: item.color,
			color_code: item.color_code,
			size: item.size,
			alias: item.alias,
		}
		addCart(data, e.target, 'Modificando...')
	})
	
	var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
	if (carrito.cargo === 'takeaway' && carrito.store.length) {
		$(`.takeaway-options li[store="${carrito.store}"]`).click()
	}
	if (carrito.coupon && carrito.coupon.length) {
		$('.input-coupon').val(carrito.coupon)
		setTimeout(() => {
			$('.btn-calculate-coupon').click()
		}, 1000)
	}

	if (lastcp && $('#subtotal_compra').val()) {
		$('.input-cp').val(lastcp)
		setTimeout(() => {
			const takeaway = $('.takeaway-options li.selected')
			if(!takeaway.length || freeShipping) {
				$('#calulate_shipping').submit()	
				onWarningAlert('Calculando envío', `Un segundo por favor, estamos calculando el costo de envío para el código postal ${lastcp}`, 5000)
			} else {
				onWarningAlert('Envío a domicilio disponible', `Puede solicitar envío a domicilio. Solo debe calcular los costos para el cód. postal ${lastcp} y seleccionar su opción.`, 5000)
			}
		}, 1000)		
	}
})