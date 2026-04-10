$(document).ready(function() {

  let clock = 0

  $('.btn-updates-chedules').click(function(e){
    e.preventDefault()
    updateSchedules()
  })
})

function updateSchedules(){
  const relation = {
    parentId: $('input[name="data[id]"]').val(),
    type: 'user',
    source: 'list',
    model: 'NewsletterUser'
  }  
  var data = {}
  $('.advanced-filter').each(function(i,e){
    data[$(e).data('name')] = $(e).val()
  })
  data['search_mode'] = $('input[name="search_mode"]').val()
  $.ajax({
    type: "POST",
    url: "/admin/schedules_update",
    data: data,
    success: function (res) {
      let str = ''
      let ids = []
      let filter = []
      //$('.search-more').html('')
      $('.user-container > .label:not(.is-enabled)').remove()
      $('.user-container > .label').each(function(key, item) {
        const id = $(item).data('id')
        ids.push(id)
      })
      if(res.results.length) {
        $.each(res.results, function(key, item) {
          const id = parseInt(item.id)
          if ($.inArray(id, ids) === -1) {
            filter.push(item)
          }
        })
      }
      if(filter.length){
        $('.relations-count').text(filter.length)
        $('.relations-action-add').removeClass('d-none')
        $.each(filter, function(key, item) {
          $('.user-container').append('<span class="label user-item text-lowercase is-clickable" data-parent-id="'+relation.parentId+'" data-id="'+item.id+'" data-type="'+relation.type+'" data-source="'+relation.source+'" data-model="'+relation.model+'">'+item.email+'</span>');
        })
        $.growl.notice({
          title: 'Encontramos algo',
          message: `Se encontraron ${filter.length} coincidencias`,
          queue: true,
        });        
      } else {
        //$('.relations-action-add').addClass('d-none')
        $.growl.notice({
          title: 'Atención',
          message: 'No se encontraron cuentas para este filtro',
          queue: true,
        });        
      }
    },
    error: function (xhr, error) {
      console.log("Error(xhr):"+xhr)
      console.log("Error(error):"+error)
      //oPrnt.find("ul.result").html('<li><b>No Results</b></li>');
    }
  }).then(() => {
    setTimeout(() => {
      $('#products-filter').removeClass('searching')
    }, 100)
  })   
}

