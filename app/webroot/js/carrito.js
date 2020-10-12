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
	$('.trash').on('click', e => {
		e.preventDefault()
		if (confirm('Estás seguro que que querés borrar este producto del carrito?')) {
			const target = $(e.target).closest('.trash')

		  $.get(target.attr('href'), res => {

		  	let item = JSON.parse(res)
				fbq('track', 'RemoveFromCart')
				/* @Analytics: removeFromCart */
				dataLayer.push({
				  'event': 'removeFromCart',
				  'ecommerce': {
				    'remove': {                               // 'remove' actionFieldObject measures.
				      'products': [{                          //  removing a product to a shopping cart.
				          'name': item.article,
				          'id': item.id,
				          'price': item.discount,
				          'brand': item.name,
				          // 'category': 'Apparel',
				          'variant': item.alias,
				          'quantity': 1
				      }]
				    }
				  },
					'eventCallback': function() {
       			// document.location = productObj.url
       			location.href = '/carrito'
     			}
				});				
			})
		}
	})
});