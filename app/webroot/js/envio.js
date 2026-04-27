selectShipping = function (e, shipping, cost) {
	var total = 0
	var coupon_benefits = cart_totals.coupon_benefits || 0
	var total_products = cart_totals.total_products || 0
	var grand_total = cart_totals.grand_total || 0
	const shipping_price = parseInt(settings.shipping_price_min)

	$('.shipping-options li').removeClass('selected secondary')
	$('.takeaway-options li').removeClass('selected secondary')
	$('.shipping-options li').addClass('secondary')
	$(e).addClass('selected')
	$('.delivery-cost').addClass('hidden')
	$('.shipping-cargo').text(shipping.toUpperCase())	
	
	total = total_products - coupon_benefits

	if (!cart_totals.free_shipping) {
		total += cost
		$('#subtotal_envio').val(cost)
		$('.delivery-cost').removeClass('hidden')
		$('.delivery-cost').addClass('fadeIn')
		if(cost) {
			$('.cost_delivery').text( "$ " + formatNumber(cost))
		} else {
			$('.cost_delivery').text('Gratis')
		}
	}

	$('.takeaway-text').addClass('hidden')
	$('.delivery-cost').removeClass('hidden')
	$('.cost_total').text('$ ' + formatNumber(total))

	total = formatNumber(total)
	let info = $(e).data('info')

	var cp_input = $('.input-cp').val().trim()
	var cp = parseInt(cp_input)

	$('.paying-with').delay(1000).fadeIn()
	$('.checkout-continue').fadeIn()
	$('input[name="shipping"]').val(shipping)
	$('input[name="cargo"]').val('shipment')
	$('input[name="postal_address"]').val(cp)
	localStorage.setItem('cargo', 'delivery')
	localStorage.setItem('delivery_select', shipping)

	handleTotals(total)
	handleSubtotal(total)
	manageHiddenFields()	
}

selectStore = function(e) {
	$('.takeaway-options li').removeClass('selected secondary')
	$('.shipping-options li').removeClass('selected secondary')
	$('.takeaway-options li').addClass('secondary')
	$('.free-shipping').addClass('hidden')
	$('#cost_container').html('')
	$('.takeaway-text').removeClass('hidden')
	$(e).addClass('selected')
  $('.delivery-cost').addClass('hidden')
  $('.map-block').removeClass('hidden')

  const store = $(e).attr('store')
  const store_address = $(e).attr('store-address')
  const total_products = cart_totals.total_products 
  const coupon_benefits = cart_totals.coupon_benefits || 0 
  format_total = formatNumber(total_products - coupon_benefits)

  const storeProps = [
  	'store', 
  	'store-address', 
  	'store-lat', 
  	'store-lng'
  ]

  let storeJSON = {}
  storeProps.forEach((i,j) => {
  	storeJSON[i] = $(e).attr(i)
  })

  var cart_takeaway_text = $('.cart_takeaway_text').text()
  const suc = e.textContent.split(' ')[0]

  localStorage.cargo = 'takeaway'
  localStorage.takeaway_store = JSON.stringify(storeJSON)

  $('.takeaway-indicate').text([store_address,store].join(', '))
  $('.checkout-continue').fadeIn()
	$('input[name="shipping"]').val("")
  $('input[name="cargo"]').val('takeaway')
  $('input[name="store"]').val(store)
  $('input[name="store_address"]').val(store_address)
  $('input[name="postal_address"]').val("")

  handleTotals(format_total)
  handleSubtotal(format_total)
  manageHiddenFields()
  initMap(e)  
}

manageHiddenFields = function() {
	setTimeout(function(){
		$('#envio_form input[data-attr="required"], #envio_form select[data-attr="required"]').each((a,i) => {
			$(i).prop('required', $(i).is(':visible'))
		})
	}, 500)
}

