//General Functions
$(function(){
	//Images
	var drawImages = function(images){ 
		var base_url 	= $("#image_thumb").data('url');
		var ul 			= $('#images');

		
		$.each(images,function(index,image){
			if(image){  
				ul.empty();
				var source   	= $("#image_thumb").html();
				var template 	= Handlebars.compile(source);
				var context 	= {image: base_url+image , file: image }
				var html    	= template(context);
				ul.append(html);
			}
		});
	}

	$(document).on('click','.delete_image',function(event){  
		event.preventDefault();
		var me 		= $(this);
		var input 	= $(me.data('input'));
		var images 	= input.val().split(';');
	    var file 	= me.data('file');
		images 		= $.grep(images,function(n){ return(n) }); // Clean Empty Values
		images.remove(file);
		input.val( images.join(';') );
		$(this).closest('span').remove();
	});

	//File Uploads
	$('#upload').change(function() {
		var fd 		= new FormData();
		var me 		= $(this);
		var url 	= me.data('url');
		var counter = $(me.data('count'));
		var input 	= $(me.data('input'));
		
		var valid_types = {
			'image/jpeg': true,
			'image/jpg': true,
		};
		fd.append('data[file]', this.files[0]);

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
				    		counter.html( parseInt(evt.loaded / evt.total * 100) );
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

				var images 	= input.val();
					images 	= images.split(';');
					images.push(data);
					input.val( data );
					drawImages(images);
			
		  	});
			me.val('');
		} else {
			me.val('');
			alert('Tipo de archivo incorrecto. Podes subir archivos JPG y JPEG.');
		}
	});

	drawImages( $("[name='img_url']").val() );
});