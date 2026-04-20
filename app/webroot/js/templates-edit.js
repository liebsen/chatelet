CKEDITOR.replace('newsletter', {
  height: 500,
  on: {
    uiReady: function(e) {
      console.log('e.editor.name',e.editor.name)
      var toolbar = document.getElementById('cke_1_toolbox');
      toolbar.style.display = 'none';
    },
    maximize: function(e) {
      var toolbar = document.getElementById('cke_1_toolbox');
      if (e.data === 1) { // 1 = Maximized
          toolbar.style.display = 'block';
      } else { // 2 = Minimized (Normal)
        toolbar.style.display = 'none';
      }
    }
  }
});

$(document).ready(function() {
  $('.btn-templates-editor').click(function(){
    CKEDITOR.instances.newsletter.execCommand('maximize');
  })

  $('.append-editor').click(function(){
		CKEDITOR.instances.newsletter.insertText($(this).data('text'));
  })

  if(window.location.hash.includes('editor')){
    setTimeout(function(){
      CKEDITOR.instances.newsletter.execCommand('maximize');  
    }, 100)    
  }

  CKEDITOR.instances.newsletter.on('change', function(e) {
    $('#newsletter').val(CKEDITOR.instances.newsletter.getData())
    $('#newsletter').data('change', true)
  });  
})
