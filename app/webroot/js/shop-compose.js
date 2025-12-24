
const indicators_available = {
	'1': 8.33333333,
	'2': 16.66666667,
	'3': 25,
	'4': 33.33333333,
	'5': 41.66666667,
	'6': 50,
	'7': 58.33333333,
	'8': 66.66666667,
	'9': 75,
	'10': 83.33333333,
	'11': 91.66666667,
	'12': 100,
	'20': 20,
	'40': 40,
	'60': 60,
	'77': 77,
	'80': 80,
}

function integrity_check(){
	var elems = []
	var lasttop = 0

	$('.category-item').each((i,e) => {
		const top = $(e).offset().top
		const node = $(e).attr('class').split(' ').map((i) => i.includes('col-md-') ? i : '').filter((i) => i)[0]
		const indicator = parseInt(node.replace('col-md-',''))

		if(!elems[top]) {
			elems[top] = []
		}

		elems[top].push({
			elem: e,
			index: i,
			indicator: indicator
		})
	})

	for(var i in elems) {
		var sum = 0
		var fit = 1
		for(var j in elems[i]){
			sum+= Math.ceil(indicators_available[elems[i][j].indicator])
		}
		for(var j in elems[i]){
			const item = $($('.category-item').get(elems[i][j].index)).find('.category-item-image')
			if(sum != 100) {
				fit = 0
				item.removeClass('border-success')
				item.addClass('border-danger')
			} else {
				item.addClass('border-success')
				item.removeClass('border-danger')
			}
		}
		$('input[type="submit"]').prop('disabled', !fit)
	}
}

$(document).ready(function() {
  $('.select-grid').change(e => {
  	const val = $(e.target).val() || ''
  	console.log('val',val)
  	const parent = $(e.target).parents('.category-item');
  	parent.removeClass('col-md-3 col-md-4 col-md-6 col-md-12 col-md-20 col-md-40 col-md-60 col-md-80')
  	parent.addClass('col-md-'+val)

  	integrity_check()
  })
})