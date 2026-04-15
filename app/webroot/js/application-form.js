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
    if(el.name) {
      if ('defaultValue' in el && (el.defaultValue !== el.value || el.type == 'hidden')) {
        els[el.name] = el.value
      }
    }
  }
  return els;
}

$(document).ready(function() {		
	$('#form_app').submit(function(e){
		e.preventDefault()
		$.ajax({
      type: 'post',
      url: $(this).attr('action'), 
      data: formWithChanges(this),
    }).success(function(res){
			if(res.success) {
        $.growl.notice({
          title: 'OK',
          message: res.message
        });
			} else {
        $.growl.error({
          title: 'Error',
          message: res.errors
        });
			}
		}).fail(function(xhr, error){
      console.log('xhr',xhr)
      console.log('error',error)
      $.growl.error({
        title: 'Error',
        message: error
      });
		})
		return false;
	})
})