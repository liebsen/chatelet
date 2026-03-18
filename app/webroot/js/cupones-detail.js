$(document).ready(function() {

	let clock = 0
	$('#products-filter').keyup(function(e){
		clearTimeout(clock)
		const value = $(e.target).val().toUpperCase()
		clock = setTimeout(() => {
			$('.product-item').each((j,i) => {
				if(!$(i).hasClass('is-enabled')){
					if($(i).text().toUpperCase().includes(value)) {
						$(i).removeClass('hidden')
					} else {
						$(i).addClass('hidden')
					}
				}
			})
		}, 500)
	})
	$('#categories-filter').keyup(function(e){
		clearTimeout(clock)
		const value = $(e.target).val().toUpperCase()
		clock = setTimeout(() => {
			$('.category-item').each((j,i) => {
				if(!$(i).hasClass('is-enabled')){
					if($(i).text().toUpperCase().includes(value)) {
						$(i).removeClass('hidden')
					} else {
						$(i).addClass('hidden')
					}
				}
			})
		}, 500)
	})	
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd'
	})
	$('.related-empty').click(function(a) {
		$('.related-empty').hide()
		$('.related-panel').show()
	})
	$('.weekdays').click(function(a) {
		let weekdays = ''
		$('.weekdays').each(function(e, i) {
			weekdays+= $(i).is(':checked') ? $(i).val() : ''
		})
		$('#weekdays').val(weekdays)
	})
});

function toggleOption(e, type){
	let data = JSON.parse(e.getAttribute('data-json'))
	let action = $(e).hasClass('is-enabled') ? 'remove' : 'add'
	data.type = type
	data.source = 'coupon'
	data.model = 'CouponItem'
	data.rel_id = e.getAttribute('data-coupon')
	setRelation(action, data)
}