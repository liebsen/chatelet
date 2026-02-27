	$(document).ready(function() {		
		$('.mc-action').click(function(e){
			e.preventDefault()
			const name = this.getAttribute('data-method') || ''
			document.querySelector('.iframe').classList.remove('d-none')
			document.getElementById('mailchimp').src = `/mailchimp/${name}`
			return false;
		})
	})