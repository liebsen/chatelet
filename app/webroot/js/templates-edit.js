$(document).ready(function() {
  $('.btn-templates-preview,.templates-preview').click(function(){
    $('.templates-preview').toggleClass('d-none')
  })
  $('.btn-append-editor').click(function(){
		CKEDITOR.instances.newsletter.insertText($(this).data('text'));
  })
})

CKEDITOR.replace('newsletter');
