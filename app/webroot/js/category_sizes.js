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

function applyStore(key){
	const json = getStore(key)
	for(var i in json) {
		//console.log(i, json[i])
		$('[name="data[text_style]['+i+']"]').val(json[i]).trigger('change')
	}
}

$(document).ready(function() {
	applyStore('textStyle')
  $('input[name="data[name]"]').keyup(function(e){
  	$('.name-catalog').text($(this).val())
  })
  $('textarea[name="data[text]"]').keyup(function(e){
  	$('.p-catalog').text($(this).val())
  })
  $('input[name="data[text_style][font_size]"]').change(function(){
  	$('.preview-font_size').text($(this).val())
  	$('.p-catalog').css({fontSize: $(this).val()+'px'})
  	saveStore('textStyle', 'font_size', $(this).val())
  })
  $('input[name="data[text_style][font_weight]"]').change(function(){
  	$('.preview-font_weight').text($(this).val())
  	$('.p-catalog').css({fontWeight: $(this).val()})
  	saveStore('textStyle', 'font_weight', $(this).val())
  })
  $('select[name="data[text_style][font_family]"]').change(function(){
  	loadFont($(this).val())
  	$('.preview-font_family').text($(this).val())
  	$('.p-catalog').css({fontFamily: encodeURIComponent($(this).val())})
  	saveStore('textStyle', 'font_family', $(this).val())
  })
	$('#font_color').on('input', function() {
		$('.p-catalog, .name-catalog').css({color: $(this).val()})
		saveStore('textStyle', 'color', $(this).val())
	});
  $('input[name="data[text_style][shadow_width]"]').change(function(){
  	const textShadowColor = $('#shadow_color').val()
  	$('.p-catalog, .name-catalog').css("-webkit-text-stroke", $(this).val()+'px '+textShadowColor)
  	saveStore('textStyle', 'shadow_width', $(this).val())
  })
	$('#shadow_color').on('input', function() {
		const textShadowWidth = $('#shadow_width').val()
		$('.p-catalog, .name-catalog').css("-webkit-text-stroke", textShadowWidth+'px '+$(this).val())
		saveStore('textStyle', 'shadow_color', $(this).val())
	});
  $('.btn-preview').click(function(e){
  	$('.cat-preview').toggleClass('fs')
  	$('.preview-toggle').toggleClass('d-none')
  	$(this).toggleClass('btn-warning')
  	$(this).toggleClass('btn-light')
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

	if($('select[name="data[text_style][font_family]"]').val()) {
		loadFont($('select[name="data[text_style][font_family]"]').val())
	}

  if(window.location.hash.includes('preview')){
    setTimeout(function(){
      $('.btn-preview').click()
    }, 50)
  }	
})
