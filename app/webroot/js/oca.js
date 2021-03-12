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
	$('#cp').change(function(event){
    event.preventDefault();
		var url = $(this).data('url');
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
				if (freeShipping){  
					console.log('Envio gratis');
					$('#cost').text( 0 );
					$('#free_delivery').text('Envío gratis!');
				}else{
					let cost = parseInt(json.price)
					let total = formatNumber(parseFloat($('#subtotal_compra').val()) + cost)

					$('#cost').text( cost );
					$('#cost_total').text( total )
					$('.cost_total').removeClass('hidden').css({opacity: 0}).fadeTo('slow', 1)
				}
				console.log(parseFloat($('#cost').text()));
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
	});

	$('#siguiente').click(function(event){
		event.preventDefault();
		var a = $('#cp').val();
		var b = parseInt($('#cp').attr('data-valid'));
		var c = $('[product_row]').length;
		if(!c){
			onErrorAlert('No tienes productos en el carrito.');
			return false;
		}
		// free delivery
		if((!a || !b || !c || (1>parseFloat($('#cost').text()) && !freeShipping ))){ // && isDateBeforeToday(new Date(2019, 11, 4)) )) {
			$('#cp').focus();
			$('#cp').removeClass('ok');
			$('#cp').addClass('wrong');
			return false;
		}else{
			let location = $(this).attr('link-to')||$(this).prop('link-to')
			if ($('#ticket_cambio').is(':checked')) {
				location+= '?ticket=1'
			}
			window.location.href = location;
		}

	});
});
