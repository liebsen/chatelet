
//CKEDITOR.replace('notification_value');

$(document).ready(function() {		
  $('#notification_tag').change(function(e) {
    const selected = $(this).val()
    const title = $(`input[name="data[${selected}_title]"]`).val()
    const text = $(`input[name="data[${selected}_text]"]`).val()
  	if(selected) {
      $('#notification_title').val(title)
      $('#notification_text').val(text)
  		$('.notification-controls').removeClass('d-none')
  	}
  })

  $('#notification_title').change(function(){
    const selected = $('#notification_tag').val()
    $(`input[name="data[${selected}_title]"]`).val($(this).val())
  })

  $('#notification_text').change(function(){
    const selected = $('#notification_tag').val()
    $(`input[name="data[${selected}_text]"]`).val($(this).val())
  })

  $('.btn-append-editor').click(function(){
    insertAtCursor(document.getElementById('notification_text'), $(this).data('text'))
    $('#notification_text').trigger('change')
  })
})
