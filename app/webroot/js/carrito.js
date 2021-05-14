	var selectStore = e => {
		$('.takeaway-options li').removeClass('selected')
		$(e).addClass('selected')
		console.log($(e))
	}

$(document).ready(function() {
	$('.swap').on('click', function() {
		const target = $(this).attr('swap-target')
		$('.shipment-options').addClass('hide')
		$(`.${target}`).removeClass('hide')
		if(target === 'takeaway' && !$('.takeaway-loading').hasClass('hide')) {
			$.get('/carrito/takeaway_stores', res => {
				$(res).each((i, item) => {
					console.log(item, i)
					$('.takeaway-options').append(`<li store-id="${item.Store.id}" store-address="${item.Store.name}, ${item.Store.address}" onclick="selectStore(this)">${item.Store.name} - ${item.Store.address}</li>`)
				})
				$('.takeaway-loading').addClass('hide')
			})
		}
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
});