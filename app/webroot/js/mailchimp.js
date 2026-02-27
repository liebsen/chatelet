	$(document).ready(function() {		
		const lists = $.get('/mailchimp/lists').then(lists => {
			const stores = $.get('/mailchimp/stores').then(stores => {
				const selects = document.querySelectorAll('.mc-select') || []
				selects.forEach(e => {
					const type = e.getAttribute('data-type') || ''
					const selected = e.getAttribute('data-selected') || ''
					let str = ''
					if(type == 'store') {
						for(var i in stores) {
							const store = stores[i]
							const sel = store.id == selected ? ' selected' : ''
							str+= `<option value="${store.id}"${sel}>${store.name}</option>`	
						}
						e.innerHTML = str
					}
					if(type == 'list') {
						for(var i in lists) {
							const list = lists[i]
							const sel = list.id == selected ? ' selected' : ''
							str+= `<option value="${list.id}"${sel}>${list.name}</option>`	
						}
						e.innerHTML = str
					}
				})
			})
		})

		$('.mc-action').click(function(e){
			e.preventDefault()
			const name = this.getAttribute('data-method') || ''
			document.querySelector('.iframe').classList.remove('d-none')
			document.getElementById('mailchimp').src = `/mailchimp/${name}`
			return false;
		})
	})