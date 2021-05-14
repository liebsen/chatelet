function isDateBeforeToday(date) {
    return new Date(date.toDateString()) < new Date(new Date().toDateString());
}
$(function(){
	var subtotal = $('#subtotal_compra').val();

	callStart = function(){
		$('#cost_container').addClass('hide');
		$('#loading').removeClass('hide');
	}

	callEnd = function(){
		$('#loading').addClass('hide');
		$('#cost_container').removeClass('hide');
	}

	onErrorAlert = function(text){
		$('#growls').remove();
		$.growl.error({
			title: 'Error',
			message: text
		});
	}

	onSuccessAlert = function(text){
		$('#growls').remove();
		$.growl.notice({
			title: 'OK',
			message: text
		});
	}

	formatNumber = function (num) {
	  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
	}

	var timeout = null;
	var timeout2 = null;
	$('#cp').keyup(function(event){
		if (timeout2) {
			clearTimeout(timeout2)
		}
		let t = this
	    event.preventDefault();
		timeout2 = setTimeout(function () {
			var url = $(t).data('url');
			var cp 	= $('#cp').val();
			$('#free_delivery').text('');
			callStart();
			$.getJSON( url+'/'+cp , function(json, textStatus) {
				callEnd();
				clearTimeout(timeout);
				if( json.valid ){
					if (!json.price || parseInt(json.price) == 0){
						json.price = 114;
					}
					//free delivery
					if (json.freeShipping){  
						// console.log('Envio gratis');
						$('#cost').text( 0 );
						$('#free_delivery').text('Envio gratis!');
					}else{
						let cost = parseInt(json.price)
						let total = formatNumber(parseFloat($('#subtotal_compra').val()) + cost)

						$('#cost').text( cost );
						$('#cost_total').text( total )
						$('.cost_total').removeClass('hidden').css({opacity: 0}).fadeTo('slow', 1)
					}
					// console.log(parseFloat($('#cost').text()));
					$('#cp').removeClass('wrong');
					$('#cp').addClass('ok');
					onSuccessAlert('Codigo Postal válido');
				}else{
					$('#cp').removeClass('ok');
					$('#cp').addClass('wrong');
					$('#cost').text( parseInt(0) );
					timeout = setTimeout( "onErrorAlert('Codigo Postal inexistente.')" , 200);
				}
				$('#cp').attr( 'data-valid' , parseInt(json.valid) );
			});
		}, 2000)
	});

	$('#siguiente').click(function(event){
		event.preventDefault();
		var c = $('[product_row]').length;
		let location = $(this).attr('link-to')||$(this).prop('link-to')

		if(!c){
			onErrorAlert('No tienes productos en el carrito');	
			return false;
		}

		if ($('.shipment').is(':visible')) {
			var a = $('#cp').val();
			var b = parseInt($('#cp').attr('data-valid'));
			// if((!a || !b || !c || (1>parseFloat($('#cost').text()) && !freeShipping ))){ // && isDateBeforeToday(new Date(2019, 11, 4)) )) {
			if(!a || !b || !c){ // && isDateBeforeToday(new Date(2019, 11, 4)) )) {
				$('#cp').focus();
				$('#cp').removeClass('ok');
				$('#cp').addClass('wrong');
				onErrorAlert('Por favor ingrese su código postal');
				return false;
			}else{
				location+= '?cargo=shipment'
			}
		} else if($('.takeaway').is(':visible')) {
			const selected = $('.takeaway-options li.selected')
			if (!selected.length) {
				onErrorAlert('Por favor seleccione una sucursar para pasar a retirar el producto');	
				return false;
			} else {
				const store_id = selected.attr('store-id')
				const store_address = selected.attr('store-address')
				if (store_id) {
					location+= '?cargo=takeaway&store=' + store_id + '&store_address=' + store_address
				}
			}
		} else {
			onErrorAlert('Por favor indique su código postal o seleccione retiro en sucursal');
			return false;
		}

		if ($('#ticket_cambio').is(':checked')) {
			location+= '&ticket=1'
		}
		window.location.href = location;
	});

	if ($('#cp').val()) {
		$('#cp').keyup()
	}
});

window.onerror = function (msg, url, lineNo, columnNo, error) {
  onErrorAlert(`${msg}:${lineNo}`);
}
