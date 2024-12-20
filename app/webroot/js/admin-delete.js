$(document).ready(function() {

  function done(){
    document.querySelector('.draggable-saved').classList.remove('chatOut')
    document.querySelector('.draggable-saved').classList.add('chatIn')
    setTimeout(() => {
      document.querySelector('.draggable-saved').classList.remove('chatIn')
      document.querySelector('.draggable-saved').classList.add('chatOut')
    }, 5000)
  }

  function batch(action){
    var ids = $("input:checkbox[name=checks]:checked").map(function(){
      return $(this).val();
    }).get()
    $.ajax({
      url: `/admin/batch_productos/${action}`,
      type: 'POST',
      data: 'id='+ids,
      complete: function(xhr, textStatus) {
        done()
      },
      success: function(data, textStatus, xhr) {
        $("input:checkbox[name=checks]:checked").map(function(){
          if(action == 'remove') {
            $(this).parents('tr').remove()
          }
          if(action == 'disable') {
            $(this).parents('tr').addClass('bg-danger')
          }
          if(action == 'enable') {
            $(this).parents('tr').removeClass('bg-danger')
          }
        })        
        const res = JSON.parse(data)
        $('.result-message').text(res.message)
        $('.result-message').collapse('show')
        setTimeout(() => {
          $('.result-message').collapse('hide')
        }, 5000)
      },
      error: function(xhr, textStatus, errorThrown) {
        //called when there is an error
      }
    })
  }
  $('.enableselection').click(function(e){
    e.preventDefault()
    batch('enable')
  })
  $('.disableselection').click(function(e){
    e.preventDefault()
    batch('disable')
  })
  $('.removeselection').click(function(e){
    e.preventDefault()
    batch('remove')
  })

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
  $('#usuarios-datatables').DataTable({"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 10 ] } ] , "language": {"url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"}});
  $('#sucursales-datatables').DataTable({"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 6 ] } ] , "language": {"url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"}});

  $('#categorias-datatables').DataTable({
    "ordering": false,
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }
  });

  $('#example-datatables').DataTable({
    "ordering": false,
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }
  });

  $('#banners-datatables').DataTable({
    "ordering": false,
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }
  });

  $('#searches-datatables').DataTable({
    "ordering": false,
    "language": {
      "url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }
  });

  /* $('#example-datatables').dataTable({"aoColumnDefs": [ 
    { "bSortable": false, "aTargets": [ 7 ] } 
  ] , "language": {"url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"}}); */
  $('#contacto-datatables').dataTable({"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 6 ] } ] , "language": {"url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"}});
  
  /*new $.fn.dataTable.Responsive($('#example-datatables'), {
    responsive: true,
    details: true
  });
  $('#myTable').DataTable( {
  responsive: true
} );*/
});