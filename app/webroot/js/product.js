var max_count = 5
var itemData = itemData || {}	

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

function addCart2(data, button, text) {
	$(button).addClass('adding')
	$(button).text(text || 'Agregando...')
	const price = $('.price').text()
	const name = $('.product').text()
	window.dataLayer = window.dataLayer || []
	//fbq('track', 'AddToCart')
	fbq('track', 'AddToCart', {contents: [{id: data.id, quantity: data.count}], value: price, currency: 'ARS'});
	/* @Analytics: addToCart */
	gtag('event', 'add_to_cart', {
	  "items": [
	    {
	      "id": data.id,
	      "name": name,
	      // "list_name": "Search Results",
	      // "brand": "Google",
	      // "category": "Apparel/T-Shirts",
	      "variant": data.alias,
	      "list_position": 1,
	      "quantity": data.count,
	      "price": price
	    }
	  ]
	})
					
	let str = ''
	for(var i in data) {
		str+=`<input type='hidden' name='${i}' value='${data[i]}'>`
	}
	const form = `<form method='post' action='/carrito/add'>${str}</form>`
	$(form).appendTo('body').submit();
}



function pideStock(obj){
		// console.log('changed');
		$(".add.agregar-carro").text('Agregar al carrito')

		var url 		= $(obj).closest("form").data('url');
		var article 	= $(obj).closest("form").data('article');
		var color_code 	= $(obj).closest("form").find('input[name="color"]:checked').attr('code');
		var color_alias 	= $(obj).closest("form").find('input[name="color"]:checked').attr('alias');
		var size_number	= $(obj).closest("form").find('#size option:selected').val();
		var stock_cont	= $(obj).closest("form").find('#stock_container');
		var stock    	= '<i style="color:green;font-weight:600;">Disponible <i>';
		var stock_0 	= '<i style="color:red;font-weight:600;">No Disponible</i>';
		var missing 	= '<i> (Elegí color y talle) </i>';
		var no_color	= '<i> (Elegí color) <i>';
	  var stock_v  	= '<i style="color:gray;">Consultando ... </i>';

		if(!color_code){
			onWarningAlert(`<i class="fa fa-check"></i> Talle ${size_number}`,`Elegí un color para este producto`)
			stock_cont.html(no_color);
			return false;
		}

		if(!size_number){
			onWarningAlert(`<i class="fa fa-check"></i> Color ${color_alias}`,`Elegí un talle para tu prenda`)
			return false;
		}

		window.stock = 0;
		if(url && article && color_code && size_number){
			onWarningAlert('<i class="fa fa-server"></i> Consultando stock','Un momento por favor...')
			var test = document.querySelector('.footer-producto');
      $(test).find('a').animate({opacity: 0.25});
      stock_cont.html(stock_v);

	  	$.get(url+'/'+article+'/'+size_number+'/'+color_code, function(data) {
				if(data != 0){
				  //stock_cont.html( '<i style="color:green">'+data+' unidades.</i>' );
				  $('.growl').remove()

				  onErrorAlert('<i class="fa fa-check"></i> Producto disponible', 'Selecciona cantidad y presiona botón Agregar al carrito para continuar')
					stock_cont.html(stock);
					setTimeout(() => {
						$(test).find('a').animate({opacity: 1});
					}, 1000)
				}else{
					onWarningAlert('<i class="fa fa-warning"></i> Producto no disponible', 'Lamentablemente este producto ya no se encuentra disponible')
					stock_cont.html( stock_0 );
				}
				window.stock = data;
			});
		}else{
			stock_cont.html(missing);
		}
}


$(document).ready(function() {
	//Stock

	$('.oldSelectColor,.loadColorImages').click(function(event) {
		window.lastColorObj = $(this);
		setTimeout(function(){
			// console.log('codeColor: ',$(window.lastColorObj).parent().find('input[name="color"]:checked').attr('code'));
			pideStock(window.lastColorObj)
		},500)
	});

	$('input[name="color"],#size').change(function(event) {
		pideStock(event.target)
	});

	$(".add.agregar-carro").click(function(e) {
		e.preventDefault()
		//this = e.target;
		var data = {
			count: parseInt($('.product-count').val()),
			id: $(e.target).closest('form').find("#product_id").text().trim(),
			color: $(e.target).closest('form').find("input[name='color']:checked").val() || '',
			color_code: $(e.target).closest("form").find('input[name="color"]:checked').attr('code') || '',
			size: $(e.target).closest('form').find("#size option:selected").val() || '',
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
						title: '<i class="fa fa-magic"></i> Personalizá tu compra!',
						message: 'Seleccioná un talle, hay ' + $('#size option').length + ' talles para ' + product_name,
					});
				}
				return $.growl.notice({
					title: '<i class="fa fa-magic"></i> Personalizá tu compra!',
					message: 'Elegí entre ' + $('.color-option').length + ' colores para ' + product_name,
				});
			}

			if ( !window.stock || window.stock == 0 ) {
				return $.growl.error({
					title: ''+product_name,
					message: 'No Disponible'
				});
			}
		}

		addCart(data, e.target)
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

	if($('#size option').length == 2) {
		$('#size').prop('selectedIndex', 1);
	}	

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
