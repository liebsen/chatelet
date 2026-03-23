$(document).ready(function() {

})

$(document).on('click', '.btn-stats', function(e){
  $.growl.notice({
    title: 'Stats',
    message: JSON.stringify($(this).data()),
  });
})
