$(document).ready(function() {
  $('.btn-append-editor').click(function(){
		CKEDITOR.instances.newsletter.insertText($(this).data('text'));
  })
})

CKEDITOR.replace('newsletter');
