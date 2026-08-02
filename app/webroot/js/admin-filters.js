const filter_page = [window.location.pathname.split('/')[2],window.location.pathname.split('/')[3]].join('_')

function calcDateDifference (start, end) {
	const diff = getDateDifference(start,end)
	var parts = []
	if(diff.years)
		parts.push(diff.years + ' año'+ (diff.years > 1 ? 's' : '' ))
	if(diff.months)
		parts.push(diff.months + ' mes'+ (diff.months > 1 ? 'es' : '' ))
	if(diff.days > 0)
		parts.push(diff.days + ' día'+ (diff.days > 1 ? 's' : '' ))
	$('.min-date-text').text(parts.join(','))
}
function showDateDifference (start, end) {
	calcDateDifference(
		new Date($('input[name="date_min"]').val()),
		new Date($('input[name="date_max"]').val())
	)
}
function startDateDifference(){
	console.log('filter_page',filter_page)
	localStorage[filter_page+'_date_min'] = $('input[name="date_min"]').val()
	localStorage[filter_page+'_date_max'] = $('input[name="date_max"]').val()
	$('.filter-sales').submit()
}

$(function () {
	$('input[name="date_min"]').change(showDateDifference)
	$('.filters-apply').click(startDateDifference)
	if(localStorage[filter_page+'_date_min'] && localStorage[filter_page+'_date_min'] != 'undefined')
		$('input[name="date_min"]').val(localStorage[filter_page+'_date_min'])	
	if(localStorage[filter_page+'_date_max'] && localStorage[filter_page+'_date_max'] != 'undefined')
		$('input[name="date_max"]').val(localStorage[filter_page+'_date_max'])
	showDateDifference()
})