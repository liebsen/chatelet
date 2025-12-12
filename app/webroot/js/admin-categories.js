
var category_id = 0
var discount_mode = ''

function layerClose() {
  $('body').css('overflow-y', 'auto')
  $('.layer').removeClass('active')
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
  // var title = `Descuento pagando con ${mode_str} para ${category_name}`
  var title = `${mode_str} en ${category_name}`
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
