$(document).ready(function() {
	$('#flashMessage').each(function(i, flash) {
		flash = $(flash);
		console.log(flash)
		if (flash.hasClass('error')) {
			$.growl.error({
				title: flash.text()
			});
		}

		if (flash.hasClass('notice')) {
			$.growl.notice({
				title: flash.text()
			});
		}

		if (flash.hasClass('warning')) {
			$.growl.warning({
				message: flash.text()				
			});
		}

		flash.remove();
	});

	$('.gotocart').click(() => {
		location.href = '/carrito'
	})
	
	$('.dropdown-menu').click(function(e) {
		var target = $(e.target);

		if (target.is('a') || target.parent().is('a') || target.is('input[type="submit"]')) {
			return true;
		}

		return false;
	});
	if (typeof $.fn.datepicker != 'undefined'){ 
		$('.datepicker').datepicker({
			format: $(this).data('format') || 'dd/mm/yyyy',
			language: 'es'
		});
	}
	//$('.selectpicker').selectpicker();

	$('#registro-modal a[data-toggle="modal"]').click(function() {
		$(this).parents('#registro-modal').modal('hide');
		return true;
	});
});
