
	$(document).ready(function() {
		$('[name="data[whatsapp_enabled]"]').click(e => {
			if(e.target.value == '1'){
				$('.show-panel').removeClass('show-inactive')
			} else {
				$('.show-panel').addClass('show-inactive')
			}
		})
	})
