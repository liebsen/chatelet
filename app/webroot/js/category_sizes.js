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

const camelToSnake = str => str.replace(/[A-Z]/g, letter => `_${letter.toLowerCase()}`).replace(/^_/, ''); 


$(document).on('click', '.btn-remove-size', function(e) {
	e.preventDefault()
	const target = $(e.target).hasClass('btn-remove-size') ? $(e.target) : $(e.target).parent()
	$(target).parent().remove()
})

$(document).on('click','.style-option',function(e){
	const target = $(this).find('.text-stroke').first()
	const styleObject = target.prop('style');
	const attrs = ['color','fontSize','fontWeight','webkitTextStrokeColor','webkitTextStrokeWidth']
	for(var i in attrs) {
		const camel = attrs[i]
		const val = styleObject[camel]
		var snake = camelToSnake(camel)
		snake = snake.split('webkit_text_stroke').join('shadow')
		$(':input[name="data[text_style]['+snake+']"]').val(val).trigger('change')
	}
	$('.p-catalog').prop('style', target.attr('style'))
	$('button[type="submit"]').prop('disabled', false)
	swal.close()
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
		const target = $(':input[name="data[text_style]['+i+']"]')
		if(target.val()) {} else {
			target.val(json[i]).trigger('change')
		}
	}
}

function blinkTarget(){
	const target = $('.p-catalog')
	target.removeClass('animation-fadeOut')
	target.removeClass('animation-fadeIn')
	setTimeout(function(){
		target.addClass('animation-fadeOut')
	}, 10)
	setTimeout(function(){
		target.addClass('animation-fadeIn')	
	}, 5000)
}

function showStyleSelector(){
	var html = '<div id="style_carousel" class="carousel animation-both animation-fadeIn slide"><div class="carousel-inner" role="listbox">'
	for(var i in styles) {
		const item = styles[i]
		loadFont(item.style.font_family)
		html+= '<a href="#" class="item'+(i==0?' active':'')+' style-option"><span class="text-stroke" style="color:'+(item.style.color||'#ffffff')+';font-size:'+(item.style.font_size||'9')+'px;font-weight:'+(item.style.font_weight||'300')+';font-family:'+(item.style.font_family||'inherit')+';-webkit-text-stroke:'+(item.style.shadow_width||'0')+'px '+(item.style.shadow_color||'transparent')+'">'+item.name+'</span></a>'
	}
	html+= '</div>'
	if(styles.length > 1) {
		html+= '<ol class="carousel-indicators">'
		for(var i in styles) {
			html+= '<li data-target="#style_carousel" data-slide-to="'+i+'" class="'+(i==0?'active':'')+'"></li>'
		}
		html+= '</ol>'
	}

	if(styles.length){
		html+= '<a class="left carousel-control is-transparent" href="#style_carousel" role="button" data-slide="prev"><span class="arrow arrow-left" aria-hidden="true"><i class="hi hi-chevron-left"></i></span><span class="sr-only">Previous</span></a>'
		html+= '<a class="right carousel-control is-transparent" href="#style_carousel" role="button" data-slide="next"><span class="arrow arrow-right" aria-hidden="true"><i class="hi hi-chevron-right"></i></span><span class="sr-only">Next</span></a>'
	}

	html+= '</div>'
	swal({
		title: null,
		text: html,
		html: true,
		showConfirmButton: false,
	})

	$('#style_carousel').carousel()  	
}

$(document).ready(function() {
	applyStore('textStyle')
  $('input[name="data[name]"]').keyup(function(e){
  	blinkTarget()
  	$('.name-catalog').text($(this).val())
  })
  $('textarea[name="data[text]"]').keyup(function(e){
  	blinkTarget()
  	$('.p-catalog').text($(this).val())
  })
  $('input[name="data[text_style][font_size]"]').change(function(){
  	blinkTarget()
  	$('.preview-font_size').text($(this).val())
  	$('.p-catalog').css({fontSize: $(this).val()+'px'})
  	saveStore('textStyle', 'font_size', $(this).val())
  })
  $('input[name="data[text_style][font_weight]"]').change(function(){
  	blinkTarget()
  	$('.preview-font_weight').text($(this).val())
  	$('.p-catalog').css({fontWeight: $(this).val()})
  	saveStore('textStyle', 'font_weight', $(this).val())
  })
  $('select[name="data[text_style][font_family]"]').change(function(){
  	blinkTarget()
  	loadFont($(this).val())
  	$('.preview-font_family').text($(this).val())
  	//$('.p-catalog').css({fontFamily: encodeURIComponent($(this).val())})
  	$('.p-catalog').css({fontFamily: $(this).val()})
  	saveStore('textStyle', 'font_family', $(this).val())
  })
	$('#font_color').on('input', function() {
		blinkTarget()
		$('.p-catalog, .name-catalog').css({color: $(this).val()})
		saveStore('textStyle', 'color', $(this).val())
	});
  $('input[name="data[text_style][shadow_width]"]').change(function(){
  	blinkTarget()
  	const textShadowColor = $('#shadow_color').val()
  	$('.p-catalog').css("-webkit-text-stroke", $(this).val()+'px '+textShadowColor)
  	saveStore('textStyle', 'shadow_width', $(this).val())
  })
	$('#shadow_color').on('input', function() {
		const textShadowWidth = $('#shadow_width').val()
		$('.p-catalog').css("-webkit-text-stroke", textShadowWidth+'px '+$(this).val())
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
  $('.p-catalog').click(function(e){
  	$('a[href="#texts"]').first().trigger('click')
  	showStyleSelector()
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
    $('.btn-preview').first().trigger('click')
  }	
})
