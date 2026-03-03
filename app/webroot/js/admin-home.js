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
	$('#display_form').on('submit', function(e){
		$.growl.notice({
			title: 'OK',
			message: 'Tu presentación se actualizó',
		});	

		$.ajax({
			url: '',
			data: {
				file: file,
				origin: origin,
			},
			type: 'POST',
		})
		.success(function(res) {
			me.removeClass('fa-mobile', 'fa-desktop')
			const data = JSON.parse(res)
			me.addClass('fa-' + data.orientation)
	  	});
		e.preventDefault()
		return false
	})

	//Images
	var drawImages = function(){
		var base_url 	= $("#image_thumb").data('url');
		var ul 			= $('#images');
		ul.removeClass('fadeIn fadeOut').addClass('animation-fadeOut')
		setTimeout(() => {
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
						orientation: parts[1] || 'mobile'
					}
					var html    	= template(context);

					ul.append(html);
				}
			});
			ul.removeClass('animation-fadeOut').addClass('animation-fadeIn')
		}, 1000);
	}

	$(document).on('click','.edit-orientation',function(event){
		event.preventDefault();
		var me 		= $(this);
		var file 	= me.data('file');
		var origin 	= me.data('origin');
		var orientation = me.data('orientation');
		var state = orientation.indexOf('mobile') > -1 ? 
			'desktop' : 
			'mobile'
		let parts = $(`input[name="data[${origin}]"]`).val()
		let parts1 = parts.split(";")
		let parts2 = parts1.filter((e) => e).map((e) => {
			if(e.includes(file)) {
				e = e.replaceAll(orientation, state)
			}
			if(!e.includes('desktop-') && !e.includes('mobile-')) {
				e = 'mobile-' + e
			}
			return e
		})

		$(`input[name="data[${origin}]"]`).val(parts2.join(";"))

		me.data('orientation', state)
		me.removeClass('fa-mobile', 'fa-desktop')
		me.addClass('fa-'+state)
		/*$.ajax({
			url: '/admin/save_file_orientation',
			data: {
				file: file,
				origin: origin,
			},
			type: 'POST',
		})
		.success(function(res) {
			me.removeClass('fa-mobile', 'fa-desktop')
			const data = JSON.parse(res)
			me.addClass('fa-' + data.orientation)
	  	});*/

	})

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
		var progress = $(me.data('progress'));
		var input 	= $(me.data('input'));
		
		var valid_types = {
			'image/jpeg': true,
			'image/jpg': true,
			'video/mp4': true,
		};

		fd.append('data[file]', this.files[0]);

		if (valid_types[this.files[0].type]) {
			progress.removeClass('hide')
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
				    		const int = parseInt(evt.loaded / evt.total * 100)
				    		//counter.html();
				    		$(progress).val(int)
				    		$(progress).text(int+'%')
				    		if(int > 99) {
				    			progress.addClass('hide')
				    		}
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
				images.push('mobile-' + data);
				input.val( images.join(';') );
				drawImages();
		  	});
			me.val('');
		} else {
			me.val('');
			alert('Tipo de archivo incorrecto. Podes subir archivos JPG y JPEG.');
		}
	});

	drawImages();

	//CKEDITOR.replace('HomeTextPopupNewsletter');

	var drawImagesNewsletter = function(){
		var base_url 	= $("#image_thumb_newsletter").data('url');
		var ul 			= $('#images_newsletter');
		ul.removeClass('fadeIn fadeOut').addClass('animation-fadeOut')
		setTimeout(() => {
			ul.empty();
			$.each(images_newsletter,function(index,image_newsletter){
				if(image_newsletter){ 
					var source   	= $("#image_thumb_newsletter").html();
					var template 	= Handlebars.compile(source);
					var parts = image_newsletter.split('-').reverse() 
					var context 	= {
						image_newsletter: base_url+parts[0], 
						file_newsletter: parts[0], 
						orientation: parts[1] || 'mobile' 
					}
					var html = template(context);
					ul.append(html);
				}
			});
			ul.removeClass('animation-fadeOut').addClass('animation-fadeIn')
		}, 1000)
	}

	$(document).on('click','.delete_image_newsletter',function(event){
		event.preventDefault();
		var me 		= $(this);
		var input 	= $(me.data('input'));
		var images_newsletter 	= input.val().split(';');
		var file_newsletter	= me.data('file');
		images_newsletter	= $.grep(images_newsletter,function(n){ return(n) }); // Clean Empty Values
		images_newsletter = images_newsletter.map((e) => {
			if(e.includes(file_newsletter)) {
				return false
			}
			return e
		}).filter((e) => e)
		//images_newsletter.remove(file_newsletter);
		input.val( images_newsletter.join(';') );
		$(this).closest('span').remove();
	});

	//File Uploads
	$('#HomeImgPopupNewsletter').change(function() {
		var fd 		= new FormData();
		var me 		= $(this);
		var url 	= me.data('url');
		var progress = $(me.data('progress'));
		var input 	= $(me.data('input'));
		
		progress.removeClass('hide')
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
				    		const int = parseInt(evt.loaded / evt.total * 100)
				    		//counter.html();
				    		$(progress).val(int)
				    		$(progress).text(int+'%')
				    		if(int > 99) {
				    			progress.addClass('hide')
				    		}
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

				if(images_newsletter.length > 8){
					alert('Solo se permiten 8 imágenes por modulo');
					return false;
				}else{
					images_newsletter.push('mobile-' + data);
				    input.val(images_newsletter.join(';'));
					drawImagesNewsletter();
				}

		  	});
			me.val('');
		} else {
			me.val('');
			alert('Tipo de archivo incorrecto. Podes subir archivos JPG y JPEG.');
		}
	});

	var img_popup_newsletter = $("[name='data[img_popup_newsletter]']").val().split(';')

	img_popup_newsletter = img_popup_newsletter.map((e) => {
		if(e.includes('desktop-') && !e.includes('mobile-')) {
			e = 'mobile-' + e
		}
		return e
	})

	drawImagesNewsletter();

});