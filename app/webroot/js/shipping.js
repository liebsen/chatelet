$(function(){
	var subtotal = $('#subtotal_compra').val();
	var timeout = null;
	var timeout2 = null;

	callStart = function(){
		setTimeout(() => {
			$('#cost_container').removeClass('text-muted', 'text-success');
			$('#cost_container').addClass('hide');
			$('#loading').removeClass('hide');
		}, 50)
	}

	callEnd = function(){
		cargo = 'shipment'
		$('.shipping-loading').removeClass('animated fadeOut');
		$('#cost_container').removeClass('animated fadeIn');
		setTimeout(() => {
			$('.shipping-loading').addClass('animated fadeOut');		
			$('#cost_container').addClass('animated fadeIn');
		}, 1)
		setTimeout(() => {
			$('#cost_container').removeClass('hide');
			$('.shipping-loading').addClass('hide');
			$('#cost_container').addClass('text-success');
		}, 500)
	}

	onErrorAlert = function(title, text){
		$('#growls').remove();
		$.growl.error({
			title: title || 'Error',
			message: text
		});
	}

	onSuccessAlert = function(title, text){
		$('#growls').remove();
		$.growl.notice({
			title: title || 'OK',
			message: text
		});
	}

	formatNumber = function (num) {
	  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
	}

	isDateBeforeToday = function(date) {
	  return new Date(date.toDateString()) < new Date(new Date().toDateString());
	}

	selectShipping = function (e, cargo, cost) {
		var coupon = parseInt(document.querySelector('.coupon_bonus').textContent) || 0
		if (cost <= 0) {
			return setTimeout( "onErrorAlert('El servicio de oca no está disponible en este momento, intente en unos instantes.')" , 200);
		}

		$('.shipping-options li').removeClass('selected')
		$(e).addClass('selected')
		$('.delivery-cost').removeClass('hidden')
		$('.delivery-cost').addClass('fadeIn')
		$('#subtotal_envio').val(cost);
		$('.cost_delivery').text( formatNumber(cost));		
		$('.shipping-cargo').text(cargo)	

		let total = formatNumber(parseFloat($('#subtotal_compra').val()) + cost - coupon)
		fxTotal(total)
		onSuccessAlert(cargo.toUpperCase(), `Usted seleccionó ${cargo.toUpperCase()} como servicio de entrega`);
	}

	$('.input-cp').keyup(function(event){
	  event.preventDefault()
		if (timeout2) {
			clearTimeout(timeout2)
		}

		var url = $(this).data('url')
		var total_orig = $('#subtotal_compra').val()
		var cp 	= $('.input-cp').val();
		
		document.querySelector('.shipping-block').classList.add('hidden')

		$('.input-cp').removeClass('ok');				
		$('.delivery-cost').addClass('hidden')
		$('.takeaway-options li').removeClass('selected')

		if(cp.trim() === '') {
			return false
		}

		timeout2 = setTimeout(function () {
			var cost = 0
			$('#free_delivery').text('');
			$('.delivery-cost').addClass('hidden')
			callStart();
			$.getJSON( url+'/'+cp , function(json, textStatus) {
				callEnd();
				clearTimeout(timeout);
				if( json.rates ){
					$('.products-total').removeClass('hidden')
					//free delivery
					if (json.freeShipping){  
						console.log('Envio gratis!')
						// $('#subtotal_envio').val( 0 );
						// $('#free_delivery').text('Envio gratis!');
					}else{
						if (json.rates) {
							var rates = `<ul class="generic-select shipping-options animated zoomInRight">`
							Object.keys(json.rates).forEach(cargo => {
								const price = json.rates[cargo].price
								rates+= `<li shipping="${cargo}" onclick="selectShipping(this, '${cargo}',${parseInt(price)})"><div class="shipping-logo" style="background-image: url(/images/${cargo}.svg)"><span class="text-uppercase">$${price}</span></div></li>`
							})
							rates+= `</ul>`
							document.querySelector('.shipping-block .slot').innerHTML = rates
							$('#delivery_cp').html( `<span class="shipping-cargo is-capitalize"></span> (${cp})` );
							localStorage.setItem('lastcp', cp)		
							setTimeout(() => {
								$('.input-cp').removeClass('wrong');
								$('.input-cp').addClass('ok');
								onSuccessAlert(cp, 'Codigo Postal válido ✓');
								document.querySelector('.shipping-block').classList.remove('hidden')	
							}, 750)
						} else {
							timeout = setTimeout( "onErrorAlert('Error al solicitar cotizacion. Por favor intente otra vez en unos instantes.')" , 200);
						}
					}
				} else {
					$('.input-cp').addClass('wrong');
					$('#cost').text( parseInt(0) );
					let total = formatNumber(parseFloat($('#subtotal_compra').val()) - coupon)
					fxTotal(formatNumber(total))
					timeout = setTimeout( "onErrorAlert('Codigo Postal inexistente')" , 200);
				}
				$('.input-cp').attr( 'data-valid' , parseInt(json.valid) );
			});
		}, 2000)
	});

	if ($('.input-cp').val()) {
		$('.input-cp').keyup()
	}
});

window.onerror = function (msg, url, lineNo, columnNo, error) {
  onErrorAlert(`${msg}:${lineNo}`);
}
