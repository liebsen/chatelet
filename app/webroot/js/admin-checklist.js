var checkIds = []
var disabledIds = []
var enabledIds = []

function batch(action){
  const method = $('.form-actions').data('url')
  $.ajax({
    url: `${method}/${action}`,
    type: 'POST',
    data: 'id='+checkIds.join(','),
    complete: function(xhr, textStatus) {
      done()
    },
    success: function(data, textStatus, xhr) {
      for(const i of checkIds){
        const tr = $(`tr[data-id=${i}]`)
        if(action == 'remove') {
          tr.remove()
        }
        if(action == 'disable') {
          tr.addClass('bg-danger')
          disabledIds = checkIds
          enabledIds = enabledIds.filter((e) => !checkIds.includes(e))
        }
        if(action == 'enable') {
          tr.removeClass('bg-danger')
          enabledIds = checkIds
          disabledIds = disabledIds.filter((e) => !checkIds.includes(e))
        }
      }      
      const res = JSON.parse(data)
      $('.result-message').text(res.message)
      $('.result-message').collapse('show')
      unselectAll()
      setTimeout(() => {
        $('.result-message').collapse('hide')
      }, 5000)
    },
    error: function(xhr, textStatus, errorThrown) {
      //called when there is an error
    }
  })
}

function unselectAll(){
  $("input:checkbox[name=checks]:checked").prop('checked', false)
  $("input:checkbox[name=checksAll]").prop('checked', false)
  checkIds = []
  updateMessage()
}

function updateMessage(){
  let message = ''
  if(checkIds.length) {
  const s = checkIds.length > 1 ? 's' : ''
  message = `Hay ${checkIds.length} elemento${s} seleccionado${s} <a href="javascript:void(0)" onclick="unselectAll()"> Borrar</a> `
  }
  $('.selection-count').html(message)
}

$('#example-datatables').on('draw.dt', function() {
  $("input:checkbox[name=checks]:checked").map(function(){
    const id = $(this).val()
    if(disabledIds.includes(id)){
      $(this).parents('tr').addClass('bg-danger')
    } else {
      $(this).parents('tr').removeClass('bg-danger')
    }
    $(this).prop('checked', false)
  })
});

function done(){
  document.querySelector('.draggable-saved').classList.remove('chatOut')
  document.querySelector('.draggable-saved').classList.add('chatIn')
  unselectAll()
  setTimeout(() => {
    document.querySelector('.draggable-saved').classList.remove('chatIn')
    document.querySelector('.draggable-saved').classList.add('chatOut')
  }, 5000)
}

$(document).ready(function() {
  $("input:checkbox[name=checksAll]").click(function(e){
    const checked = $(this).is(':checked')
    $("input:checkbox[name=checks]").map(function(){
      $(this).click(); 
      //$(this).prop('checked', checked)
    })
  })

  $("input:checkbox[name=checks]").click(function(e){
    const el = $(e.target)
    const id = el.val()
    
    checkIds = checkIds.filter((e) => e != id)
    if(el.is(":checked")){
      checkIds.push(id)
    }
    updateMessage()
  })

  $('.enableselection').click(function(e){
    e.preventDefault()
    batch('enable')
  })
  $('.disableselection').click(function(e){
    e.preventDefault()
    batch('disable')
  })
  $('.removeselection').click(function(e){
    e.preventDefault()
    batch('remove')
  })
})