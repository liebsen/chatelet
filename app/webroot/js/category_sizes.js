$(document).on('click', '.btn-remove-size', function(e) {
	e.preventDefault()
	const target = $(e.target).hasClass('btn-remove-size') ? $(e.target) : $(e.target).parent()
	$(target).parent().remove()
})

$(document).ready(function() {
  $('.btn-delete-size').click(function(e){
  	e.preventDefault()
  	const target = $(e.target).hasClass('btn-delete-size') ? $(e.target) : $(e.target).parent()
  	console.log('<input type="hidden" name="sizes[rm][]" value="'+target.data('id')+'">')
  	$('#form_app').append('<input type="hidden" name="sizes[rm][]" value="'+target.data('id')+'">')
  	$(target).parent().remove()
  })
  $('.btn-create-size').click(function(e){
		e.preventDefault()
		var element = $('.sizes-create-area').append($('.size-create-item').html())
		return false;
	})
})
