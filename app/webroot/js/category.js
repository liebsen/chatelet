$(document).ready(function() {

  let last_alternate = ""
  $('#alternatename').click(function(){
    if($('.alternate_name_block').is(':visible')) {
      if($('#alternate_name_target').val()){
        last_alternate = $('#alternate_name_target').val()
        $('#alternate_name_target').val('')
        $('#alternatename_restore').toggle()
      }
    }
    $('.alternate_name_block').toggle()
  });

  $('#alternatename_restore').click(function(){
    $('#alternate_name_target').val(last_alternate)
    $('#alternatename_restore').hide()
    $('.alternate_name_block').show()
  });
});