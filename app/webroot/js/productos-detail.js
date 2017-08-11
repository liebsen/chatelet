$(document).ready(function() {
	var addItem = function( me , list , type ){
		var count = $('.list-group').find('li').length
			extrafields = '<input type="text" class="variable" name="props['+ count +'][variable]" required var />';

		// Comment this if you are uncommenting the (search for) "block #21"
		if (type === 'color') {
			extrafields = '<div class="colorSelector" style="opacity:0">'+
                            '<div style="background-color: #ffffff;"></div>'+
                          '</div>'+
                          '<input type="hidden" class="variable" name="props['+ count +'][variable]" value="#ffffff" class="variable" required />'+
                          '<span class="alias_cont"><input type="text" class="variable" name="props['+ count +'][alias]" value="" class="variable" alias required placeholder="AA, 02, etc..."/></span>';
			$('#colors_select_base').find('select').attr('name', 'props['+ count +'][code]');
			var select_base = $('#colors_select_base').html();
			extrafields += select_base;
		}

		var product_id = $('#product_id');
		if (product_id.length !== 0) {
			extrafields += '<input type="hidden" name="props['+ count +'][product_id]" value="'+ product_id.val() +'" />';
		}

		list.append(
			$('<li class="list-group-item">' +
			  extrafields +
             '<input type="hidden" name="props['+ count +'][type]" value="'+ type +'" />'+
	          '<div class="right">' +
	            '<a class="btn btn-xs btn-danger remove-item">Borrar</a>' +
	          '</div>' +
	        '</li>')
        );

        initPicker();
	}

	$('.add-item').click(function() {
		addItem( $(this) , $(this).siblings('ul') , $(this).siblings('ul').attr('id') );
	});

	var setLastSize = function( size ) {
		var input = $('ul#size li:last-child').find('[var]');
		input.val( size );
	}

	var setLastColor = function( code ) {
		var option = $('ul#color li:last-child').find('select option[value="'+code+'"]');
		option.attr('selected', 'selected');
		var texts = option.html().split(' / ');
		if( texts[1] ) {
			var string = texts[1].toLowerCase();
			string = string.charAt(0).toUpperCase() + string.slice(1);
			
			option.closest('li').find('[alias]').val( string );
		}
	}

	var addDetails = function( details ) {
		$.each( details.sizes , function(index, size) {
			$('.add-item[data-type="size"]').trigger( "click" );
			setLastSize( size )
		});
		$.each( details.colors , function(index, color) {
			$('.add-item[data-type="color"]').trigger( "click" );
			setLastColor( color );
		});
	}

	var clearDetails = function() {
		$('#color').empty();
		$('#size').empty();
	}

	$(document).on('click', '.remove-item', function() {
		var me = $(this);

		// Remove item that I'm in
		me.closest('li').remove();
	});

	$('#productos-detail').submit(function() {
		var checked = $('.category_radio:checked').length;

		if (checked === 0) {
			alert('Debe seleccionar una categoría');
			return false;
		}

		var valid 	= false;
		var url 	= $('#productos-detail').data('article-url');
		var article = $('[name="article"]').val();
		
		url = url+'/'+article;

		$.ajax({
			url: url,
			type: 'GET',
			async: false,
		})
		.done(function(data) {
			if( data == 'ok' ){
				valid = true;
			}
		})
		.fail(function() {
			
		})
		.always(function() {
			
		});

		if(valid){
			return true;
		}else{
			alert('El numero de articulo no existe o no tiene stock.');
			return false;
		}
	});

	var searching = false;

	$('#buscar').click(function() {
		var product_code = $('#prod_cod').val(),
			lis_code = $('#lis_cod').val(),
			lis_code2 = $('#lis_cod2').val(),
			url = $(this).data('url'),
			me = $(this);
		
		if (searching) return;
		if (!lis_code) return alert('Por favor, ingrese un codigo de lista');
		if (!lis_code2) return alert('Por favor, ingrese un codigo de lista de descuento');
		if (!product_code) return alert('Por favor, ingrese un codigo de producto');


		url = [url, product_code, lis_code, lis_code2].join('/');
		searching = true;
		me.text('Buscando...').addClass('btn-info');

		$.ajax(url) 
			.success(function(res) {  
				if ($.isArray(res.results) && !res.results.length) {
					searching = false;
					me.text('Buscar').removeClass('btn-info');
					return alert('No se encontro el producto buscado');
				}
				var product = res.results[0];

				var color = res.colors.Color;

				$('input[name="name"]').val(product.nombre);
                
                $('input[name="desc"]').val(product.descripcion);

                var entero = product.codArticulo;
                questionText = entero.replace(/[0-9]/g,'');
			    var res = (entero).slice(1);
			    var article = questionText + Math.floor(res);
                var codArticulo = article.replace(".",'');
				$('input[name="article"]').val(codArticulo);

				var precio = parseFloat( product.Precio*1.21 );
				precio = parseInt( precio*100 );
         		$('input[name="price"]').val( precio/100 );
                
                
				var Descuento = parseFloat( product.discount );
				Descuento = parseInt( Descuento*100 );
       			$('input[name="discount"]').val(Descuento/100);
				

				me.text('Buscar').removeClass('btn-info');
				searching = false;

				clearDetails();
				addDetails( product.details );
			})
			.fail (function(e) {
				alert('Hubo un problema al tratar de traer el producto');
				me.text('Buscar').removeClass('btn-info');
				searching = false;
			});
	});

	/* ColorPicker */
	function initPicker() {
		return false;
		var picker;
		$('.colorSelector').ColorPicker({
			color: '#ffffff',
			onShow: function (colpkr) {
				picker = $(this);
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				if (picker) {
					picker.children('div').css('backgroundColor', '#' + hex);
					picker.siblings('.variable').val('#' + hex);
				}
			}
		});
	}

	initPicker();

	$('.upload_color_image').on('change', function(event){
		event.preventDefault();
		var fd = new FormData();
		var me = $(this);
		var url	= me.data('url');
		var productId = $("#product_id").val();
		//var counter = $(me).data('count');
		//var input 	= $(me).data('input');		
		var base_url = $("#image_thumb").data('url');
		var alias = me.data('alias');
		var valid_types = {
			'image/jpeg': true,
			'image/jpg': true,
		};
		fd.append('data[file]', this.files[0]);
		fd.append('data[alias]', alias);
		fd.append('data[id]', productId);
		if (valid_types[this.files[0].type]) {
			$.ajax({
				url: url,
				data: fd,
				processData: false,
				contentType: false,
				type: 'POST',
				xhr: function() {
					var xhr = new window.XMLHttpRequest();
				    //Upload progress
				    xhr.upload.addEventListener("progress", function(evt){
				    	if (evt.lengthComputable) {
				    		$('#progress'+alias).attr({value:evt.loaded,max:evt.total});
					    }
					}, false);
				    return xhr;
				}
			})
			.success(function(data) {
				if(data == 'fail'){
					alert('Tipo de archivo incorrecto. Podes subir archivos JPG y JPEG.');
					return false;
				}
				$("#ListUploaded"+alias).append("<img src="+base_url+data+" width='100px'>");
		  	});
			me.val('');
		} else {
			me.val('');
			alert('Tipo de archivo incorrecto. Podes subir archivos JPG y JPEG.');
		}
	});

	$(document).on('click','.delete_image',function(event){
		event.preventDefault();
		var alias 	= $(this).data('alias');
		var image 	= $(this).data('file');
		var url 	= $(this).data('url');
		var id 	= $(this).data('id');
		$.ajax({
			url: url,
			data: {"alias": alias, "image":image, "id": id},
			type: 'POST'
		}).success(function(data) {
			
	  	});
		$(this).closest('li').remove();
	});
});