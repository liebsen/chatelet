var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
var select_payment = (e) => {
	var selected = $(e).find(':checked').val()
	var subtotal = carrito.subtotal_price
	var bank_bonus = 0
	if (selected === 'bank' && bank.enable && bank.discount_enable && bank.discount) {
		bank_bonus = subtotal * (parseFloat(bank.discount) / 100)
		$('.bank_bonus').text(bank_bonus.toFixed(2))
		$('.bank-block').removeClass('hide')
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
  console.log('subtotal',subtotal)
  console.log('total',total)
  console.log('bank_bonus',bank_bonus)

	$('.total_price').text(total.toFixed(2))
	$('.payment-method .option-rounded').removeClass('is-selected')
	$(e).addClass('is-selected')
}

$(function(){

	$(`.cargo-${carrito.cargo}`).removeClass('hide')
	$('#regalo').prop('checked', carrito.regalo)

	Object.keys(carrito).forEach(e => {
		if ($(`.${e}`).length) {
			if ($('#checkoutform').find(`input[name='${e}']`).length) {
				$('#checkoutform').find(`input[name='${e}']`).val(carrito[e])
			}
			if ($(`.${e}`)) {
				$(`.${e}`).html(carrito[e])
			}
		}
	})

	if (carrito.cargo === 'takeaway') {
		$('.cargo-takeaway').removeClass('hide')
	}

	if (carrito.cargo === 'shipment') {
		var price = ''
		if (carrito.freeShipping) {
			price = '<span class="text-success">Gratis</span>'
		} else {
			price = `$${carrito.shipping_price}`
		}
		$('.shipping_price').html(price)
		$('.shipping-block').removeClass('hide')
	}

	if(!carrito.coupon) {
		$('.coupon-actions-block').removeClass('hide')
	}

	if (bank.enable && bank.discount_enable && bank.discount) {
		setTimeout(() => {
  		onSuccessAlert('Pagá con CBU/Alias', `Y obtené un ${bank.discount}% de descuento en tu compra`);		
  	}, 2000)
	}

	//$('body').on('click touchstart', '.payment-method .option-rounded', e => {
	//$('.payment-method .option-rounded').click(e => {

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