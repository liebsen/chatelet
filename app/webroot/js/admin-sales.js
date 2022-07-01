$(document).ready(function() {
  // getTicket(10999)
  $('#example-datatables2').DataTable({
    "order": [],
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }
  })
})

function getTicket(sale_id, parent) {
  var target = undefined
  if (parent) {
    target = $(parent).next().next()
  }  
  $(parent).text('Enviando...')
  $(target).text('')
  $.get('/admin/getTicket/' + sale_id, res => {
    $(parent).text('TICKET')
    let data = JSON.parse(res)
    let target = null

    if (target) {
      $(target).text(data.message)
      $(target).addClass(`text-${data.status}`)
    }
    if (data.url) {
      window.open(data.url, data.shipping + sale_id, `height=${data.height},width=${data.width}`)
    }
  })
}    
