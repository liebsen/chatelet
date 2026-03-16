
CKEDITOR.replace('notification_value');

$(document).ready(function() {		
  $('#notification_tag').change(function(e) {
  	if($(this).val()) {
  		$('.notification-controls').fadeIn()
  	} else {
  		$('.notification-controls').fadeOut(0)
  	}
  })

  $('.btn-append-editor').click(function(){
		CKEDITOR.instances.notification_value.insertText($(this).data('text'));
  })
})
