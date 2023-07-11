
var category_id = 0

function layerClose() {
  $('body').css('overflow-y', 'auto')
  $('.fullhd-layer').removeClass('active')
}

function showLayer (e, layer, mode, category_id, category_name) {
  e.preventDefault()
  e.stopPropagation()
  window.category_id = 0
  const selectr = $(`.${layer}-layer`)
  $('.category_id').text('')
  $('.category_name').text('')
  $('.discount_mode').text(mode)
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

function categoryDiscount(type){
  var button = $(`#discount_btn`)
  button.addClass('btn-disabled')
  button.text('Solicitando...')
  $.post('/admin/categoryDiscount', { 
    id: category_id, 
    type: type,
    discount: $(`#discount`).val(),
    existent_only: $(`#existent_only`).prop('checked'),
  }).then(res => {
    let data = JSON.parse(res)
    if(data.status==='success'){
      button.text('Actualizar')
      alert(`Se actualizó correctamente`)
      layerClose()
    } else {
      const message = data.message.replace(/\s+/g, ' ').trim()
      alert(`Algo salió mal: "${message}". Volvé a intentar en unos instantes`)
    }
  })
}
