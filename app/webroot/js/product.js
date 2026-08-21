var max_count = 5
var itemData = itemData || {}	
var timeout = 0

function addCount() {
	var value = parseInt($('.has-item-counter.active .product-count').val()) + 1
	if (value > max_count) max_count = 5
	$('.has-item-counter.active .product-count').val(value)
	checkCount(value)
}

function removeCount() {
	var value = parseInt($('.has-item-counter.active .product-count').val()) - 1
	if (value < 1) value = 1
	$('.has-item-counter.active .product-count').val(value)
	checkCount(value)
}

function checkCount(value) {
	if (value !== parseInt($('.has-item-counter.active .product-count').attr('original-value'))) {
		$('.has-item-counter.active .ch-btn-success').removeClass('disable')
	} else {
		$('.has-item-counter.active .ch-btn-success').addClass('disable')
	}
}

function pideStock(obj){
	setTimeout(function(){
		var id 	= $('#product_id').text()
		var article 	= $(obj).closest("form").data('article');
		var color_code 	= $(obj).closest("form").find('input[name="color"]:checked').attr('code');
		var color_alias 	= $(obj).closest("form").find('input[name="color"]:checked').attr('alias');
		var size_number	= $(obj).closest("form").find('input[name="size"]:checked').val();
		var stock_cont	= $(obj).closest("form").find('#stock_container');
		var stock    	= '<span class="text-success text-bold">Disponible<span>';
		var stock_0 	= '<span class="text-danger text-bold">No Disponible</span>';
		var missing 	= '<span class="text-warning">(Elegí color y talle)</span>';
		var no_color	= '<span class="text-warning">(Elegí color)<span>';
		var no_size	= '<span class="text-warning">(Elegí talle)<span>';
	  var stock_v  	= '<span class="text-muted">Consultando ...</span>';

		if(!color_code){
			stock_cont.html(no_color);
			return false;
		}

		if(!size_number){
			stock_cont.html(no_size);
			return false;
		}

		window.stock = 0;
		if(article && color_code && size_number){
			// onWarningAlert('Consultando stock','Un momento por favor...')
	    stock_cont.html(stock_v);
	    const count = window.stockCount[size_number+color_code] || 0
			if(count != 0){
				stock_cont.html(stock);
			} else {
				stock_cont.html( stock_0 );
			}

			window.stock = count;
		}else{
			stock_cont.html(missing);
		}
	}, 100)
}

function updatePrefs(obj){
		let radio = $(obj).find('input[type="radio"]')
		let type = $(obj).find('input[type="radio"]').prop('name')
		let name = 'size'
		let value = radio.val()
		if(type=='color') {
			name = 'color'
			value = radio.attr('code')
		}
		if(name && value && itemData.id) {
			let prod_settings = localStorage.prod_settings && localStorage.prod_settings != 'undefined' ? 
				JSON.parse(localStorage.prod_settings) : 
				{}
			prod_settings[itemData.id] = { ...prod_settings[itemData.id], [name]:value }
			localStorage.prod_settings = JSON.stringify(prod_settings)
		}
}

function updateSizes(obj){
		let code = $(obj).find('input[type="radio"]').attr('code')
		//console.log('code',code)
		$('.size-options label').each(function(i,e){
			let size = $(e).find('input[type="radio"]').val()
			//console.log('size',size)
			const stock = window.stockCount[size+code] || 0
			if(stock < 3) {
				$(e).addClass('disabled')
			} else {
				$(e).removeClass('disabled')
			}
		})
}

$(document).ready(function() {
	//Stock

	$('.color-options .btn').click(function(event) {
		updateSizes(this)
		updatePrefs(this)
		pideStock(this)
	});

	$('.size-options .btn').click(function(event) {
		updatePrefs(this)
		pideStock(this)
	});

	$(".agregar-carro").click(function(e) {
		e.preventDefault()
		const target = $(e.target)
		//this = e.target;
		const gift = $('.prod-article').text().toLowerCase().includes('gift')
		var data = {
			count: parseInt($('.product-count').val()),
			id: target.closest('form').find("#product_id").text().trim(),
			color: target.closest('form').find("input[name='color']:checked").val() || '',
			color_code: target.closest("form").find('input[name="color"]:checked').attr('code') || '',
			size: target.closest("form").find('input[name="size"]:checked').val() || '',
			alias: target.closest('form').find("input[name='color']:checked").attr('alias') || '',
		}
		var product_name = $('#product_id').next().text()
		//console.log(data.color, data.color_code, data.size)
		if(!gift){
			if ((!data.color && !data.color_code) || !data.size) {
				if(!data.size){
					$('.size-options').removeClass('flash').addClass('flash')
					return $.growl.notice({
						title: '¡Personalizá tu compra!',
						message: 'Seleccioná uno de los ' + ($('.size-options').length + 1) + ' talles disponibles para ' + product_name,
					});
				}

				$('.color-options').removeClass('flash').addClass('flash')

				return $.growl.notice({
					title: '¡Personalizá tu compra!',
					message: 'Seleccioná uno de los ' + ($('.color-options').length + 1) + ' colores disponibles para ' + product_name,
				});
			}

			if ( !window.stock || window.stock == 0 ) {
				return $.growl.error({
					title: ''+product_name,
					message: 'No Disponible'
				});
			}
		}

		$.growl.notice({
			title: 'Un segundo...',
			message: 'Estamos agregando tu producto',
		})

	  target.addClass('adding')
	  target.text(target.hasClass('buy') ? 
	  	'Preparando tu compra... ' : 
	  	'Agregando al carrito ...'
	  )		

		addToCart(data).then(() => {
			target.removeClass('adding')
			let redirect = target.hasClass('buy') ? 
				'/checkout' : 
				'/carrito' 
      setTimeout(() => {
				target.prop('disabled', false)
			  target.text(target.hasClass('buy') ? 
			  	'Comprar' : 
			  	'Agregar al carrito'
			  )
        window.location.href = redirect
      }, 2000)
		}).catch((e) => {
			$('#comprar').text('Comprar')
			$('#agregar-carro').text('Agregar al carrito')
			$('#comprar').removeClass('adding')
			$('#agregar-carro').removeClass('adding')

			return $.growl.error({
				title: 'Error',
				message: 'Producto no disponible'
			});
		})

		return false;
	});

	$('.info-icon').click(function(e) {
		var me = $(this);
		var position = me.offset();
		window.open(me.attr('data-image'), 'Talles', 'height=323px, width=642px, resizable=no, status=no, toolbar=no, menubar=no, location=no, top='+ position.top +'px, left=' + position.left +'px');
	});

	/* autoselect if one option */
	if($('.color-option').length == 1) {
		$('.color-option').first().click()
	}

	if($('.size-option').length == 1) {
		$('.size-option').first().click()
	}	

	let prod_settings = localStorage.prod_settings && localStorage.prod_settings != 'undefined' ? 
		JSON.parse(localStorage.prod_settings) : 
		{}

	if(prod_settings[itemData.id]) {
		if(prod_settings[itemData.id].color) {
			$(`input[code="${prod_settings[itemData.id].color}"]`).click()
		}
		if(prod_settings[itemData.id].size) {
			$(`input[value="${prod_settings[itemData.id].size}"]`).click()
		}
	}
});
