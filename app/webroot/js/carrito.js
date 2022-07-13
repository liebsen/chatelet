var cargo = ''
var selectStore = e => {
	var total_orig = $('#subtotal_compra').val()
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
  format_total = formatNumber(parseFloat(total_orig) - coupon)
  fxTotal(format_total)
  var preferences = JSON.parse(localStorage.getItem('carrito')) || {}
  preferences.cargo = 'takeaway'
  preferences.store = $(e).attr('store')
  preferences.store_address = $(e).attr('store_address')
  localStorage.setItem('carrito', JSON.stringify(preferences))
  var carrito_takeaway_text = $('.carrito_takeaway_text').text()
  onSuccessAlert('Usted seleccionó takeaway', `Puede retirar su producto por sucursal - ${e.textContent} - ${carrito_takeaway_text}`);
	cargo = 'takeaway'
}

callStart = function(){
	setTimeout(() => {
		$('.btn-calculate-shipping').button('loading')
		$('#cost_container').removeClass('text-muted', 'text-success');
		$('#cost_container').addClass('hide');
		// $('#loading').removeClass('hide');
	}, 10)
}

callEnd = function(){
	cargo = 'shipment'
	$('.btn-calculate-shipping').button('reset')
	$('.shipping-loading').removeClass('animated fadeOut');
	$('#cost_container').removeClass('animated fadeIn');
	setTimeout(() => {
		$('.shipping-loading').addClass('animated fadeOut');		
		$('#cost_container').addClass('animated fadeIn');
	}, 10)
	setTimeout(() => {
		$('#cost_container').removeClass('hide');
		$('.shipping-loading').addClass('hide');
		$('#cost_container').addClass('text-success');
	}, 500)
}

onErrorAlert = function(title, text, duration){
	$.growl.error({
		title: title || 'Error',
		message: text,
		queue: true,
		duration: duration || 15000
	});
}

onSuccessAlert = function(title, text, duration){
	$.growl.notice({
		title: title || 'OK',
		message: text,
		queue: true,
		duration: duration || 15000
	});
}

onWarningAlert = function(title, text, duration){
	// $('#growls').remove();
	$.growl.warning({
		title: title || 'OK',
		message: text,
		queue: true,
		duration: duration || 15000
	});
}

function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

formatNumber = function (num) {
	return '$'+number_format(num, 2, ',', '.').replace(',00','')
  //return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
}

isDateBeforeToday = function(date) {
  return new Date(date.toDateString()) < new Date(new Date().toDateString());
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
		console.log('next')
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
				onErrorAlert('¿Cómo desea recibir su compra?', 'Por favor seleccione un tipo de envío para su compra o seleccione Retiro en Sucursal para evitar cargos de envío');	
				return false;
			} else {
				if (shipping_cargo.attr('shipping')) {
					shipping = shipping_cargo.attr('shipping')
				} else {
					onErrorAlert('¿Cómo desea recibir su compra?','Por favor indique su código postal o seleccione retiro en sucursal');
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
				onErrorAlert('¿Cómo desea recibir su compra?', 'Por favor ingrese su código postal');
				return false;
			}
		} else if(cargo === 'takeaway') {
			const takeaway = $('.takeaway-options li.selected')
			if (!takeaway.length) {
				onErrorAlert('Seleccione sucursal', 'Por favor seleccione una sucursal para retirar su compra');	
				return false;
			} else {
				if (takeaway.attr('store')) {
					store = takeaway.attr('store')
					store_address = takeaway.attr('store-address')
				} else {
					onErrorAlert('¿Cómo desea recibir su compra?','Por favor indique su código postal o seleccione retiro en sucursal');
					return false;
				}
			}
		} else {
			if (freeShipping) {
				cargo = 'shipment'
			} else {
				onErrorAlert('¿Cómo desea recibir su compra?','Por favor indique su código postal o seleccione Retiro en Sucursal para envitar cargos de envío');
				return false
			}
		}

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

	var lastcp = localStorage.getItem('lastcp') || 0
	if (lastcp && $('#subtotal_compra').val()) {
		$('.input-cp').val(lastcp)
		setTimeout(() => {
			const takeaway = $('.takeaway-options li.selected')
			if(!takeaway || freeShipping) {
				$('#calulate_shipping').submit()	
				onWarningAlert('Calculando envío', `Un segundo por favor, estamos calculando el costo de envío para el código postal ${lastcp}`, 5000)
			} else {
				onWarningAlert('Envío a domicilio disponible', `Puede solicitar envío a domicilio. Solo debe calcular los costos para el cód. postal ${lastcp} y seleccionar su opción.`, 5000)
			}
		}, 1000)		
	}
})