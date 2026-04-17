function getFormData(form) {
  var data = new FormData();
  for (var i=0; i<form.length; i++) {
    var e = form[i];    
    if(e.name && $(e).data('change') && !$(e).data('noproc')) {
      var value = e.value
      if(e.type == 'file') {
        value = e.files[0]
      } else if(e.type == 'checkbox') {
        value = e.checked ? 1 : 0
      }
      data.append(e.name, value)
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
            },
            error: function(xhr, status, error) {
              $.growl.error({
                title: 'Error',
                message: error
              });
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
      setTimeout(function(){
        if(res.redirect) {
          location.href = res.redirect
        }
      }, 2000)
		}).fail(function(xhr, error){
      $.growl.error({
        title: 'Error',
        message: error
      });
		})
		return false;
	})
})