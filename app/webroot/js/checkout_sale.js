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

	$('#checkoutform').submit(form => {
		const submit = $(form.target).find('input[type="submit"]').first()
		submit.prop('disabled', true)
		submit.val('Por favor espere...')

		fbq('track', 'InitiateCheckout')
		let products = []
		carrito.forEach(e => {
			products.push({
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
		  "items": products,
		  "coupon": ""
		})
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