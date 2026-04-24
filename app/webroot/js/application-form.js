function setFormData(key,value) {
  $(key).val(value)
  $(key).data('change',true)
}

function getFormData(form) {
  var data = new FormData();
  for (var i=0; i<form.length; i++) {
    var e = form[i]
    if(($(e).data('change') || $(e).data('force')) && !$(e).data('exclude')) {
      var value = e.value.trim()
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
    const elem = e.target
    $(elem).data('change', true)
    if($(elem).attr('type') == 'file') {
      const matches = $(elem).attr('name').match(/\[(.*?)\]/)
      if(matches[1]) {
        const tempUrl = URL.createObjectURL(elem.files[0])
        $(`#${matches[1]}`).attr('src', tempUrl);
      }
      if (confirm("¿Deseas cargar este archivo ahora?")) {
        setTimeout(function(){
          const data = getFormData(document.getElementById("form_app"))
          if(!data) return false
          $(this).data('change', false)
          return $.ajax({
            url: $('#form_app').attr('action'),
            type: 'POST',
            cache: false,
            data: data,
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
        if(res.lastid) {
          $('input[name="data[id]"]').val(res.lastid)
        }
			} else {
        $.growl.error({
          title: 'Error',
          message: res.errors
        });
			}
      if(res.redirect) {
        setTimeout(function(){
          location.href = res.redirect
        }, 2000)
      }
		}).fail(function(xhr, error){
      $.growl.error({
        title: 'Error',
        message: error
      });
		})
		return false;
	})
})