$(document).ready(function() {
	$('#flashMessage').each(function(i, flash) {
		flash = $(flash);
		if (flash.hasClass('error')) {
			$.growl.error({
				title: '',
				message: flash.text()
			});
		}

		if (flash.hasClass('notice')) {
			$.growl.notice({
				title: '',
				message: flash.text()
			});
		}

		if (flash.hasClass('warning')) {
			$.growl.warning({
				title: '',
				message: flash.text()
			});
		}

		flash.remove();
	});

	$('.dropdown-menu').click(function(e) {
		var target = $(e.target);

		if (target.is('a') || target.parent().is('a') || target.is('input[type="submit"]')) {
			return true;
		}

		return false;
	});
	if (typeof $.fn.datepicker != 'undefined'){ 
	$('.datepicker').datepicker({
		format: 'dd/mm/yyyy'
	});
	}
	//$('.selectpicker').selectpicker();

	$('#registro-modal a[data-toggle="modal"]').click(function() {
		$(this).parents('#registro-modal').modal('hide');
		return true;
	});
});
