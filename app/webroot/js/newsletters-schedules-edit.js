$(document).ready(function() {

  let clock = 0

  $('#minDate,#maxDate').on('changeDate', function(event) {
    const selectedDate = $(event.target).val()
    const selectedName = $(event.target).data('name');
    $('.'+selectedName).text(selectedDate)
    updateUsers()
  })

  $('#minSale').change(function(e){
    const value = $(this).val() || 0
    $('.minsale-value').text('$'+ (value * 100))
    updateUsers()
  })

  let interval = 0
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
        rel_id: $('input[name="newsletter_id"]').val(),
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
        rel_id: $('input[name="newsletter_id"]').val(), 
        type: 'user',
        source: 'newsletter',
        model: 'NewsletterUser',
        cb: checkUsers,
      })
    }, 500)        
  })
})

$(document).on('click', '.product-item, .user-item', function(e){

  const target = $(e.target)
  const data = target.data()
  const action = target.hasClass('is-enabled') ? 'remove' : 'add'

  $.post('/admin/relation_' + action, data)
    .success(function(res) {
      if (res.success) {
        $.growl.notice({
          title: action == 'add' ? 'Asociación exitosa' : 'Eliminación exitosa',
          message: action == 'add' ? 'Se asoció el producto exitosamente' : 'Se eliminó el producto exitosamente',
        });
        target.removeClass('is-enabled')
        if(action == 'add'){
          target.addClass('is-enabled')  
        }
      }
    })
    .fail(function() {
      $.growl.error({
        title: 'Ocurrio un error al agregar el producto al Newsletter',
        message: 'Por favor, intente nuevamente'
      });
    });
})

function checkUsers(count){
  if(!count) return
  $('.usercount-new').text(count)
  $('.userscount-message').show()
}

function relateAll(){
  $('.user-container > .label:not(.is-enabled)').trigger('click')
  $('.userscount-message').hide()
  setTimeout(function(){
    const count = parseInt($('.userscount-value').text())
    const old_count = parseInt($('.usercount-new').text())
    $('.userscount-value').text(count + old_count)
  }, 3000)
}

function updateUsers(){
  const data = {
    rel_id: $('input[name="newsletter_id"]').val(),
    type: 'user',
    source: 'newsletter',
    model: 'NewsletterUser'
  }  
  $.ajax({
    type: "POST",
    url: "/admin/newsletters_users_reach",
    data: {
      minDate: $('#minDate').val(), 
      maxDate: $('#maxDate').val(), 
      minSale: $('#minSale').val(),
    },
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
        $('.usercount-new').text(filter.length)
        $('.userscount-message').show()
        $.each(filter, function(key, item) {
          $('.user-container').append('<span class="label user-item text-lowercase is-clickable" data-rel_id="'+data.rel_id+'" data-id="'+item.id+'" data-type="'+data.type+'" data-source="'+data.source+'" data-model="'+data.model+'">'+item.email+'</span>');
        })
      } else {
        $('.userscount-message').hide()
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

