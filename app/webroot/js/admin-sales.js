$(document).ready(function() {
      
  $('#example-datatables2').DataTable({"language": {"url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"}});
});

function getTicket(sale_id, parent) {
  $(parent).text('Imprimiendo...')
  $.get('/admin/getTicket2', res => {
    let item = JSON.parse(res)
    $(parent).text(item.message)
    console.log(item)
  })
}    
