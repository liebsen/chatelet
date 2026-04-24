$(document).ready(function() {
  let clock = 0
  const schedule_hour = $('.schedule_hour')
  const now = new Date()
  const schedule_hour_value =schedule_hour.data('value') || now.getHours()
  var hour_options = ''

  for(var i=0; i<24; i++){
    var selected = ''
    if(schedule_hour_value == i) {
      selected = ' selected'
    }
    hour_options+= `<option value="${i}"${selected}>${i}:00hs</option>`
  }

  schedule_hour.append(hour_options)

  $('.btn-templates-preview,.templates-preview').click(function(){
    $('.templates-preview').toggleClass('d-none')
  })
  
  $('select.advanced-filter').on('changeDate', function(event) {
    const selectedDate = $(event.target).val()
    const selectedName = $(event.target).data('name');
    $('.'+selectedName+'-value').text(selectedDate)
    updateUsers()
  })

  $('.btn-reset-ask').click(function(e){
    e.preventDefault()
    $.growl.notice({
      title: 'Reenviar campaña',
      message: $('#reset_content').html(),
      duration: 5000000
    });
  })

  $(document).on('click', '.btn-reset', function(e){
    setFormData('#reset',1)
    setFormData('#reset_all',$('input[name="toggle_reset"]').val())
    $('button[type="submit"]').trigger('click')
  })

  $('input.advanced-filter').change(function(e){
    const value = $(this).val() || 0
    $('.min_sale-value').text('$'+ (value * 100))
    updateUsers()
  })

  /*let interval = 0
  $('#products-filter').keyup(e => {
    let q = $(e.target).val().trim()
    if (q.length < 3) {
      $('.product-container .label:not(.is-enabled)').remove()
      return false
    }
    $(e.target).addClass('searching')
    clearInterval(interval)
    interval = setTimeout(() => {
      searchRelations({
        q,
        parentId: $('input[name="data[newsletter_id]"]').val(),
        type: 'product',
        source: 'newsletter',
        model: 'NewsletterProduct'
      })
    }, 500)        
  })

  $('#user-filter').keyup(e => {
    let q = $(e.target).val().trim()
    if (q.length < 3) {
      $('.user-container > .label:not(.is-enabled)').remove()
      return false
    }

    const before = $('')
    $(e.target).addClass('searching')
    clearInterval(interval)
    interval = setTimeout(() => {
      searchRelations({
        q,
        parentId: $('input[name="data[id]"]').val(), 
        type: 'user',
        source: 'schedule',
        model: 'NewsletterUser',
        cb: checkUsers,
      })
    }, 500)        
  })*/
})

function updateUsers(){
  const relation = {
    parentId: $('input[name="data[id]"]').val(),
    type: 'user',
    source: 'schedule',
    model: 'NewsletterUser'
  }  
  var data = {}
  $('.advanced-filter').each(function(i,e){
    data[$(e).data('name')] = $(e).val()
  })
  $.ajax({
    type: "POST",
    url: "/admin/newsletters_users_reach",
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
        $('.relations-add').show()
        $.each(filter, function(key, item) {
          $('.user-container').append('<span class="label relation-item text-lowercase is-clickable" data-parent-id="'+relation.parentId+'" data-id="'+item.id+'" data-type="'+relation.type+'" data-source="'+relation.source+'" data-model="'+relation.model+'">'+item.email+'</span>');
        })
      } else {
        $('.relations-add').hide()
        $.growl.notice({
          title: 'Atención',
          message: 'No se encontraron cuentas para este filtro',
          queue: true,
        });        
      }
    },
    error: function (errormessage) {
      console.log(errormessage)
      //oPrnt.find("ul.result").html('<li><b>No Results</b></li>');
    }
  }).then(() => {
    setTimeout(() => {
      $('#products-filter').removeClass('searching')
    }, 100)
  })   
}

