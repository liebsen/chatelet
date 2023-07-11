var max_count = 5
var itemData = {}	

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

function addCart(data, button, text) {
	$(button).addClass('adding')
	$(button).text(text || 'Agregando...')
	$.post('/carrito/add', $.param(data))
		.success(function(res) {
			if (res.success) {
				window.dataLayer = window.dataLayer || []
				fbq('track', 'AddToCart')
				/* @Analytics: addToCart */
				gtag('event', 'add_to_cart', {
				  "items": [
				    {
				      "id": data.id,
				      "name": $('.product').text(),
				      // "list_name": "Search Results",
				      // "brand": "Google",
				      // "category": "Apparel/T-Shirts",
				      "variant": data.alias,
				      "list_position": 1,
				      "quantity": data.count,
				      "price": $('.price').text()
				    }
				  ]
				})

        $.growl.notice({
          title: 'Agregado al carrito',
          message: 'Podés seguir agregando más productos o finalizar esta compra en la sección carrito'
        });
        var reload = function() {
        	window.location.href = '/carrito'
        };
        setTimeout(reload, 3000);
        $('.growl-close').click(reload);
				/*
				dataLayer.push({
				  'event': 'addToCart',
				  'ecommerce': {
				    'currencyCode': 'ARS',
				    'add': {         
				      'products': [{
				        'name': $('.product').text(),
				        'id': data.id,
				        'price': $('.price').text(),
				        'brand': 'Google',
				        'category': 'Apparel',
				        'variant': data.alias,
				        'quantity': 1
				       }]
				    }
				  },
					'eventCallback': function() {
	          $.growl.notice({
	            title: 'Producto agregado al carrito',
	            message: 'Podés seguir agregando más productos o ir a la sección Pagar'
	          });
	          var reload = function() {
	          	window.location.href = '/carrito'
	          };
	          setTimeout(reload, 3000);
	          $('.growl-close').click(reload);
     			}
				}) */
			} else {
        $.growl.error({
          title: 'Ocurrió un error al agregar el producto al carrito',
          message: 'Por favor, intentá nuevamente en unos instantes'
        });
			}
		})
		.fail(function() {
      $.growl.error({
        title: 'Ocurrio un error al agregar el producto al carrito',
        message: 'Por favor, intente nuevamente'
      });
		});	
}

function pideStock(obj){
		// console.log('changed');
		$(".add.agregar-carro").text('Agregar al carrito')

		var url 		= $(obj).closest("form").data('url');
		var article 	= $(obj).closest("form").data('article');
		var color_code 	= $(obj).closest("form").find('input[name="color"]:checked').attr('code');
		var size_number	= $(obj).closest("form").find('#size option:selected').val();
		var stock_cont	= $(obj).closest("form").find('#stock_container');
		var stock    	= '<i style="color:green;font-weight:600;">Disponible <i>';
		var stock_0 	= '<i style="color:red;font-weight:600;">No Disponible</i>';
		var missing 	= '<i> (Elegí color y talle) </i>';
		var no_color	= '<i> (Elegí color) <i>';
	  var stock_v  	= '<i style="color:gray;">Consultando ... </i>';

		if(!color_code){
			onSuccessAlert('<i class="fa fa-check"></i> Talle seleccionado','Elegí un color para este producto')
			stock_cont.html(no_color);
			return false;
		}

		if(!size_number){
			onSuccessAlert('<i class="fa fa-check"></i> Color seleccionado','Ahora elegí un talle para tu prenda')
			return false;
		}

		window.stock = 0;
		if(url && article && color_code && size_number){
			onSuccessAlert('<i class="fa fa-server"></i> Un momento','Consultando stock ...')
			var test = document.querySelector('.footer-producto');
      $(test).find('a').animate({opacity: 0.25});
      stock_cont.html(stock_v);

	  	$.get(url+'/'+article+'/'+size_number+'/'+color_code, function(data) {
				if(data != 0){
				  //stock_cont.html( '<i style="color:green">'+data+' unidades.</i>' );
					stock_cont.html(stock);
					setTimeout(() => {
						$(test).find('a').animate({opacity: 1});
					}, 1000)
				}else{
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
			color: $(e.target).closest('form').find("input[name='color']:checked").val(),
			color_code: $(e.target).closest("form").find('input[name="color"]:checked').attr('code'),
			size: $(e.target).closest('form').find("#size option:selected").val(),
			alias: $(e.target).closest('form').find("input[name='color']:checked").attr('alias'),
		}
		if (!isGiftCard){
			// console.log(data.color, data.color_code, data.size)
			if ((!data.color && !data.color_code) || !data.size) {
				document.querySelector('.article-tools').classList.remove('fadeIn', 'flash')
				setTimeout(() => {
					document.querySelector('.article-tools').classList.add('flash')
				}, 10)
				return $.growl.warning({
					title: 'Talle y color',
					message: 'Por favor seleccioná Talle y Color'
				});
			}

			if ( !window.stock || window.stock == 0 ) {
				return $.growl.error({
					title: '',
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

	if(itemData) {
		if(itemData.mp_discount || itemData.bank_discount) {
			if(itemData.mp_discount) 	{
				onSuccessAlert('<i class="fa fa-certificate"></i> Producto con descuento','Este producto tiene un descuento de ' + itemData.mp_discount + '% si comprás por mercadopago')		
			}
			if(itemData.bank_discount) 	{
				onSuccessAlert('<i class="fa fa-certificate"></i> Producto con descuento','Este producto tiene un descuento de ' + itemData.bank_discount + '% si comprás por transferencia')		
			}
		} else {
			if(itemData.discount_label_show) 	{
				onSuccessAlert('<i class="fa fa-certificate"></i> Producto con descuento','Este producto tiene un descuento de ' + itemData.discount_label_show + '%')
			}
		}
	}
});
