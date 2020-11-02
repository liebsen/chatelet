$(document).ready(function() {
      
  $('#example-datatables2').DataTable({"language": {"url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"}});
});

function getTicket(sale_id, parent) {
  $(parent).text('Enviando...')
  $.get('/admin/getTicket/' + sale_id, res => {
    $(parent).text('TICKET')
    let data = JSON.parse(res)
    let target = $(parent).next().next()
    $(target).text(data.message)
    $(target).addClass(`text-${data.status}`)
    if (data.url) {
      window.open(data.url, 'OCA' + sale_id, `height=460,width=320`)
    }
  })
}    
