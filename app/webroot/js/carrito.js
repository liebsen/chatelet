var currentCartIndex = 0
var cargo = ''
var itemData = null
var removeElement = null

function addToCart(data) {
	$.post('/carrito/add', $.param(data))
		.success(function(res) {
			console.log('res', res)
			if (res.success) {
				window.dataLayer = window.dataLayer || []
				fbq('track', 'AddToCart')
				/* @Analytics: addToCart */
				gtag('event', 'add_to_cart', {
				  "items": [
				    {
				      "id": data.id,
				      "name": $('.product').text(),
				      // "list_name": "Search Results",
				      // "brand": "Google",
				      // "category": "Apparel/T-Shirts",
				      "variant": data.alias,
				      "list_position": 1,
				      "quantity": data.count,
				      "price": $('.price').text()
				    }
				  ]
				})

        $.growl.error({
          title: 'Agregado al carrito',
          message: 'Podés seguir agregando más productos o finalizar esta compra en la sección carrito'
        });

        var reload = function() {
        	window.location.href = '/carrito'
        };

        setTimeout(reload, 1000);
        
        $('.growl-close').click(reload);

				dataLayer.push({
				  'event': 'addToCart',
				  'ecommerce': {
				    'currencyCode': 'ARS',
				    'add': {         
				      'products': [{
				        'name': $('.product').text(),
				        'id': data.id,
				        'price': $('.price').text(),
				        'brand': 'Google',
				        'category': 'Apparel',
				        'variant': data.alias,
				        'quantity': 1
				       }]
				    }
				  },
					'eventCallback': function() {
	          $.growl.notice({
	            title: 'Producto agregado al carrito',
	            message: 'Podés seguir agregando más productos o ir a la sección Pagar'
	          });
	          var reload = function() {
	          	window.location.href = '/carrito'
	          };
	          setTimeout(reload, 3000);
	          $('.growl-close').click(reload);
     			}
				})
			} else {
        $.growl.error({
          title: 'Ocurrió un error al agregar el producto al carrito',
          message: 'Por favor, intentá nuevamente en unos instantes'
        });
			}
		})
		.fail(function() {
      $.growl.error({
        title: 'Ocurrio un error al agregar el producto al carrito',
        message: 'Por favor, intente nuevamente'
      });
		});	
}

var askremoveCart = (e) => {
	const item = $(e).parents('.carrito-data').data('json')
	let userInput = confirm(`Deseas eliminar ${item.name} del carrito?`);
	if(userInput){
		$.get(`/carrito/remove/${item.id}`).then((res) => {
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
			console.log('refersh')
			window.location.href = window.location.href
		})
	}
}

var removeCart = (e) => {
	if(!removeElement) return
	const block = $(removeElement).parent()
	const json = $(block).find('.carrito-data').data('json')
	block.addClass('flash infinite')
	let item = JSON.parse(JSON.stringify(json))
	$('#carrito-remove-btn').button('loading')
	$.get(`/carrito/remove/${item.id}`).then((res) => {
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

		block.removeClass('flash infinite')
		block.addClass('fadeOut')
		setTimeout(() => {
			$('#carrito-remove-btn').button('reset')
			location.href = '/carrito'
			//block.remove()
		}, 500)
	})
}

var selectStore = e => {
	var preferences = JSON.parse(localStorage.getItem('carrito')) || {}
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
  $('.cost_total').text('$ ' + formatNumber(total_orig))
  $('.calc_total').text('$ ' + formatNumber(total_orig))
  format_total = formatNumber(price)
  fxTotal(format_total)
  preferences.cargo = 'takeaway'
  //console.log('total_price(2)', price)
  preferences.total_price = price
  preferences.shipping_price = 0
  preferences.subtotal_price = total_orig
  preferences.store = $(e).attr('store')
  preferences.store_address = $(e).attr('store_address')
  localStorage.setItem('carrito', JSON.stringify(preferences))
  var carrito_takeaway_text = $('.carrito_takeaway_text').text()
  const suc = e.textContent.split(' ')[0]
  onSuccessAlert(`Como querés recibir tu compra`, `Seleccionaste la opción retirar en sucursal ${suc.replace(',','')}. Puedes pasar a retirar tu producto por nuestra sucursal en ${e.textContent}. <br><br> ${carrito_takeaway_text}`);
	cargo = 'takeaway'
}
var show_cart_item = (index) => {
	//console.log('show_cart_item')
	var target = document.querySelectorAll('.cart-row')[index]
	if (target) {
		if (!index) {
			$('#carritoItem .carousel-control.left').addClass('is-hidden')
		} else {
			$('#carritoItem .carousel-control.left').removeClass('is-hidden')
		}
		if (index >= document.querySelectorAll('.cart-row').length-1) {
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
			$('.ch-block').html($(target).html())
			$('html, body').addClass('disable-scroll')
			if (!$('#carritoItem').hasClass('active')) {
				$('#carritoItem').addClass('active')
			}
			$('#carritoItem').addClass('scaleIn')
		})
	}
}


