$(document).ready(function() {
  // getTicket(10999)

  $('#printbtn').click(e => {
    console.log('printbtn')
    // restore original view
    $('.toggle-table').each((i,e) => {
      if ($(e).hasClass('toggle-table-hidden')) {
        $(e).removeClass('toggle-table-hidden')
      }
    })
    setTimeout(() => {
      $('.toggle-table').each((i,e) => {
        $(e).addClass('toggle-table-hidden')
      })      
    }, 1000)
    return window.print()
  })
  $('#expandall').click(e => {
    // var active = $('.toggle-active').length
    $('.toggle-table').each((i,e) => {
      if ($(e).hasClass('toggle-table-hidden')) {
        $(e).removeClass('toggle-table-hidden')
        $('#expandall').text('Contraer todo')
      } else {
        $('#expandall').text('Expandir todo')
        $(e).addClass('toggle-table-hidden')
      }      
    })
    $('.toggle-active').each((i,e) => {
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
  var image_selected = selected.data('image')
  $('#logistic_save_btn').text('Actualizando...')
  $.post('/admin/updateSaleLogistic/' + sale_id, {logistic_id: selected.val()}).then(res => {
    //$(`#shipping_title_${sale_id}`).text(name_selected.toUpperCase())
    $(`#shipping_image_${sale_id}`).css({backgroundImage: `url(${image_selected})`})
    $('#logistic_save_btn').removeClass('btn-primary')
    $('#logistic_save_btn').addClass('btn-disabled')
    $('#logistic_save_btn').text('Actualizado')
    setTimeout(() => {
      layerClose()
    }, 3000)
  })
}

function getTicket() {
  var row = $(`#shipping_title_${sale_id}`)
  var button = $('#ticket_get_btn')
  button.addClass('btn-disabled')
  button.text('Solicitando...')
  $.get('/admin/getTicket/' + sale_id, res => {
    let data = JSON.parse(res)
    if(data.status==='success'){
      button.removeClass('btn-disabled')
      button.text('Generar')
      row.prop("onclick", null)
      row.className = ''
      row.addClass(`text-${data.status}`)
      if (data.url && confirm('¿Querés ver el ticket?')) {
        window.open(data.url, data.shipping + sale_id, `height=${data.height},width=${data.width}`)
      }
      button.after(`<span>${data.message}</span>`)
      setTimeout(() => {
        layerClose()
      }, 3000)
    } else {
      alert('Algo salió mal. Volvé a intentar en unos instantes')
    }
  })
}

function setComplete(){
  var row = $(`#bank_title_${sale_id}`)
  var button = $('#ticket_get_btn')
  button.addClass('btn-disabled')
  button.text('Solicitando...')
  $.get('/admin/saleComplete/' + sale_id, res => {
    let data = JSON.parse(res)
    if(data.status==='success'){
      row.className = ''
      row.text(`Aprobado`)
      row.removeClass('text-info')
      row.removeClass('text-success')
      row.addClass(`text-${data.status}`)
      if($('#generate_ticket_from_bank').is(':checked')){
        getTicket(sale_id)
      }
    } else {
      alert('Algo salió mal. Volvé a intentar en unos instantes')
    }
  })
}
