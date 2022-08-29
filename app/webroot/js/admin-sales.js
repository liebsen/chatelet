$(document).ready(function() {
  // getTicket(10999)
  $('#example-datatables2').DataTable({
    "order": [],
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }
  })
})

var sale_id = 0

function editLogistic (sale_id, logistic_id) {
  const selectr = $('.logistic-selector')
  $(`#logistic_option_${logistic_id}`).click()
  $('.logistic_sale_id').text('')
  window.sale_id = 0
  if (selectr.hasClass('active')) {
    selectr.removeClass('active')
  } else {
    $('#logistic_sale_id').text(sale_id)
    $(`#logistic_option_${logistic_id}`).prop('disabled', true)
    selectr.addClass('active')
    window.sale_id = sale_id
  }
}

function logisticUpdate () {
  var selected = $("#update_logistic input[name='logistic_option']:checked")
  var name_selected = selected.data('name')
  $('#logistic_save_btn').text('Actualizando...')
  $.post('/admin/updateSaleLogistic/' + sale_id, {logistic_id: selected.val()}).then(res => {
    $(`#shipping_title_${sale_id}`).text(name_selected.toUpperCase())
    $('#logistic_save_btn').text('Actualizar')
    $('.logistic-selector').removeClass('active')
  })
}

function getTicket(sale_id, parent) {
  var target = undefined
  if (parent) {
    target = $(parent).next().next()
  }  
  $(parent).removeClass('btn-info')
  $(parent).addClass('btn-default')
  $(parent).text('ESPERE')
  $(target).text('')
  $.get('/admin/getTicket/' + sale_id, res => {
    $(parent).removeClass('btn-default')
    $(parent).addClass('btn-info')
    $(parent).text('TICKET')
    let data = JSON.parse(res)
    if (target) {
      $(target).text(data.message)
      $(target).addClass(`text-${data.status}`)
    }
    if (data.url) {
      window.open(data.url, data.shipping + sale_id, `height=${data.height},width=${data.width}`)
    }
  })
}    