function pideStock(obj){

		// console.log('changed');
		$(".add.agregar-carro").text('Agregar al carrito')

		var url 		= $(obj).closest("form").data('url');
		var article 	= $(obj).closest("form").data('article');
		var color_code 	= $(obj).closest("form").find('input[name="color"]:checked').attr('code');
		var size_number	= $(obj).closest("form").find('#size option:selected').val();

		var stock_cont	= $(obj).closest("form").find('#stock_container');
		var stock    	= '<i style="color:green;">Disponible <i>';
		var stock_0 	= '<i style="color:red;">No Disponible</i>';
		var missing 	= '<i> (Seleccione un color y talle) </i>';
		var no_color	= '<i> (Seleccione color) <i>';

	    var stock_v  	= '<i style="color:gray;">Consultando ... </i>';



		if(!color_code){
			stock_cont.html(no_color);
			return false;
		}

		window.stock = 0;
		if(url && article && color_code && size_number){

			var test = document.querySelector('.footer-producto');
            $(test).find('a').hide();
            stock_cont.html(stock_v);

		  	$.get(url+'/'+article+'/'+size_number+'/'+color_code, function(data) {

				if(data != 0){
				    //stock_cont.html( '<i style="color:green">'+data+' unidades.</i>' );
					stock_cont.html(stock);
					$(test).find('a').show();
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
		//this = e.target;
		var data = {
			id: $(e.target).closest('form').find("#product_id").text().trim(),
			color: $(e.target).closest('form').find("input[name='color']:checked").val(),
			color_code: $(e.target).closest("form").find('input[name="color"]:checked').attr('code'),
			size: $(e.target).closest('form').find("#size option:selected").val(),
			alias: $(e.target).closest('form').find("input[name='color']:checked").attr('alias'),
		};
		url = $("#productForm").attr('action');
		if (!isGiftCard){
			if ((!data.color && !data.color_code) || !data.size) {
				return $.growl.error({
					title: '',
					message: 'Por favor seleccione un color y un talle'
				});
			}

			if ( !window.stock || window.stock == 0 ) {
				return $.growl.error({
					title: '',
					message: 'No Disponible'
				});
			}
		}

		$(e.target).text('Agregando...')

		$.post(url, $.param(data))
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
					      "quantity": 1,
					      "price": $('.price').text()
					    }
					  ]
					})

          $.growl.notice({
            title: 'Producto agregado al carrito',
            message: 'Puede seguir agregando más productos o ir a la sección Pagar'
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
		            message: 'Puede seguir agregando más productos o ir a la sección Pagar'
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
            title: 'Ocurrio un error al agregar el producto al carrito',
            message: 'Por favor, intente nuevamente'
          });
				}
			})
			.fail(function() {
        $.growl.error({
          title: 'Ocurrio un error al agregar el producto al carrito',
          message: 'Por favor, intente nuevamente'
        });
			});

		return false;
	});

	$('.info-icon').click(function(e) {
		var me = $(this);
		var position = me.offset();
		window.open(me.attr('data-image'), 'Talles', 'height=323px, width=642px, resizable=no, status=no, toolbar=no, menubar=no, location=no, top='+ position.top +'px, left=' + position.left +'px');
	});
});
