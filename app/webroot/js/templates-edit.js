
CKEDITOR.replace('newsletter', { height: 500 });

$(document).ready(function() {

  $('.btn-templates-editor').click(function(){
    CKEDITOR.instances.newsletter.execCommand('maximize');
  })

  $('.btn-append-editor').click(function(){
		CKEDITOR.instances.newsletter.insertText($(this).data('text'));
  })

  if(window.location.hash.includes('editor')){
    setTimeout(function(){
      CKEDITOR.instances.newsletter.execCommand('maximize');  
    }, 500)    
  }
})
