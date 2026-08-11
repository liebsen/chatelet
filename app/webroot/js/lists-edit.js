$(document).ready(function() {
  $('.datepicker').on('changeDate', function(e) {
    const selectedDate = $(this).val()
    const selectedName = $(this).data('name');
    const selectedMode = $(this).data('mode');
    $(this).data('change', true)
    $('input[name="search_mode"]').val(selectedMode)
    $('.'+selectedName+'-value').text(selectedDate)
    updateUsers()
  })

  $('select.filter-type').change(function(e){
    $('.filter-item').addClass('d-none')
    if($(this).val()) {
      $('.relations-add-all').addClass('d-none')
    } else {
      $('.relations-add-all').removeClass('d-none')
    }
    const target = $(this).find(':selected').data('target')
    const text = $(this).find(':selected').text()
    setTimeout(function(){
      $('.filter-type-value').text(text)
      $(`.filter-${target}`).removeClass('d-none')
    },10)
  })

  $('input.advanced-filter').change(function(e){
  	console.log('input.advanced-filter')
    const value = $(this).val() || 0
    $('input[name="search_mode"]').val('sale')
    $('.min_sale-value').text('$'+ (value * 100))
    updateUsers()
  })

/*$('input.advanced-filter').datepicker().on('changeDate', function(e) {
	  	console.log('input.advanced-filter(1)')
    console.log(e.date);
});*/
  $('select.filter-type').change()
})
var tineout_reach = 0
function updateUsers(){
	clearTimeout(tineout_reach)
	tineout_reach = setTimeout(function(){
	  const relation = {
	    parentId: $('input[name="data[id]"]').val(),
	    type: 'user',
	    source: 'list',
	    model: 'NewsletterUser'
	  }  
	  var data = {}
	  $('.advanced-filter:visible').each(function(i,e){
	    data[$(e).data('name')] = sanitizeDate($(e).val())
	  })
	  $.ajax({
	    type: "POST",
	    url: "/admin/newsletters_users_reach",
	    data: data,
	    success: function (res) {
	      let str = ''
	      let ids = []
	      let filter = []
	      let refs = []
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
	          } else {
	          	refs.push(item)
	          }
	        })
	      }
	      if(filter.length){
	        $('.relations-count').text(filter.length)
	        $('.relations-add').removeClass('d-none')
	        $.each(filter, function(key, item) {
	          $('.user-container').append('<span class="label relation-item text-lowercase is-clickable" data-parent-id="'+relation.parentId+'" data-id="'+item.id+'" data-type="'+relation.type+'" data-source="'+relation.source+'" data-model="'+relation.model+'">'+item.email+'</span>');
	        })
	        $.growl.notice({
	          title: 'Encontramos algo',
	          message: `Se encontraron ${filter.length} coincidencias`,
	          queue: true,
	        });        
	      } else {
	      	var message = 'No se encontraron clientas para este filtro'
	      	if(refs.length){
	      		message = 'Se encontraron ' + refs.length + ' clientas que ya se encuentran en el listado actual'
	      	}
	        //$('.relations-add').addClass('d-none')
	        $.growl.notice({
	          title: 'Atención',
	          message: message,
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
	}, 100)
}
