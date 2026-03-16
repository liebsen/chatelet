function initChangeDetection(form) {
  for (var i=0; i<form.length; i++) {
    var el = form[i];
    el.dataset.origValue = el.value;
  }
}
function formHasChanges(form) {
  for (var i=0; i<form.length; i++) {
    var el = form[i];
    if ('origValue' in el.dataset && el.dataset.origValue !== el.value) {
      return true;
    }
  }
  return false;
}
function formWithChanges(form) {
	var els = {}
  for (var i=0; i<form.length; i++) {
    var el = form[i];
    if ('defaultValue' in el && el.defaultValue !== el.value) {
      els[el.name] = el.value
    }
  }
  return els;
}

$(document).ready(function() {		
	$('#form_app').submit(function(e){
		e.preventDefault()
		$.post($(this).attr('action'), formWithChanges(this))
			.success(function(res){
				if(res.success) {
          $.growl.notice({
            title: 'Tarea exitosa',
            message: res.message
          });
				} else {
          $.growl.error({
            title: 'Error al realizar tarea',
            message: res.errors
          });
				}
			})
			.fail(function(){
        $.growl.error({
          title: 'Error al realizar tarea',
          message: res.errors
        });
			})
		return false;
	})
})