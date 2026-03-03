const video = document.getElementById('video-element');
const playButton = document.getElementById('play-button');
const videoContainer = document.querySelector('.video-container');
//Remove From Array By Value
/*Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }	
    return this;
};
*/

const colsizes_available = {
	'1': 8.33333333,
	'2': 16.66666667,
	'3': 25,
	'4': 33.33333333,
	'5': 41.66666667,
	'6': 50,
	'7': 58.33333333,
	'8': 66.66666667,
	'9': 75,
	'10': 83.33333333,
	'11': 91.66666667,
	'12': 100,
	'20': 20,
	'40': 40,
	'60': 60,
	'80': 80,
}

function video_toggle_play(container) {
	//$(e.target).parents('.category-content').find('video')
	const video = container.find('video')
	const play_btn = container.find('.play-button')
			console.log('container',container)
			console.log('video',video)

  if (video.paused || video.ended) {
    //video[0].play();
    $(video).trigger('play');
    play_btn.css('display', 'none'); // Hide the button when playing
  } else {
    //video[0].pause();
    $(video).trigger('pause');
    play_btn.css('display', 'block'); // Show the button when paused
  }
}

function video_start(e) {
	$('video').each((i,e) => {
		const container = $(e).parents('.video-container')
		const video = container.find('video')
		const play_btn = container.find('.play-button')

		play_btn.click((j) => {
		    j.stopPropagation(); // Prevents the container's event from firing immediately after
		    j.preventDefault()
		    video_toggle_play(container);
		    return false
		});

		// Click the video (or container) to toggle (mimics a standard player)
		container.click(() => video_toggle_play(container));

		// Ensure the button reappears if the video ends
		video.on('ended', () => {
		  play_btn.style.display = 'block';
		});
	})
}

function integrity_check(){
	var items = []
	var lasttop = 0
	var fit = 1	
	$('.category-item').each((index,element) => {
		const top = $(element).offset().top
		const name = $(element).attr('class').split(' ').map((i) => i.includes('col-md-') ? i : '').filter((i) => i)[0]

		if(!items[top]) {
			items[top] = []
		}

		items[top].push({element, index})
	})
	for(var i in items) {
		var sum = 0
		for(var j in items[i]){
			sum+= Math.round(colsizes_available[items[i][j].colsize])
		}
		for(var j in items[i]){
			const item = $($('.category-item').get(items[i][j].index)).find('.category-content')
			if(sum != 100) {
				fit = 0
				item.removeClass('border-success')
				item.addClass('border-danger')
			} else {
				item.addClass('border-success')
				item.removeClass('border-danger')
			}
		}
	}
	$('button[type="submit"]').prop('disabled', !(fit))
}


//Images
var drawImages = function(){
	var base_url 	= $("#slider_template").data('url');
	// console.log('drawImages(base_url)',base_url)
	var ul 			= $('#slider_block');
	ul.removeClass('fadeIn fadeOut').addClass('animation-fadeOut')
	setTimeout(() => {
		ul.empty();
		$.each(slides, function(index,item){
			const slide = item.Slide
			if(slide){
				var source   	= $("#slider_template").html();
				var template 	= Handlebars.compile(source);
				slide.video = slide.img_url.endsWith('.mp4')
				slide.img_url = base_url + slide.img_url
				var html = template(slide);
				ul.append(html);

				/*var parts = slide.split('-').reverse() 
				var context = {
					image: base_url+parts[0], 
					file: parts[0],
					video: parts[0].includes('.mp4'),
					orientation: parts[1] || 'mobile'
				}*/
			}
		});
		ul.removeClass('animation-fadeOut').addClass('animation-fadeIn')
	}, 1000);
}

$(document).ready(function() {
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

	$(document).on('click','.btn-toggle-form',function(e){
  	$(e.target).parents('.category-item').find('.category-form').toggle()
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


  

  $('.btn-update').click(e => {
  	var payload = []
		$('.category-item').each((i,e) => {
			const id = $(e).data('id')
			const ordernum = i+1
			const name = $(e).attr('class').split(' ').map((i) => i.includes('col-md-') ? i : '').filter((i) => i)[0]
			const align = $(e).find('.category-image').attr('class').split(' ').map((i) => i.includes('ci-') ? i : '').filter((i) => i)[0]
			const pos = $(e).find('.category-content').attr('class').split(' ').map((i) => i.includes('posnum-') ? i : '').filter((i) => i)[0]
			const posnum = parseInt(pos.replace('posnum-',''))
			const colsize = parseInt(name.replace('col-md-',''))
			const alignnum = parseInt(align.replace('ci-',''))
			payload.push({ 
				id, 
				posnum,
				alignnum, 
				ordernum, 
				colsize
			})
		})
		$.post('/admin/shop_composer', { payload }).then(() => {
			show_done()
		})
  })

  $('.update-alignnum').change(e => {
  	const val = $(e.target).val() || ''
  	const parent = $(e.target).parents('.category-item').find('.category-image');
  	parent.removeClass('ci-0 ci-1 ci-2 ci-3 ci-4 ci-5 ci-6 ci-7 ci-8')
  	parent.addClass('ci-'+val)
  	// integrity_check()
  })

  $('.update-posnum').change(e => {
  	const val = $(e.target).val() || ''
  	const parent = $(e.target).parents('.category-item').find('.category-content');
  	parent.removeClass('posnum-0 posnum-1 posnum-2 posnum-3 posnum-4 posnum-5 posnum-6 posnum-7 posnum-8')
  	parent.addClass('posnum-'+val)
  	// integrity_check()
  })


  /* runtime */
  setTimeout(() => {
  	drawImages();
  	//integrity_check()
  	//video_start()
  }, 100)
})

Handlebars.registerHelper('if_eq', function(a, b, opts) {
    if (a == b) { // Use '==' for standard comparison, or '===' for strict comparison
        return opts.fn(this); // Render the "if" block
    } else {
        return opts.inverse(this); // Render the "{{else}}" block
    }
});