$(document).ready(function() {
	var mis_compras = (period, assureContent) => {
		console.log('mis_compras',period, assureContent)
		let days = 1
		let size = 0 

		if(period == 'month') {
			days = 30
		}

		if(period == 'year') {
			days = 365
		}

		const label = $(`option[value="${period}"]`).text();
		$('.history-items').each((i,row) => {
			const ts = $(row).find('.timestamp').text()
			const date = new Date(ts)
			let then = new Date()
			then.setDate(then.getDate() - days);
			const diff = new Date(date.toDateString()) > new Date(then);
			if(diff || period == 'start') {
				size++
				$(row).show()
			} else {
				$(row).hide()
			}
		})

		setTimeout(() => {
			if(!size) {
				$('.compras-size-message').html(`No registras compras para el periodo ${label}. <a href="javascript:void(0)" class="compras-all">Ver el historial completo</a>`)
			} else {
				$('.compras-size-message').html(`Registras ${size} compra${size > 1 ? 's' : ''} en el periodo ${label}`)
			}
			$('.btn-filter-calendar').val(period)
		}, 100);

		if($('.history-items').length && assureContent && size == 0) {
			return $('.btn-filter-calendar').click()
		}

		setTimeout(() => {
			const len = $('.history-items:visible').length
			$('.btn-filter-calendar span:first').append(` (${len})`)			
		}, 100)
	}

	let clock = 0

	$(document).on('click', '.compras-all', function(e) {
		mis_compras('start')
	})

	$('.btn-filter-calendar').on('change', function(e) {
		clearTimeout(clock)
		clock = setTimeout(() => {
			mis_compras($(this).val())
		}, 100)
	})

	mis_compras('day',1)
})