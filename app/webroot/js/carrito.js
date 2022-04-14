var cargo = ''
var selectStore = e => {
	var total_orig = $('#subtotal_compra').val()
	var coupon = parseInt(document.querySelector('.coupon_bonus').textContent) || 0
	$('.input-cp').val('')
	$('#cost_container').html('')
	$('.takeaway-options li').removeClass('selected')
	$(e).addClass('selected')
  $('.delivery-cost').addClass('hidden')
  format_total = formatNumber(parseFloat(total_orig) - coupon)
  fxTotal(format_total)
	cargo = 'takeaway'
}

$(document).ready(function() {
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
		let store = ''
		let store_address = ''
		let location = $(this).attr('link-to')||$(this).prop('link-to')

		if(!c){
			onErrorAlert('No tienes productos en el carrito')
			return false;
		}
		if (cargo === 'shipment') {
			var a = $('.input-cp').val();
			var b = parseInt($('.input-cp').attr('data-valid'));
			// if((!a || !b || !c || (1>parseFloat($('#cost').text()) && !freeShipping ))){ // && isDateBeforeToday(new Date(2019, 11, 4)) )) {
			if(!a || !b || !c){ // && isDateBeforeToday(new Date(2019, 11, 4)) )) {
				$('.input-cp').focus();
				$('.input-cp').removeClass('ok');
				$('.input-cp').addClass('wrong');
				onErrorAlert('Por favor ingrese su código postal');
				return false;
			}
		} else if(cargo === 'takeaway') {
			const selected = $('.takeaway-options li.selected')
			if (!selected.length) {
				onErrorAlert('Por favor seleccione una sucursar para pasar a retirar el producto');	
				return false;
			} else {
				if (selected.attr('store')) {
					store = selected.attr('store')
					store_address = selected.attr('store-address')
				} else {
					onErrorAlert('Por favor indique su código postal o seleccione retiro en sucursal (1)');
					return false;
				}
			}
		} else {
			if (freeShipping) {
				cargo = 'shipment'
			} else {
				onErrorAlert('Por favor indique su código postal o seleccione retiro en sucursal (2)');
				return false
			}
		}

		preferences.cargo = cargo
		preferences.store = store
		preferences.store_address = store_address
		preferences.ticket_cambio = $('#ticket_cambio').is(':checked') ? 1 : 0
		localStorage.setItem('carrito', JSON.stringify(preferences))
		window.location.href = location;
	});

	$('.trash').on('click', e => {
		e.preventDefault()
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
})