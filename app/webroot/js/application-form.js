	$(document).ready(function() {		
		$('#form_app').submit(function(e){
			e.preventDefault()
      const me = $(this),
	      data = me.serialize(),
	      url = me.attr('action');
			$.post(url, data)
				.success(function(res){

					if(res.success) {
            $.growl.notice({
              title: 'OK',
              message: res.message
            });
					} else {
            $.growl.error({
              title: 'OK',
              message: res.errors
            });
					}
				})
				.fail(function(){
          $.growl.error({
            title: 'OK',
            message: res.errors
          });
				})
			return false;
		})
	})