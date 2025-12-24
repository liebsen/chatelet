
const colsizes_available = {
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
	'80': 80,
}

function integrity_check(){
	var items = []
	var lasttop = 0
	$('.category-item').each((index,element) => {
		const top = $(element).offset().top
		const name = $(element).attr('class').split(' ').map((i) => i.includes('col-md-') ? i : '').filter((i) => i)[0]
		const colsize = parseInt(name.replace('col-md-',''))

		if(!items[top]) {
			items[top] = []
		}

		items[top].push({element, index, colsize})
	})
	var fit = 1
	for(var i in items) {
		var sum = 0
		for(var j in items[i]){
			sum+= Math.round(colsizes_available[items[i][j].colsize])
		}
		for(var j in items[i]){
			const item = $($('.category-item').get(items[i][j].index)).find('.category-item-image')
			if(sum != 100) {
				fit = 0
				item.removeClass('border-success')
				item.addClass('border-danger')
			} else {
				item.addClass('border-success')
				item.removeClass('border-danger')
			}
		}
	}
	$('button[type="submit"]').prop('disabled', !(fit))
}

$(document).ready(function() {
  $('.btn-update').click(e => {
  	var payload = []
		$('.category-item').each((i,e) => {
			const id = $(e).data('id')
			const name = $(e).attr('class').split(' ').map((i) => i.includes('col-md-') ? i : '').filter((i) => i)[0]
			const align = $(e).find('.category-image').attr('class').split(' ').map((i) => i.includes('ci-') ? i : '').filter((i) => i)[0]
			const colsize = parseInt(name.replace('col-md-',''))
			const alignnum = parseInt(align.replace('ci-',''))
			payload.push({
	      id: id,
	      alignnum: alignnum,
	      colsize: colsize
	    })
		})
		$.post('/admin/colsize/category', { payload })
  })

  $('.update-alignnum').change(e => {
  	const val = $(e.target).val() || ''
  	const parent = $(e.target).parents('.category-item').find('.category-image');
  	parent.removeClass('ci-0 ci-1 ci-2 ci-3 ci-4 ci-5 ci-6 ci-7 ci-8')
  	parent.addClass('ci-'+val)
  	integrity_check()

  })

  $('.update-colsize').change(e => {
  	const val = $(e.target).val() || ''
  	const parent = $(e.target).parents('.category-item');
  	for(var i in colsizes_available) {
  		parent.removeClass('col-md-'+i)
  	}
  	parent.addClass('col-md-'+val)
  	integrity_check()
  })
})