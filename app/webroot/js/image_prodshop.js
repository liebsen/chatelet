//Remove From Array By Value
Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};

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
		var input 	= $(me).data('input');
		var images 	= $(input).val().split(';');
		var file 	= $(me).data('file');
		images 		= $.grep(images,function(n){ return(n) }); // Clean Empty Values
		images.remove(file);
		$(input).val( images.join(';') );
		$(this).closest('span').remove();
	});

	//File Uploads
	$('#upload').change(function() {
		var fd 		= new FormData();
		var me 		= $(this);
		var url 	= me.data('url');
		var counter = $(me).data('count');
		var input 	= $(me).data('input');
		
		var valid_types = {
			'image/jpeg': true,
			'image/jpg': true,
			'video/mp4': true,
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
				    		$(counter).html( parseInt(evt.loaded / evt.total * 100) );
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

				var images 	= $(input).val();
				images 		= images.split(';');
				images.push(data);
				$(input).val(data);
				drawImages(images);
		  	});
			me.val('');
		} else {
			me.val('');
			alert('Tipo de archivo incorrecto. Podes subir archivos JPG y JPEG.');
		}
	});
	if($("[name='data[image_bannershop]']").val() !== undefined){
		drawImages( $("[name='data[image_bannershop]']").val()  );
	}
	





//*Images Modulo Dos*//
    var drawImagesTwo = function(images_two){
		var base_url 	= $("#image_thumb_two").data('url');
		var ul 			= $('#images_two');

		
		$.each(images_two,function(index,image_two){
			if(image_two){ 
				ul.empty();
				var source   	= $("#image_thumb_two").html();
				var template 	= Handlebars.compile(source);
				var context 	= {image_two: base_url+image_two , file_two: image_two }
				var html    	= template(context);

				ul.append(html);
			}
		});
	}

	$(document).on('click','.delete_image_two',function(event){
		event.preventDefault();
		var me 		= $(this);
		var input 	= $(me.data('input'));
		var images_two 	= input.val().split(';');
		var file_two	= me.data('file');
		images_two	= $.grep(images_two,function(n){ return(n) }); // Clean Empty Values
		images_two.remove(file_two);
		input.val( images_two.join(';') );
		$(this).closest('span').remove();
	});

	//File Uploads
	$('#uploadkari').change(function() {
		var fd 		= new FormData();
		var me 		= $(this);
		var url 	= me.data('url');
		var counter_two = $(me).data('count');
		var input 	= $(me).data('input');
		
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
				    		$(counter_two).html( parseInt(evt.loaded / evt.total * 100) );
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

				var images_two 	= $(input).val();
				images_two 		= images_two.split(';');
				images_two.push(data);
				$(input).val(data);
				drawImagesTwo(images_two);
		  	});
			me.val('');
		} else {
			me.val('');
			alert('Tipo de archivo incorrecto. Podes subir archivos JPG y JPEG.');
		}
	});
  if($("[name='data[image_menushop]']").val() !== undefined){
  	drawImagesTwo(  $("[name='data[image_menushop]']").val()  );
  }
  



  

//*Images Modulo Uno*//
	var drawImagesOne = function(images_one){
		var base_url 	= $("#image_thumb_one").data('url');
		var ul 			= $('#images_one');

		
		$.each(images_one,function(index,image_one){
			if(image_one){
				ul.empty();
				var source   	= $("#image_thumb_one").html();
				var template 	= Handlebars.compile(source);
				var context 	= {image_one: base_url+image_one , file_one: image_one }
				var html    	= template(context);

				ul.append(html);
			}
		});
	}

	$(document).on('click','.delete_image_one',function(event){
		event.preventDefault();
		var me 		= $(this);
		var input 	= $(me.data('input'));
		var images_one 	= input.val().split(';');
		var file_one	= me.data('file');
		images_one	= $.grep(images_one,function(n){ return(n) }); // Clean Empty Values
		images_one.remove(file_one);
		input.val( images_one.join(';') );
		$(this).closest('span').remove();
	});

	//File Uploads
	$('#upload_one').change(function() {
	
	    var fd 		= new FormData();
		var me 		= $(this);
		var url 	= me.data('url');
		var counter_one = $(me.data('count'));
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
				    		counter_one.html( parseInt(evt.loaded / evt.total * 100) );
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

				var images_one 	= $(input).val();
				images_one 		= images_one.split(';');
				images_one.push(data);
				input.val(data);
				drawImagesOne(images_one);
		  	});
			me.val('');
		} else {
			me.val('');
			alert('Tipo de archivo incorrecto. Podes subir archivos JPG y JPEG.');
		}
	});
  
  if($("[name='data[image_prodshop]']").val()!== undefined){
  	drawImagesOne( $("[name='data[image_prodshop]']").val() );
  }



});