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

		ul.empty();
		$.each(images,function(index,image){
			if(image){
				var source   	= $("#image_thumb").html();
				var template 	= Handlebars.compile(source);
				var parts = image.split('-').reverse() 
				var context 	= {
					image: base_url+parts[0], 
					file: parts[0],
					video: parts[0].includes('.mp4'),
					orientation: parts[1] || ''
				}
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
		images = images.map((e) => {
			if(e.includes(file)) {
				return false
			}
			return e
		}).filter((e) => e)
		//images.remove(file);
		input.val( images.join(';') );
		$(this).closest('li').remove();
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
				images 		= images.split(';');
				images.push(data);
				input.val( images.join(';') );
				drawImages(images);
		  	});
			me.val('');
		} else {
			me.val('');
			alert('Tipo de archivo incorrecto. Podes subir archivos JPG y JPEG.');
		}
	});

	drawImages( $("[name='data[img_url]']").val().split(';') );


//*Images Modulo Uno*//
	var drawImagesOne = function(images_one){
		var base_url 	= $("#image_thumb_one").data('url');
		var ul 			= $('#images_one');

		ul.empty();
		$.each(images_one,function(index,image_one){
			if(image_one){
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
                
                var images_one 	= input.val();
				images_one 		= images_one.split(';');
				if(images_one.length > 3){
					alert('Solo se permiten 3 imagenes por modulo');
					return false;
				}else{
					images_one.push(data);
				    input.val( images_one.join(';') );
					drawImagesOne(images_one);
			    }

		  	});
			me.val('');
		} else {
			me.val('');
			alert('Tipo de archivo incorrecto. Podes subir archivos JPG y JPEG.');
		}
	});
  
	drawImagesOne( $("[name='data[img_url_one]']").val().split(';') );



//*Images Modulo Dos*//
    var drawImagesTwo = function(images_two){
		var base_url 	= $("#image_thumb_two").data('url');
		var ul 			= $('#images_two');

		ul.empty();
		$.each(images_two,function(index,image_two){
			if(image_two){ 
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
	$('#upload_two').change(function() {
		var fd 		= new FormData();
		var me 		= $(this);
		var url 	= me.data('url');
		var counter_two = $(me.data('count'));
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
				    		counter_two.html( parseInt(evt.loaded / evt.total * 100) );
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
                
                var images_two 	= input.val();
				images_two 		= images_two.split(';');

				if(images_two.length > 3){
					alert('Solo se permiten 3 imagenes por modulo');
					return false;
				}else{
					images_two.push(data);
				    input.val( images_two.join(';') );
					drawImagesTwo(images_two);
				}

		  	});
			me.val('');
		} else {
			me.val('');
			alert('Tipo de archivo incorrecto. Podes subir archivos JPG y JPEG.');
		}
	});
  
	drawImagesTwo( $("[name='data[img_url_two]']").val().split(';') );
  

/*Images Modulo Tres*/
    var drawImagesThree = function(images_three){
		var base_url 	= $("#image_thumb_three").data('url');
		var ul 			= $('#images_three');

		ul.empty();
		$.each(images_three,function(index,image_three){
			if(image_three){ 
				var source   	= $("#image_thumb_three").html();
				var template 	= Handlebars.compile(source);
				var context 	= {image_three: base_url+image_three , file_three: image_three }
				var html    	= template(context);

				ul.append(html);
			}
		});
	}

	$(document).on('click','.delete_image_three',function(event){
		event.preventDefault();
		var me 		= $(this);
		var input 	= $(me.data('input'));
		var images_three 	= input.val().split(';');
		var file_three	= me.data('file');
		images_three	= $.grep(images_three,function(n){ return(n) }); // Clean Empty Values
		images_three.remove(file_three);
		input.val( images_three.join(';') );
		$(this).closest('span').remove();
	});

	//File Uploads
	$('#upload_three').change(function() {
		var fd 		= new FormData();
		var me 		= $(this);
		var url 	= me.data('url');
		var counter_three = $(me.data('count'));
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
				    		counter_three.html( parseInt(evt.loaded / evt.total * 100) );
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
                
                var images_three 	= input.val();
				images_three 		= images_three.split(';');

				if(images_three.length > 3){
					alert('Solo se permiten 3 imagenes por modulo');
					return false;
				}else{
					images_three.push(data);
				    input.val( images_three.join(';') );
					drawImagesThree(images_three);
				}

		  	});
			me.val('');
		} else {
			me.val('');
			alert('Tipo de archivo incorrecto. Podes subir archivos JPG y JPEG.');
		}
	});
  
	drawImagesThree( $("[name='data[img_url_three]']").val().split(';') );

