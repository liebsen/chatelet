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
	clearTimeout(timeout)
	timeout = setTimeout(() => {
		console.log('pideStock');
		$(".add.agregar-carro").text('Agregar al carrito')

		var url 		= $(obj).closest("form").data('url');
		var article 	= $(obj).closest("form").data('article');
		var color_code 	= $(obj).closest("form").find('input[name="color"]:checked').attr('code');
		var color_alias 	= $(obj).closest("form").find('input[name="color"]:checked').attr('alias');
		var size_number	= $(obj).closest("form").find('input[name="size"]:checked').val();
		var stock_cont	= $(obj).closest("form").find('#stock_container');
		var stock    	= '<i style="color:green;font-weight:600;">Disponible <i>';
		var stock_0 	= '<i style="color:red;font-weight:600;">No Disponible</i>';
		var missing 	= '<i> (Elegí color y talle) </i>';
		var no_color	= '<i> (Elegí color) <i>';
	  var stock_v  	= '<i style="color:gray;">Consultando ... </i>';
	  console.log({color_code, size_number})
		if(!color_code){
			// onWarningAlert(`Talle seleccionado`,`Seleccionaste talle ${size_number}, ahora elegí un color para este producto`)
			console.log('a(1)')
			stock_cont.html(no_color);
			return false;
		}

		if(!size_number){
			console.log('a(2)')
			// onWarningAlert(`Color seleccionado`,`Seleccionaste color ${color_alias}, ahora elegí un talle para tu prenda`)
			return false;
		}

		window.stock = 0;
		if(url && article && color_code && size_number){
			// onWarningAlert('Consultando stock','Un momento por favor...')
			var test = document.querySelector('.footer-producto');
      $(test).find('a').animate({opacity: 0.5});
      stock_cont.html(stock_v);

	  	$.get(url+'/'+article+'/'+size_number+'/'+color_code, function(data) {
				if(data != 0){
				  // stock_cont.html( '<i style="color:green">'+data+' unidades.</i>' );
				  // $('.growl').remove()
				  // onErrorAlert('Producto disponible', 'Selecciona cantidad y presiona botón Agregar al carrito para continuar')
					stock_cont.html(stock);
					setTimeout(() => {
						$(test).find('a').animate({opacity: 1});
					}, 1000)
				}else{
					onWarningAlert('Producto no disponible', 'Lamentablemente este producto ya no se encuentra disponible')
					stock_cont.html( stock_0 );
				}
				window.stock = data;
			});
		}else{
			stock_cont.html(missing);
		}
	}, 500)
}


$(document).ready(function() {
	//Stock

	$(".agregar-carro").click(function(e) {
		e.preventDefault()
		const target = $(e.target)
		//this = e.target;
		var data = {
			count: parseInt($('.product-count').val()),
			id: $(e.target).closest('form').find("#product_id").text().trim(),
			color: $(e.target).closest('form').find("input[name='color']:checked").val() || '',
			color_code: $(e.target).closest("form").find('input[name="color"]:checked').attr('code') || '',
			size: $(e.target).closest("form").find('input[name="size"]:checked').val() || '',
			alias: $(e.target).closest('form').find("input[name='color']:checked").attr('alias') || '',
		}
		if (!isGiftCard){
			var product_name = $('#product_id').next().text()
			//console.log(data.color, data.color_code, data.size)
			if ((!data.color && !data.color_code) || !data.size) {
				document.querySelector('.article-tools').classList.remove('fadeIn', 'flash')
				setTimeout(() => {
					document.querySelector('.article-tools').classList.add('flash')
				}, 10)
				if(!data.size){
					return $.growl.notice({
						title: '¡Personalizá tu compra!',
						message: 'Seleccioná uno de los ' + ($('.size-options').length + 1) + ' talles disponibles para ' + product_name,
					});
				}
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

		addCart(data, e.target, 'Agregando al carrito ...', target.hasClass('buy') ? '/checkout' : '/carrito')
		return false;
	});

	$('.info-icon').click(function(e) {
		var me = $(this);
		var position = me.offset();
		window.open(me.attr('data-image'), 'Talles', 'height=323px, width=642px, resizable=no, status=no, toolbar=no, menubar=no, location=no, top='+ position.top +'px, left=' + position.left +'px');
	});


	/* autoselect if one option */
	if($('.color-option').length > 0) {
		$('.color-option').first().click()
	}

	if($('.size-option').length > 0) {
		$('.size-option').first().click()
	}	

	$('.color-options .btn').click(function(event) {
		console.log('color click')
		pideStock(this)
	});

	$('.size-options .btn').click(function(event) {
		console.log('size click')
		pideStock(this)
	});


	/*if(itemData) {
		if(itemData.mp_discount || itemData.bank_discount) {
			if(parseInt(itemData.mp_discount)) 	{
				onWarningAlert('<i class="fa fa-calculator"></i> ' + itemData.name + ' ' + itemData.discount_label_show + '%OFF','Podés comprar hoy '+itemData.name+' con un ' + itemData.mp_discount + '% de descuento si comprás por mercadopago')		
			}
			if(parseInt(itemData.bank_discount))	{
				onWarningAlert('<i class="fa fa-calculator"></i> ' + itemData.name + ' ' + itemData.discount_label_show + '%OFF','Podés comprar hoy '+itemData.name+' con un '  + itemData.bank_discount + '% de descuento si comprás por transferencia')		
			}
		} else {
			if(parseInt(itemData.discount_label_show)) {
				onWarningAlert('<i class="fa fa-calculator"></i> ' + itemData.name + ' ' + itemData.discount_label_show + '%OFF','Podés comprar hoy '+itemData.name+' con un ' + itemData.discount_label_show + '% de descuento. Aprovechá nuestras ofertas!')
			}
		}
	}*/
});
