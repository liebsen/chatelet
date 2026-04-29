
	$(document).ready(function() {
		$('#toggle').click(e => {
			if($(e.target).is(':checked')){
				$('.show-panel').removeClass('show-inactive')
			} else {
				$('.show-panel').addClass('show-inactive')
			}
		})
	})
