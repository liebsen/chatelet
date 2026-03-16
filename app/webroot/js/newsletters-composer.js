
CKEDITOR.replace('newsletter');

$(document).ready(function() {

  console.log('hola')
  $('.btn-append-editor').click(function(){
		CKEDITOR.instances.newsletter.insertText($(this).data('text'));
  })
})
