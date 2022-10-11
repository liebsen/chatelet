$(document).ready(function() {
  // getTicket(10999)

  $('#expandall').click(e => {
    var active = $('.toggle-active').length
    $(e.target).parents('tr').find('.toggle-table').each((i,e) => {
      if (active) {
        $(e).addClass('toggle-table-hidden')
      } else {
        $(e).removeClass('toggle-table-hidden')
      }      
    })
    $('toggle-active').each((i,e) => {
      $(e).removeClass('toggle-active')
    })
  })

  $('#example-datatables2 tr:not(first)').click(e => {
    if($('.toggle-active').length) {
      $('.toggle-active').removeClass('toggle-active')
      $('.toggle-active').find('.toggle-table').each((i,e) => {
        $(e).toggleClass('toggle-table-hidden')
      })      
    }
    $(e.target).parents('tr').find('.toggle-table').each((i,e) => {
      $(e).toggleClass('toggle-table-hidden')
    })
    $(e.target).parents('table').find('thead').first('tr').find('.toggle-table').each((i,e) => {
      $(e).toggleClass('toggle-table-hidden')
    })
    if (!$(e.target).parents('tr').hasClass('toggle-active')) {
      $(e.target).parents('tr').addClass('toggle-active')
    }
  })

  $('#example-datatables2').DataTable({
    "order": [],
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }
  })
})

var sale_id = 0

function showLayer (e, layer, sale_id) {
  e.preventDefault()
  e.stopPropagation()
  window.sale_id = 0
  const selectr = $(`.${layer}-layer`)
  $('.sale_id').text('')
  if (selectr.hasClass('active')) {
    selectr.removeClass('active')
  } else {
    $('.sale_id').text(sale_id)
    window.sale_id = sale_id    
    selectr.addClass('active')
  }  
  return false
}
function editLogistic (e, sale_id, logistic_id) {
  e.preventDefault()
  e.stopPropagation()
  window.sale_id = 0
  const selectr = $('.logistic-layer')
  $('body').css('overflow-y', 'hidden')
  $('.sale_id').text('')
  $('#logistic_save_btn').text('Actualizar')
  $('#logistic_save_btn').addClass('btn-primary')
  $('#logistic_save_btn').removeClass('btn-success')
  $(`#logistic_option_${logistic_id}`).click()
  $('#update_logistic .form-check-input').each(e => {
    $(e).prop('disabled', false)
  })
  $(`#logistic_option_${logistic_id}`).prop('disabled', true)
  if (selectr.hasClass('active')) {
    selectr.removeClass('active')
  } else {
    $('.sale_id').text(sale_id)
    selectr.addClass('active')
    window.sale_id = sale_id
  }
  return false
}

function layerClose() {
  $('body').css('overflow-y', 'auto')
  $('.fullhd-layer').removeClass('active')
}

function logisticUpdate () {
  var selected = $("#update_logistic input[name='logistic_option']:checked")
  var name_selected = selected.data('name')
  $('#logistic_save_btn').text('Actualizando...')
  $.post('/admin/updateSaleLogistic/' + sale_id, {logistic_id: selected.val()}).then(res => {
    $(`#shipping_title_${sale_id}`).text(name_selected.toUpperCase())
    $('#logistic_save_btn').removeClass('btn-primary')
    $('#logistic_save_btn').addClass('btn-disabled')
    $('#logistic_save_btn').text('Actualizado')
    setTimeout(() => {
      layerClose()
    }, 1000)
  })
}

function getTicket(sale_id) {
  var parent = $(`#shipping_title_${sale_id}`)
  var target = $(parent).next().next()

  $(parent).removeClass('btn-info')
  $(parent).addClass('btn-disabled')
  $(parent).text('SOLICITANDO...')
  $(target).text('')

  $.get('/admin/getTicketFake/' + sale_id, res => {
    $(parent).removeClass('btn-default')
    $(parent).addClass('btn-primary')
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