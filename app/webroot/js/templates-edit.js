CKEDITOR.on('dialogDefinition', function(ev) {
  var dialogName = ev.data.name;
  var dialogDefinition = ev.data.definition;

  // Check if the dialog is the "image" dialog
  if (dialogName == 'image') {
    // Get the "info" tab
    var infoTab = dialogDefinition.getContents('info');
    
    // Remove width and height fields
    infoTab.remove('txtWidth');
    infoTab.remove('txtHeight');
    
    // Optional: Remove the "Lock proportions" icon
    infoTab.remove('ratioLock');
  }
});

CKEDITOR.replace('newsletter', {
  height: 500,
  on: {
    uiReady: function(e) {
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

function update_editor() {
	$('#newsletter').val(CKEDITOR.instances.newsletter.getData())
	$('#newsletter').data('change', true)   
}

$(document).ready(function() {
  $('.btn-templates-editor').click(function(){
    CKEDITOR.instances.newsletter.execCommand('maximize');
  })

  $('.append-editor').click(function(){
		CKEDITOR.instances.newsletter.insertText($(this).data('text'));
		update_editor()
  })

  if(window.location.hash.includes('editor')){
    setTimeout(function(){
      CKEDITOR.instances.newsletter.execCommand('maximize');  
    }, 100)    
  }

	CKEDITOR.instances.newsletter.on('mode', function() {
    if (this.mode === 'source') {
      var editable = CKEDITOR.instances.newsletter.editable();
      editable.attachListener(editable, 'input', update_editor);
  	}
	});

  CKEDITOR.instances.newsletter.on('change', update_editor);
})