initMap = function(option) {
	const store = $(option).attr('store')
	const store_lng = $(option).attr('store-lng')
	const store_lat = $(option).attr('store-lat')
	const store_address = $(option).attr('store-address')

	$('.store').text(store)
	$('.store-address').text(store_address)

  var latlng = new google.maps.LatLng(store_lat, store_lng);  
  var myOptions = {
    zoom: 15,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  var marker = new google.maps.Marker({
  	position:latlng, 
  	map:map,
  	title:store + ' ' + store_address
  });
}

$(document).ready(function() {
	localStorage.setItem('continue_shopping_url', window.location.pathname)

  $('#envio_form').on('submit', function(event) {
    event.preventDefault();
    const tab = $('#envio_form .nav-tabs li.active').find('a').attr('href')

  	if(tab == '#envio'){
  		if(!$('.input-cp').val()) {
  			return onWarningAlert('Importante', 'Por favor ingrese un código postal')
  		}
	    if(!$('input[name="shipping"]').val()) {
	    	return onWarningAlert('Importante', 'Por favor seleccione un método de entrega')
	    }
  	}

  	if(tab == '#retiro'){
  		if(!$('.takeaway-options li.selected').length) {
  			return onWarningAlert('Importante', 'Por favor selecione un local para retirar el producto')
  		}
  	}
    	
    const formData = $('#envio_form :input:visible, #envio_form input[type="hidden"]').serialize();
    // const formSerialized = $(this).serializeArray();
    const btnSubmit = $(this).find('[type="submit"]');
    const redirect = $(this).find('[name="redirect"]').val();

    btnSubmit.prop('disabled', true)
    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: formData,
      success: function(res) {
      	if(res.success) {
          setTimeout(() => {
          	location.href = redirect || location.href
          }, 100)
      	} else {
      		onWarningAlert('Error al enviar datos', res.errors)
      	}
      	btnSubmit.prop('disabled', false)
      },
      error: function(xhr, status, error) {
        console.error("Error al enviar datos: " + status + " - " + error);
        btnSubmit.prop('disabled', false)
        // Handle errors
      }
    });
  });

	/* metrics start */
	fbq('track', 'InitiateCheckout')
	let items = []
	if(cart_items && cart_items.length) {
		cart_items.forEach(e => {
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

	/* metrics end */
	
	$('.btn-calculate-shipping').click(e => {
		$('.btn-calculate-shipping').prop('disabled', true)
		$('.btn-calculate-shipping').button('loading')

		var url = $(this).data('url')
		var cp_input = $('.input-cp').val().trim()
		var cp = parseInt(cp_input)
		var cost = 0
		var coupon = $('.coupon_bonus') ? 
			$('.coupon_bonus').text().split('.').join('').split(',').join('.') : 
			cart.coupon_bonus || 0
		var subtotal = cart_totals.total_products || 0

		document.querySelector('.shipping-block').classList.add('hidden')

		$('.input-cp').removeClass('ok');				
		$('.delivery-cost').addClass('hidden')

		if(cp_input == '' || cp < 1000 || cp > 9999) {
			onErrorAlert('Código postal inválido', `Por favor ingresá un código postal válido`);
			return false
		}

		$('#free_delivery').text('');
		$.getJSON( '/checkout/deliveryCost/'+cp , function(json, textStatus) {
			$('.btn-calculate-shipping').button('reset')
			$('.btn-calculate-shipping').prop('disabled', false)
			if( json.rates.length ){
				var rates = `<ul class="generic-select shipping-options">`
				json.rates.forEach(rate => {
					if (!isNaN(rate.price)) {
						var price_html = '<span class="text-success text-bold">Gratis</span>'
						if (!cart_totals.free_shipping) {
							price_html = `<span class="text-uppercase">$ ${formatNumber(parseInt(rate.price))}</span>`
						}
						rates+= `<li shipping="${rate.code}" data-info="${rate.info}" onclick="selectShipping(this, '${rate.code}',${parseInt(rate.price)})"><div class="shipping-logo" style="background-image: url('${rate.image}')">${price_html}</div></li>`
					}
				})
				rates+= `</ul>`
				document.querySelector('.shipping-block .slot').innerHTML = rates
				localStorage.lastcp = cp	
				$('#postal_address').val(cp)
				setTimeout(() => {
					$('.input-status').removeClass('wrong');
					$('.input-status').addClass('ok');
					// onSuccessAlert(`Como querés recibir tu compra`,'Ingresaste código postal ' + cp, 0, true);
					document.querySelector('.shipping-block').classList.remove('hidden')	
					if (localStorage.cargo === 'delivery' && localStorage.delivery_select) {
						$(`.shipping-options li[shipping="${localStorage.delivery_select}"]`).click()
					} else {
						$('#postal_address').val(cp)
						$('input[name="postal_address"]').val(cp)
						if (json.rates.length === 1) {
							$(`.shipping-options li:first-child`).click()
						}
					}
				}, 500)
			} else {
				$('.input-status').removeClass('ok');
				$('.input-status').addClass('wrong');
				setTimeout( "onErrorAlert('Sin cobertura en esta zona', 'El código postal es correcto pero no disponemos de servicio de entrega para tu área.')", 200)
			}
			$('.has-checkout-steps').addClass('done')
			$('.input-cp').attr( 'data-valid' , json.rates.length );
			$('.btn-calculate-shipping').button('reset')
		})
		return false
	})

	$(document).on('click', 'a[href="#retiro"]', function(e){
		$('.map-block').addClass('hidden')
	})

	$(document).on('click', 'a[href="#envio"]', function(e){
		const cp = $('.input-cp')
		if(!cp.val() || cp.val() == '') {
			if(localStorage.lastcp) {
				cp.val(localStorage.lastcp)	
			}
		}
	})

	const takeaway_store = localStorage.takeaway_store && localStorage.takeaway_store != 'undefined' ? 
		JSON.parse(localStorage.takeaway_store) : 
		[]

	if (localStorage.getItem('cargo') === 'takeaway' && Object.keys(takeaway_store)?.length && !location.hash.includes('shipment-options.shipping')) {
		setTimeout(() => {
			$('a[href="#retiro"]').click()
			$('.has-checkout-steps').addClass('done')
			$(`.takeaway-options li[store="${takeaway_store.store}"]`).click()
		}, 100)
	}

	if (localStorage.cargo === 'delivery' && localStorage.lastcp) {
		setTimeout(() => {
			$('a[href="#envio"]').click()
			$('.input-cp').val(localStorage.lastcp)
			$('.btn-calculate-shipping').click()
			$('.has-checkout-steps').addClass('done')
		}, 100)
	} else {
		$('.has-checkout-steps').addClass('done')
	}
})