
	$(document).ready(function() {
		$('#toggle2').click(e => {
			if($(e.target).is(':checked')){
				$('.target2').css('display','block')
			} else {
				$('.target2').css('display','none')
			}
		})
	})
