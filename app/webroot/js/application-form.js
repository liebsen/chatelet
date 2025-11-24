	$(document).ready(function() {		


		$('#form_app').submit(function(e){
			e.preventDefault()
      const me = $(this),
	      data = me.serialize(),
	      url = me.attr('action');

			$('input[type="checkbox"]').each(function(e,i){
				console.log({id:i.id})
				console.log({i:$(i)})
				//console.log({id:i.id})
				// $(this).val($(this).is(':checked') ? 'on' : 'off')
			})

			/*const arr_unchecked_values = $('input[type=checkbox]:not(:checked)').map(function(e,i){
				console.log({e},{i})
				return { [i]: 'off'}}
			);*/
			//console.log({arr_unchecked_values})

			$.post(url, data)
				.success(function(res){
					console.log({res})
					if(res.success) {
						alert(res.message)
					} else {
						alert(res.errors)	
					}
				})
				.fail(function(){
					alert('error', res.errors)
				})

			return false;
		})
	})