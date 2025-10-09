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
	$('.btn-filter-calendar').on('click', function(e) {
		clearTimeout(clock)
		clock = setTimeout(() => {
			let t = $(e.target)
			if(!t.hasClass('btn-filter-calendar')){
				t = $(t).parents('.btn-filter-calendar')
			}
			let cls = 'btn-success'
			let period = 'month'
			let label = 'último mes'
			if(t.hasClass('btn-success')) {
				cls = 'btn-info'
				period = 'year'
				label = 'último año'
			}
			if(t.hasClass('btn-info')) {
				cls = 'btn-warning'
				period = 'start'
				label = 'siempre'
			}
			t.removeClass('btn-info btn-warning btn-success')
			t.addClass(cls)
			t.find('span:first').text(label)
			mis_compras(period)
		}, 200)
	})

	mis_compras('month',1)
})