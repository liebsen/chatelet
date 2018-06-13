$(document).ready(function() {
	//Stock
	$('input[name="color"],#size').change(function(event) {
		var url 		= $(event.target).closest("form").data('url');
		var article 	= $(event.target).closest("form").data('article');
		var color_code 	= $(event.target).closest("form").find('input[name="color"]:checked').attr('code');
		var size_number	= $(event.target).closest("form").find('#size option:selected').val();

		var stock_cont	= $(event.target).closest("form").find('#stock_container');
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
			if (!data.color || !data.size) {
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
		
      
		$.post(url, $.param(data))
			.success(function(res) {
				if (res.success) {
	                $.growl.notice({
	                    title: 'Producto agregado al carrito',
	                    message: 'Puede seguir agregando más productos o ir a la sección Pagar'
	                });
	                var reload = function() {
	                	window.location.reload();
	                };
	                setTimeout(reload, 3000);
	                $('.growl-close').click(reload);
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

