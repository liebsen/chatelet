function toggleform() {
	$('.checkoutform-container').toggleClass('hide')
	focusEl('.checkoutform-container')
}

$(function(){
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

	var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
	$(`.cargo-${carrito.cargo}`).removeClass('hide')
	$('#regalo').prop('checked', carrito.regalo)
	//$('.store-address').text([carrito.store, carrito.store_address].join(', '))
	//$('.shipping-text').text([carrito.shipping, carrito.shipping_price].join(', '))
	Object.keys(carrito).forEach(key => {
		if ($(`.${key}`).length) {
			var text = carrito[key]
			if (key === 'shipping_price') {
				if (carrito.freeShipping) {
					text = '<span class="text-success">Gratis</span>'
				} else {
					text = `$${text}`
				}
			}
			$(`.${key}`).html(text)
		}
		if ($('#checkoutform').find(`input[name='${key}']`).length) {
			$('#checkoutform').find(`input[name='${key}']`).val(carrito[key])
		}
	})

	$('.payment-method input[type=radio]').click(e => {
		$('.payment-method .option-rounded').removeClass('is-selected')
		$(e.target).parent().addClass('is-selected')
	})
	$('#checkoutform').submit(form => {
		const submit = $('.checkout-btn')
		submit.prop('disabled', true)
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
	})
});