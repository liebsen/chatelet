	$(document).ready(function() {		
		$.get('/mailchimp/lists').then(res1 => {
			$.get('/mailchimp/stores').then(res2 => {
				const selects = document.querySelectorAll('.mc-select') || []
				selects.forEach(e => {
					const type = e.getAttribute('data-type') || ''
					const selected = e.getAttribute('data-selected') || ''
					let str = ''
					if(type == 'list') {
						for(var i in res1.lists) {
							const list = res1.lists[i]
							console.log('list', list)
							const sel = list.id == selected ? ' selected' : ''
							str+= `<option value="${list.id}"${sel}>${list.name}</option>`	
						}
						e.innerHTML = str
					}
					if(type == 'store') {
						for(var i in res2.stores) {
							const store = res2.stores[i]
							const sel = store.id == selected ? ' selected' : ''
							str+= `<option value="${store.id}"${sel}>${store.name}</option>`	
						}
						e.innerHTML = str
					}
				})

				setTimeout(function(){
					console.log('ready')
					$('button[type="submit"]').prop('disabled', false)
				}, 1000)
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