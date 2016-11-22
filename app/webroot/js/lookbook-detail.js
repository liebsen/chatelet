$(document).ready(function() {
	var addItem = function( me , list , type ){
		var count = $('.list-group').find('li').length;

		var	extrafields = '<div class="colorSelector" style="opacity:0">'+
                            '<div style="background-color: #ffffff;"></div>'+
                          '</div>';

        var prod = $('.code_sel').html();
          		
		$('#producto').append(
			'<li class="list-group-item">' +
			  extrafields +
              '<select class="code_sel" name="props['+ count +'][id]">'+prod+'</select>'+
	          '<div class="right">' +
	            '<a class="btn btn-xs btn-danger remove-item">Borrar</a>' +
	          '</div>' +
	        '</li>'
        );
	}

	$('.add-item').click(function() { 
		addItem( $(this) , $(this).siblings('ul') , $(this).siblings('ul').attr('id') );
	});

	var clearDetails = function() {
		$('#producto').empty();
	}

	$(document).on('click', '.remove-item', function() {
		var me = $(this);
		// Remove item that I'm in
		me.closest('li').remove();
	});
});