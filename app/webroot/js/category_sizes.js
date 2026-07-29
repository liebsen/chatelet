function category_sizes_update(data) {
	for(var i in data.size_updates){
		const option = $('select option[value='+data.size_updates[i].code+']')
		if(option.length) {
			option.parent().parent().find(':input:not(button)').prop('disabled',true)
			option.parent().parent().find('button').removeClass('btn-remove-size')
			option.parent().parent().find('button').addClass('btn-delete-size')
			option.parent().parent().find('button').data(data.size_updates[i].id)
		}
	}
}

$(document).on('click', '.btn-remove-size', function(e) {
	e.preventDefault()
	console.log('btn-remove-size')
	const target = $(e.target).hasClass('btn-remove-size') ? $(e.target) : $(e.target).parent()
	$(target).parent().remove()
})

$(document).on('click','.btn-delete-size',function(e){
	console.log('btn-delete-size')
	e.preventDefault()
	const target = $(e.target).hasClass('btn-delete-size') ? $(e.target) : $(e.target).parent()
	console.log('<input type="hidden" name="sizes[rm][]" value="'+target.data('id')+'">')
	$('#form_app').append('<input type="hidden" name="sizes[rm][]" value="'+target.data('id')+'">')
	$(target).parent().remove()
})

$(document).ready(function() {

	//$('#form_app button[type="submit"]').click(function(e){
	//$('#form_app').submit(function(e){

	//})


  $('.btn-create-size').click(function(e){
		e.preventDefault()
		var element = $('.sizes-create-area').append($('.size-create-item').html())
		return false;
	})
})
