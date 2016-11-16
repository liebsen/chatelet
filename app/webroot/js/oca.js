$(function(){
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


	var timeout = null;
	$('#cp').change(function(event){
		event.preventDefault();
		var url = $(this).data('url');
		var cp 	= $('#cp').val();
		callStart();		
		$.getJSON( url+'/'+cp , function(json, textStatus) {
			callEnd();
			clearTimeout(timeout);
			console.log(json);
			if( json.valid ){
				$('#cost').text( parseInt(json.price) );
				console.log(parseFloat($('#cost').text()));	
				$('#cp').removeClass('wrong');
				$('#cp').addClass('ok');
				onSuccessAlert('Codigo Valido');
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
		if( !a || !b || !c || 1>parseFloat($('#cost').text()) ){
			$('#cp').focus();
			$('#cp').removeClass('ok');
			$('#cp').addClass('wrong');
			return false;
		}else{
			window.location.href = $(this).attr('link-to')||$(this).prop('link-to');
		}

	});
});