$(document).ready(function() {
  $('.deletebutton').click(function(){                
    var id          = $(this).attr('data-id'),
  	urlback     = $(this).attr('data-url-back'),
  	delurl      = $(this).attr('data-delurl'),
  	msg         = $(this).attr('data-msg');            
    
    var r = confirm(msg);
    if (r == true){
      $.ajax({
        url: delurl,
        type: 'POST',
        data: 'id='+id,
        complete: function(xhr, textStatus) {
          //called when complete
        },
        success: function(data, textStatus, xhr) {
          window.location.href = urlback;
        },
        error: function(xhr, textStatus, errorThrown) {
          //called when there is an error
        }
      });         
    }       
  });
  //$('#example-datatables2').DataTable();
  $('#usuarios-datatables').DataTable({"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 10 ] } ] , "language": {"url": "/json/datatables-locale-es.json"}});
  $('#sucursales-datatables').DataTable({"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 6 ] } ] , "language": {"url": "/json/datatables-locale-es.json"}});

  $('#categorias-datatables').DataTable({
    "ordering": true,
    "language": {
      "url": "/json/datatables-locale-es.json"
    }
  });

  $('#example-datatables').DataTable({
    "ordering": true,
    "stateSave": true,
    "order": [[ 0, "desc" ]],
    "language": {
      "url": "/json/datatables-locale-es.json"
    }
  });

  $('#templates-datatables').DataTable({
    "ordering": true,
    "stateSave": true,
    "order": [[ 5, "desc" ]],
    "language": {
      "url": "/json/datatables-locale-es.json"
    }
  });

  $('#lists-datatables').DataTable({
    "ordering": true,
    "stateSave": true,
    "order": [[ 4, "desc" ]],
    "language": {
      "url": "/json/datatables-locale-es.json"
    }
  });

  $('#schedules-datatables').DataTable({
    "ordering": true,
    "stateSave": true,
    "order": [[ 6, "desc" ]],
    "language": {
      "url": "/json/datatables-locale-es.json"
    }
  });

  $('#banners-datatables').DataTable({
    "ordering": true,
    "language": {
      "url": "/json/datatables-locale-es.json"
    }
  });

  $('#searches-datatables').DataTable({
    "ordering": true,
    "language": {
      "url": "/json/datatables-locale-es.json"
    }
  });

  const table = $('.table').first()
  if(table.data('search')) {
    table.on('init.dt', function(e, settings) {      
      setTimeout(function(){
        $('.dataTables_filter').find('input[type="search"]').val(table.data('search'))
        $('.dataTables_filter').find('input[type="search"]').trigger('keyup')
      }, 500)
    })
  }

  /* $('#example-datatables').dataTable({"aoColumnDefs": [ 
    { "bSortable": false, "aTargets": [ 7 ] } 
  ] , "language": {"url": "/json/datatables-locale-es.json"}}); */
  $('#contacto-datatables').dataTable({"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 6 ] } ] , "language": {"url": "/json/datatables-locale-es.json"}});
  
  /*new $.fn.dataTable.Responsive($('#example-datatables'), {
    responsive: true,
    details: true
  });
  $('#myTable').DataTable( {
  responsive: true
} );*/
});