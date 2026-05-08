$(document).ready(function() {
  $('#regenerate_password').click(function(e){
  	e.preventDefault()
  	e.stopPropagation()

    const names = [
      'Realmente deseas regenerar la contraseña para el usuario con id:',
      $('input[name="data[id]"]').val(),
      'con nombre:',
      $('input[name="data[name]"]').val(),
      $('input[name="data[surname]"]').val(),
      'con email:',
      $('input[name="data[email]"]').val()
    ];
    const question = names.join(' ')
    if(confirm(`¿${question}?`)) {
      $(this).prop('disabled', true)
      var btnSubmit = $(this)
      var txtResult = $(this).parent().find('.regenerate-result')
      var formData = new FormData()
      formData.append("ajax", "1")
      formData.append("data[User][email]", $('input[name="data[email]"]').val())

      btnSubmit.prop('disabled', true)
      btnSubmit.val('Regenerando...')

      txtResult.addClass('notification mt-2')
      txtResult.html('Modificando contraseña y notificando. Por favor espere...')

      $.ajax({
        url: '/users/forgot_password',
        type: 'POST',
        data: formData,
		    processData: false,
		    contentType: false,
        success: function(res) {
          if(res.success) {
              $.growl.notice({
                title: 'Datos de acceso actualizados',
                message: res.message
              });
            btnSubmit.prop('disabled', false)
            btnSubmit.val('Regenerar contraseña')
            txtResult.html(`${res.message}.<br>Nueva contraseña: <b>${res.newpass}</n>`)
          } else {
              $.growl.notice({
                title: 'Error al modificar contraseña de usuario',
                message: res.errors
              });
            txtResult.html(res.errors);
          }
          btnSubmit.prop('disabled', false)
          btnSubmit.val('Recuperar acceso')
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error: " + status + " - " + error);
          btnSubmit.prop('disabled', false)
          // Handle errors
        }
      });
    }
    return false
  })
})
