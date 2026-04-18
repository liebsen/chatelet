  
//CKEDITOR.replace('notification_value');

$(document).ready(function() {		
  $('#notification_tag').change(function(e) {
    const selected = $(this).val()
    const title = $(`input[name="data[${selected}_title]"]`).val()
    const text = $(`input[name="data[${selected}_text]"]`).val()
  	if(selected) {
      $('#notification_title').val(title)
      $('#notification_text').val(text)
  		$('.notification-controls').removeClass('d-disable')
  	} else {
      $('.notification-controls').addClass('d-disable')
    }
  })

  $('#notification_title').change(function(){
    const selected = $('#notification_tag').val()
    const input = $(`input[name="data[${selected}_title]"]`)
    input.data('change', true)
    input.val($(this).val())
  })

  $('#notification_text').change(function(){
    const selected = $('#notification_tag').val()
    const input = $(`input[name="data[${selected}_text]"]`)
    input.data('change', true)
    input.val($(this).val())
  })

  $('.append-editor').click(function(){
    insertAtCursor(document.getElementById('notification_text'), $(this).data('text'))
    $('#notification_text').trigger('change')
  })
})
