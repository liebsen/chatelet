var last_selected = ''
var select_payment = (e) => {
	var selected = $(e).find(':checked').val()
	if(!selected) {
		return false
	}
	last_selected = selected	
	var subtotal = carrito.subtotal_price
	var bank_bonus = 0
	if (selected === 'bank' && bank.enable && bank.discount_enable && bank.discount) {
		bank_bonus = subtotal * (parseFloat(bank.discount) / 100)
		$('.bank_bonus').text(formatNumber(bank_bonus))
		$('.bank-block').removeClass('hide')
		$('.bank-block').addClass('animated fadeIn')
	} else {
		$('.bank-block').addClass('hide')
	}
	var total = subtotal
	if (!carrito.freeShipping && carrito.shipping_price) {
		total+= carrito.shipping_price
	}
	if (carrito.coupon_bonus) {
		total-= carrito.coupon_bonus
	}
	if (bank_bonus) {
		total-= bank_bonus
	}
  //console.log('subtotal',subtotal)
  //console.log('total',total)
  //console.log('bank_bonus',bank_bonus)
  onSuccessAlert((selected === 'bank' ? 'CBU/Alias' : 'Mercadopago'), '✓ Método de pago seleccionado');
  localStorage.setItem('pm', selected)
	$('.total_price').text(formatNumber(total))
	$('.payment-method .option-rounded').removeClass('is-selected')
	$(e).addClass('is-selected')

}

$(function(){

	$(`.cargo-${carrito.cargo}`).removeClass('hide')
	$(`.cargo-${carrito.cargo}`).addClass('animated fadeIn')
	$('#regalo').prop('checked', carrito.regalo)

	Object.keys(carrito).forEach(e => {
		if ($('#checkoutform').find(`input[name='${e}']`).length) {
			$('#checkoutform').find(`input[name='${e}']`).val(carrito[e])
		}
		if ($(`.${e}`).length) {
			let value = carrito[e]
			if (typeof value === 'number') {
				value = formatNumber(value)	
			}
			$(`.${e}`).html(value)
		}
	})

	if(lastpm) {
		setTimeout(() => {
			$('#'+lastpm).click()
		}, 100)
		// $('input[name=payment_method]').val(lastpm)
	}
	if (carrito.cargo === 'takeaway') {
		$('.cargo-takeaway').removeClass('hide')
		$('.cargo-takeaway').addClass('animated fadeIn')
	}

	if (carrito.cargo === 'shipment') {
		var price = ''
		if (carrito.freeShipping) {
			price = '<span class="text-success">Gratis</span>'
		} else {
			price = `$${formatNumber(carrito.shipping_price)}`
		}
		$('.shipping_price').html(price)
		$('.shipping-block').removeClass('hide')
		$('.shipping-block').addClass('animated fadeIn')
	}

	if(!carrito.coupon) {
		$('.coupon-actions-block').removeClass('hide')
		$('.coupon-actions-block').addClass('animated fadeIn')
	} else {
		$('.coupon-block').removeClass('hide')
		$('.coupon-block').addClass('animated fadeIn')
	}

	if (bank.enable && bank.discount_enable && bank.discount) {
		setTimeout(() => {
  		onSuccessAlert('Pagá con CBU/Alias', `Y obtené un ${bank.discount}% de descuento en tu compra`);		
  	}, 2000)
	}

	$('#checkoutform').submit(form => {
		const submit = $('.checkout-btn')
		submit.prop('disabled', true)
		submit.addClass('disabled')
		submit.text('Por favor espere...')

		localStorage.removeItem('carrito')
		fbq('track', 'InitiateCheckout')
		let items = []
		if(carrito_items && carrito_items.length) {
			carrito_items.forEach(e => {
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
		/*
	  dataLayer.push({
	    'event': 'checkout',
	    'ecommerce': {
	      'checkout': {
	        'actionField': {'step': 1, 'option': 'Visa'},
	        'products': products
	      }
	    },
	    'eventCallback': function() {
	      return true
	    }
	  })*/
	//Events
	/* $('[name="provincia"]').change(function(event){
		var province_id 	= $(this).find('option:selected').data('id');
		var province_name 	= $(this).find('option:selected').html();
		var url 			= $(this).data('url');
		$('[name="localidad"]').empty();

		if(province_id){
			$.ajax({
				url: url+'/'+province_id,
				type: 'GET',
				dataType: 'json',
				data: {},
			})
			.done(function(data) {
				$.each(data, function(index, localidad) {
					$('[name="localidad"]').append('<option value="'+localidad.localidad+'">'+localidad.localidad+'</option>');
				});
				if(data.length == 0 && province_name){
					$('[name="localidad"]').append('<option value="'+province_name+'">'+province_name+'</option>');
				}
			});
		}
	}); */	
	})
});