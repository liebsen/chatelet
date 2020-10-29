$(document).ready(function() {
      
  $('#example-datatables2').DataTable({"language": {"url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"}});
});

function getTicket(sale_id, parent) {
  $(parent).text('Espere...')
  $.get('/admin/getTicket', res => {
    $(parent).text('TICKET')
    let data = JSON.parse(res)
    let target = $(parent).next()
    $(target).text(data.message)
    $(target).addClass(`text-${data.status}`)
    console.log(data)
    if (data.url) {
      window.open(data.url, 'OCA', `height=${window.screen.availHeight},width=${window.screen.availWidth}`)
    }
  })
}    
