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

  $('#products-filter').keyup(function(e){
    clearTimeout(clock)
    const value = $(e.target).val().toUpperCase()
    clock = setTimeout(() => {
      $('.product-item').each((j,i) => {
        if(!$(i).hasClass('is-enabled')){
          if($(i).text().toUpperCase().includes(value)) {
            $(i).removeClass('hidden')
          } else {
            $(i).addClass('hidden')
          }
        }
      })
    }, 500)
  })
})

function toggleOption(e, type){
  let data = JSON.parse(e.getAttribute('data-json'))
  let ep = $(e).hasClass('is-enabled') ? 'remove' : 'add'
  data.type = type
  data.coupon = e.getAttribute('data-coupon')
  $.post('/admin/coupon_' + ep, $.param(data))
    .success(function(res) {
      let result = JSON.parse(res)
      if (result.success) {
        console.log('ok')
        /*$.growl.notice({
          title: 'Exito',
          message: 'Se actualizó el cupón exitosamente'
        });*/
        $(e).removeClass('is-enabled')
        if(ep == 'add'){
          $(e).addClass('is-enabled')  
        }
      }
    })
    .fail(function() {
      $.growl.error({
        title: 'Ocurrio un error al agregar el producto al email',
        message: 'Por favor, intente nuevamente'
      });
    });           
}
