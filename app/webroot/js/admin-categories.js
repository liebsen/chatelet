
var category_id = 0
var discount_mode = ''

function layerClose() {
  $('body').css('overflow-y', 'auto')
  $('.fullhd-layer').removeClass('active')
}

function showLayer (e, layer, mode, category_id, category_name) {
  e.preventDefault()
  e.stopPropagation()
  window.category_id = 0
  window.discount_mode = mode
  const selectr = $(`.${layer}-layer`)
  $('.category_id').text('')
  $('.category_name').text('')

  var mode_str = mode == 'bank' ? ' Transferencia' : 'Mercado Pago'
  var title = `Descuento pagando con ${mode_str} para ${category_name}`
  $('.discount_mode').text(title)
  if (selectr.hasClass('active')) {
    selectr.removeClass('active')
  } else {
    $('.category_id').text(category_id)
    $('.category_name').text(category_name)
    window.category_id = category_id    
    selectr.addClass('active')
  }  
  return false
}

function categoryDiscount(){
  var button = $(`#discount_btn`)
  button.addClass('btn-disabled')
  button.text('Solicitando...')
  $.post('/admin/categoryDiscount', { 
    id: category_id, 
    mode: window.discount_mode,
    discount: $(`#discount`).val(),
    existent_only: $(`#existent_only`).prop('checked'),
  }).then(res => {
    let data = JSON.parse(res)
    if(data.status==='success'){
      button.text('Actualizar')
      alert(`Se actualizó correctamente ${data.conds}`)
      layerClose()
    } else {
      const message = data.message.replace(/\s+/g, ' ').trim()
      alert(`Algo salió mal: "${message}". Volvé a intentar en unos instantes`)
    }
  })
}


function done(){
  document.querySelector('.draggable-saved').classList.remove('chatOut')
  document.querySelector('.draggable-saved').classList.add('chatIn')
  setTimeout(() => {
    document.querySelector('.draggable-saved').classList.remove('chatIn')
    document.querySelector('.draggable-saved').classList.add('chatOut')
  }, 5000)
}

function batch(action){
  var ids = $("input:checkbox[name=checks]:checked").map(function(){
    return $(this).val();
  }).get()
  $.ajax({
    url: `/admin/batch_categorias/${action}`,
    type: 'POST',
    data: 'id='+ids,
    complete: function(xhr, textStatus) {
      done()
    },
    success: function(data, textStatus, xhr) {
      $("input:checkbox[name=checks]:checked").map(function(){
        if(action == 'remove') {
          $(this).parents('tr').remove()
        }
        if(action == 'disable') {
          $(this).parents('tr').addClass('bg-danger')
        }
        if(action == 'enable') {
          $(this).parents('tr').removeClass('bg-danger')
        }
      })        
      const res = JSON.parse(data)
      $('.result-message').text(res.message)
      $('.result-message').collapse('show')
      setTimeout(() => {
        $('.result-message').collapse('hide')
      }, 5000)
    },
    error: function(xhr, textStatus, errorThrown) {
      //called when there is an error
    }
  })
}
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

