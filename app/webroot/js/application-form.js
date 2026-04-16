function getFormData(form) {
  var data = new FormData();
  for (var i=0; i<form.length; i++) {
    var el = form[i];    
    if(el.name && $(el).data('change') && !$(el).data('noproc')) {
      const value = el.type == 'file' ? el.files[0] : el.value
      data.append(el.name, value)
    }
  }
  return data
}

$(document).ready(function() {
  $('input, select, textarea').change(function(e) {
    $(this).data('change', true)
    if($(this).attr('type') == 'file') {
      if (confirm("¿Deseas cargar este archivo ahora?")) {
        setTimeout(function(){
          $(this).data('change', false)
          return $.ajax({
            url: $('#form_app').attr('action'),
            type: 'POST',
            cache: false,
            data: getFormData(document.getElementById("form_app")),
            processData: false,  // Mandatory: stop jQuery from converting data to a string
            contentType: false,  // Mandatory: let browser set the correct multipart/form-data boundary
            success: function(res) {
              $.growl.notice({
                title: 'OK',
                message: res.message
              });              
              console.log('Success:', res);
            },
            error: function(xhr, status, error) {
              console.log(xhr)
              console.log(status)
              console.log(error)
              $.growl.error({
                title: 'Error',
                message: error
              });
              console.error('Error:', error);
            }
          });
        }, 10)
      }
    }
  })

	$('#form_app').submit(function(e){
		e.preventDefault()
    const url = $(this).attr('action')
    const data = getFormData(this)
		$.ajax({
      type: 'post',
      url: url, 
      data: data,
      processData: false, // Prevent jQuery from converting data to a string
      contentType: false, // Prevent jQuery from setting a default content-type header
    }).success(function(res){
			if(res.success) {
        $.growl.notice({
          title: 'OK',
          message: res.message
        });
			} else {
        $.growl.error({
          title: 'Error',
          message: res.errors
        });
			}
		}).fail(function(xhr, error){
      console.log('xhr',xhr)
      console.log('error',error)
      $.growl.error({
        title: 'Error',
        message: error
      });
		})
		return false;
	})
})