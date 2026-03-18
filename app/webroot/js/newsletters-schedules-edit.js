$(document).ready(function() {

  let clock = 0

  $('#minDate,#maxDate').on('changeDate', function(event) {
    const selectedDate = $(event.target).val()
    const selectedName = $(event.target).data('name');
    $('.'+selectedName).text(selectedDate)
  })

  $('#minSale').change(function(e){
    const value = $(this).val() || 0
    $('.minsale-value').text('$'+ (value * 100))
  })

  let interval = 0
  $('#products-filter').keyup(e => {
    let q = $(e.target).val().trim()
    if (q.length < 3) {
      $('.search-results').empty()
      return false
    }
    $(e.target).addClass('searching')
    clearInterval(interval)
    interval = setTimeout(() => {
      searchProds(q)
    }, 500)        
  })

  $('#users-filter').keyup(e => {
    let q = $(e.target).val().trim()
    if (q.length < 3) {
      $('.search-results').empty()
      return false
    }
    $(e.target).addClass('searching')
    clearInterval(interval)
    interval = setTimeout(() => {
      searchUsers(q)
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

