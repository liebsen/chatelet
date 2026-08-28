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
	const target = $(e.target).hasClass('btn-remove-size') ? $(e.target) : $(e.target).parent()
	$(target).parent().remove()
})

$(document).on('click','.btn-delete-size',function(e){
	e.preventDefault()
	const target = $(e.target).hasClass('btn-delete-size') ? $(e.target) : $(e.target).parent()
	$('#form_app').append('<input type="hidden" name="sizes[rm][]" value="'+target.data('id')+'">')
	$(target).parent().remove()
})

$(document).ready(function() {
  $('input[name="data[name]"]').keyup(function(e){
  	$('.name-catalog').text($(this).val())
  })
  $('textarea[name="data[text]"]').keyup(function(e){
  	$('.p-catalog').text($(this).val())
  })
  $('input[name="data[text_size]"]').change(function(){
  	$('.preview-text_size').text($(this).val())
  	$('.p-catalog').css({fontSize: $(this).val()+'px'})
  })
  $('input[name="data[style][font_weight]"]').change(function(){
  	$('.preview-text_weight').text($(this).val())
  	$('.p-catalog').css({fontWeight: $(this).val()})
  })
  $('input[name="data[style][font_color]"]').change(function(){
  	$('.p-catalog, .name-catalog').css({color: $(this).val()})
  })
  $('.btn-preview').click(function(e){
  	$('.cat-preview').toggleClass('fs')
  	$('.shop-preview').toggleClass('d-none')
  })
  $('select[name="data[posnum]"]').change(function(e){
		$('.shop-preview').removeClass(function(index, className) {
		  return (className.match(/\posnum-\S+/g) || []).join(' ');
		})
		$('.shop-preview').addClass('posnum-'+$(this).val())
  })
  $('select[name="data[alignnum]"]').change(function(e){
		$('.shop-preview').removeClass(function(index, className) {
		  return (className.match(/\alignnum-\S+/g) || []).join(' ');
		})
		$('.shop-preview').addClass('alignnum-'+$(this).val())
  })
  $('.btn-create-size').click(function(e){
		e.preventDefault()
		var element = $('.sizes-create-area').append($('.size-create-item').html())
		return false;
	})
})