$(document).ready(function() {
	/*if(carrito_items?.length == 1) {
		$('.products-total').hide()
	} else {
		$('.products-total').show()
	}*/
	const submit = $('.checkout-btn')
	submit.prop('disabled', false)
	submit.removeClass('disabled')
	submit.text('Siguiente')

	/* carrito item viewer */
	$('.cart-edit').on('click', function(e) {
		//if(window.screen.width > 768) return false;
		var donts = [
			'glyphicon glyphicon-remove', 
			'giftchecks', 
			'label-text text-muted text-small',
		]	
		if (!donts.includes(e.target.className)) {
			$('html, body').addClass('disable-scroll')
			currentCartIndex = [...document.querySelectorAll('.cart-row')].indexOf(this)
			show_cart_item(currentCartIndex)
		}
	})

	$('#carritoItem .carousel-control.left').on('click', function(e) {
    e.preventDefault()
		if (currentCartIndex > 0) {
			currentCartIndex--
		} else {
			currentCartIndex = document.querySelectorAll('.cart-row').length
		}
		show_cart_item(currentCartIndex)
	})

	$('#carritoItem .carousel-control.right').on('click', function(e) {
    e.preventDefault()
		if (currentCartIndex < document.querySelectorAll('.cart-row').length) {
			currentCartIndex++
		} else {
			currentCartIndex = 0
		}
		show_cart_item(currentCartIndex)
	})

	$('#carritoItem .close').on('click', function(e) {
		$('html, body').removeClass('disable-scroll')
		$('#carritoItem').removeClass('active')
		$('#carritoItem').removeClass('scaleIn')
	})

	$('#checkout-modal').on('click', 'a', function() {
		var a = $(this);
		$(window).scrollTop(0);
		a.parents('#checkout-modal').modal('hide');
		if (a.hasClass('login')) {
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
			onWarningAlert('<i class="fa fa-warning"></i> Cart vacío','No tienes productos en el carrito', 5000)
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

			if(!b || !c){ // && isDateBeforeToday(new Date(2019, 11, 4)) )) {
				$('.input-cp').focus();
				$('.input-cp-container').removeClass('ok');
				$('.input-cp-container').addClass('wrong');
				onErrorAlert('¿Cómo querés recibir tu compra?', 'Por favor ingresá tu código postal, la opción  Retiro en Sucursal evita cargos de envío');
				return false;
			}
		} else if(cargo === 'takeaway') {
			const takeaway = $('.takeaway-options li.selected')
			if (!takeaway.length) {
				onErrorAlert('<i class="fa fa-map-marker"></i> Seleccioná sucursal', 'Por favor seleccioná una sucursal para retirar tu compra');	
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
		//preferences.shipping = shipping
		preferences.cargo = cargo
		preferences.store = store
		preferences.store_address = store_address
		preferences.regalo = $('#regalo').is(':checked') ? 1 : 0
		localStorage.setItem('carrito', JSON.stringify(preferences))
		window.location.href = location;
	});

	$(document).on('click', '.giftchecks',function(e) {
		var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
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
		localStorage.setItem('carrito', JSON.stringify(carrito))  
	})

	$(document).on('click', '.btn-change-count',function(e) {
		let count = $(this).parent().find('input').first().val()
		var json = $(this).parents('.carrito-data').data('json')
		var item = JSON.parse(JSON.stringify(json))
		
		if($(e.target).hasClass('disable') || count == 0) {
			return false
		}

		if($(this).is(':first-child')) {
			count--
		} else {
			count++
		}

		var data = {
			count: parseInt(count),
			id: item.id,
			color: item.color,
			color_code: item.color_code,
			size: item.size,
			alias: item.alias,
		}
		
		addCart(data)
	})
	
	var carrito = JSON.parse(localStorage.getItem('carrito')) || {}

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

	if (lastcp && $('#subtotal_compra').val()) {
		setTimeout(() => {
			$('label[for="shipment"]').click()
			//$('.shipment-block').show()
			$('.input-cp').val(lastcp)
			$('.btn-calculate-shipping').click()

			const takeaway = $('.takeaway-options li.selected')
			if(cargo === 'shipment' && !takeaway.length || freeShipping) {
				$('#calulate_shipping').submit()	
				onWarningAlert('<i class="fa fa-stopwatch"></i> Calculando envío', `Un segundo por favor, estamos calculando el costo de envío para el código postal ${lastcp}`, 5000)
			} else {
				onWarningAlert('Envío a domicilio disponible', `Puede solicitar envío a domicilio. Solo debe calcular los costos para el cód. postal ${lastcp} y seleccionar su opción.`, 5000)
			}
		}, 1000)
	}
})