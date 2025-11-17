$(document).ready(function() {
	var mis_compras = (period, assureContent) => {
		let days = 30
		
		if(period == 'year') {
			days = 365
		}

		let size = 0 
		$('.ch-row').each((i,row) => {
			const ts = $(row).find('.timestamp').text()
			const then = new Date(ts)
			let next = new Date()
			next.setDate(then.getDate()-days);
			const diff = new Date(then.toDateString()) > new Date(next);
			if(diff || period == 'start') {
				size++
				$(row).show()
			} else {
				$(row).hide()
			}
		})

		if($('.ch-row').length && assureContent && size == 0) {
			return $('.btn-filter-calendar').click()
		}

		setTimeout(() => {
			const len = $('.ch-row:visible').length
			$('.btn-filter-calendar span:first').append(` (${len})`)			
		}, 100)
	}

	let clock = 0

	$('.btn-filter-calendar').on('change', function(e) {
		clearTimeout(clock)
		clock = setTimeout(() => {
			mis_compras($(this).val())
		}, 100)
	})

	mis_compras('month',1)
})