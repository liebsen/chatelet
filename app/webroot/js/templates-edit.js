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
})

/*CKEDITOR.on('dialogDefinition', function(ev) {
    var dialogName = ev.data.name;
    var dialogDefinition = ev.data.definition;

    if (dialogName == 'image') {
        var onOk = dialogDefinition.onOk;
        console.log('a(1)')
        dialogDefinition.onOk = function(e) {
            var dialog = this;
            console.log('a(2)')
            // Set default width (e.g., 600px)
            var widthField = dialog.getContentElement('info', 'txtWidth');
            console.log('a(3)',widthField)
            if (widthField) widthField.setValue('600');
            
            // Set default height (e.g., auto/null)
            var heightField = dialog.getContentElement('info', 'txtHeight');
            if (heightField) heightField.setValue(''); // Empty allows auto/proportional

            // Call the original onOk function
            if (onOk) onOk.apply(this, e);
        };
    }
});*/

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