/*Images Module Cuatro*/
	$("#category_mod_four").on('change', function(event){
		var option = $( "#category_mod_four option:selected" );
		$("#category_mod_four option:selected").each(function(){
			if($(this).val()=='url'){
				$("#txturlfour").removeClass('hidden');
			} else {
				$("#txturlfour").addClass('hidden');
			}
		});
	});
	$("#category_mod_one").on('change', function(event){
		var option = $( "#category_mod_one option:selected" );
		$("#category_mod_one option:selected").each(function(){
			if($(this).val()=='url'){
				$("#txturlone").removeClass('hidden');
			} else {
				$("#txturlone").addClass('hidden');
			}
		});
	});
	$("#category_mod_two").on('change', function(event){
		var option = $( "#category_mod_two option:selected" );
		$("#category_mod_two option:selected").each(function(){
			if($(this).val()=='url'){
				$("#txturltwo").removeClass('hidden');
			} else {
				$("#txturltwo").addClass('hidden');
			}
		});
	});
	$("#category_mod_three").on('change', function(event){
		var option = $( "#category_mod_three option:selected" );
		$("#category_mod_three option:selected").each(function(){
			if($(this).val()=='url'){
				$("#txturlthree").removeClass('hidden');
			} else {
				$("#txturlthree").addClass('hidden');
			}
		});
	});

	var drawImagesFour = function(images_four){
		var base_url 	= $("#image_thumb_four").data('url');
		var ul 			= $('#images_four');

		ul.empty();
		$.each(images_four,function(index,image_four){
			if(image_four){ 
				var source   	= $("#image_thumb_four").html();
				var template 	= Handlebars.compile(source);
				var context 	= {image_four: base_url+image_four , file_four: image_four }
				var html    	= template(context);

				ul.append(html);
			}
		});
	}

	$(document).on('click','.delete_image_four',function(event){
		event.preventDefault();
		var me 		= $(this);
		var input 	= $(me.data('input'));
		var images_four 	= input.val().split(';');
		var file_four	= me.data('file');
		images_four	= $.grep(images_four,function(n){ return(n) }); // Clean Empty Values
		images_four.remove(file_four);
		input.val( images_four.join(';') );
		$(this).closest('span').remove();
	});

	//File Uploads
	$('#upload_four').change(function() {
		var fd 		= new FormData();
		var me 		= $(this);
		var url 	= me.data('url');
		var counter_four = $(me.data('count'));
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
				    		counter_four.html( parseInt(evt.loaded / evt.total * 100) );
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
                
                var images_four 	= input.val();
				images_four 		= images_four.split(';');

				if(images_four.length > 3){
					alert('Solo se permiten 3 imagenes por modulo');
					return false;
				}else{
					images_four.push(data);
				    input.val( images_four.join(';') );
					drawImagesFour(images_four);
				}

		  	});
			me.val('');
		} else {
			me.val('');
			alert('Tipo de archivo incorrecto. Podes subir archivos JPG y JPEG.');
		}
	});
	drawImagesFour( $("[name='data[img_url_four]']").val().split(';') );

	CKEDITOR.replace('HomeTextPopupNewsletter');

	var drawImagesNewsletter = function(images_newsletter){
		var base_url 	= $("#image_thumb_newsletter").data('url');
		var ul 			= $('#images_newsletter');

		ul.empty();
		$.each(images_newsletter,function(index,image_newsletter){
			if(image_newsletter){ 
				var source   	= $("#image_thumb_newsletter").html();
				var template 	= Handlebars.compile(source);
				var parts = image_newsletter.split('-').reverse() 
				var context 	= {image_newsletter: base_url+parts[0] , file_newsletter: parts[0], orientation: parts[1] || '' }
				var html    	= template(context);

				ul.append(html);
			}
		});
	}

	$(document).on('click','.delete_image_newsletter',function(event){
		event.preventDefault();
		var me 		= $(this);
		var input 	= $(me.data('input'));
		var images_newsletter 	= input.val().split(';');
		var file_newsletter	= me.data('file');
		console.log('file_newsletter',file_newsletter)
		images_newsletter	= $.grep(images_newsletter,function(n){ return(n) }); // Clean Empty Values
		images_newsletter = images_newsletter.map((e) => {
			console.log(e, file_newsletter)
			if(e.includes(file_newsletter)) {
				return false
			}
			return e
		}).filter((e) => e)
		console.log('images_newsletter(2)',images_newsletter)
		//images_newsletter.remove(file_newsletter);
		input.val( images_newsletter.join(';') );
		$(this).closest('span').remove();
	});

	//File Uploads
	$('#HomeImgPopupNewsletter').change(function() {
		var fd 		= new FormData();
		var me 		= $(this);
		var url 	= me.data('url');
		var counter_newsletter = $(me.data('count'));
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
				    		counter_newsletter.html( parseInt(evt.loaded / evt.total * 100) );
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
                
                var images_newsletter 	= input.val();
				images_newsletter 		= images_newsletter.split(';');

				if(images_newsletter.length > 3){
					alert('Solo se permiten 3 imagenes por modulo');
					return false;
				}else{
					images_newsletter.push(data);
				    input.val(images_newsletter.join(';'));
					drawImagesNewsletter(images_newsletter);
				}

		  	});
			me.val('');
		} else {
			me.val('');
			alert('Tipo de archivo incorrecto. Podes subir archivos JPG y JPEG.');
		}
	});
	drawImagesNewsletter( $("[name='data[img_popup_newsletter]']").val().split(';') );

});