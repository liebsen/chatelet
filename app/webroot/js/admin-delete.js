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
  $('#example-datatables2').DataTable();
  $('#usuarios-datatables').DataTable({"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 10 ] } ] , "language": {"url": "/json/datatables-locale-es.js"}});
  $('#sucursales-datatables').DataTable({"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 6 ] } ] , "language": {"url": "/json/datatables-locale-es.js"}});

  $('#categorias-datatables').DataTable({
    "ordering": false,
    "language": {
      "url": "/json/datatables-locale-es.js"
    }
  });

  $('#example-datatables').DataTable({
    "ordering": false,
    "stateSave": true,
    "language": {
      "url": "/json/datatables-locale-es.js"
    }
  });

  $('#banners-datatables').DataTable({
    "ordering": false,
    "language": {
      "url": "/json/datatables-locale-es.js"
    }
  });

  $('#searches-datatables').DataTable({
    "ordering": false,
    "language": {
      "url": "/json/datatables-locale-es.js"
    }
  });

  /* $('#example-datatables').dataTable({"aoColumnDefs": [ 
    { "bSortable": false, "aTargets": [ 7 ] } 
  ] , "language": {"url": "/json/datatables-locale-es.js"}}); */
  $('#contacto-datatables').dataTable({"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 6 ] } ] , "language": {"url": "/json/datatables-locale-es.js"}});
  
  /*new $.fn.dataTable.Responsive($('#example-datatables'), {
    responsive: true,
    details: true
  });
  $('#myTable').DataTable( {
  responsive: true
} );*/
});