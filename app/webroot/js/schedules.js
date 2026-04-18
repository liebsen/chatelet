const update_partials = ['email_total', 'push_total', 'clicks']

$(document).ready(function() {
  let clock = 0
  $('.btn-refresh').click(function(e){
    window.location.href = window.location.href
  })

  $('.btn-update-schedules').click(function(e){
    e.preventDefault()
    clock = 0
    updateSchedules()
  })

  // Autorefresh every minute
  setInterval(function(){
    if(clock){
      updateSchedules()
    }
    clock++
  }, 60000)
})

function updateSchedules(){
  var data = {}
  $('.schedule-rt').each(function(i,e){
    data[$(e).data('id')] = {}
    for(var i in update_partials) {
      data[$(e).data('id')][i] = $(e).find(`.${i}`).text()
    }
  })
  $.ajax({
    type: "POST",
    url: "/admin/schedules_update",
    data: data,
    success: function (res) {
      if(res.results.length) {
        $.each(res.results, function(key, item) {
          const target = $(`.schedules-${item.NewsletterSchedule.id}`)
          target.removeClass('bg-warning bg-info bg-success bg-light')
          target.addClass(`bg-${item.rowclass}`)
          target.find('.status').text(item.status)
          for(var i in update_partials) {
            const j = update_partials[i]
            target.find(`.${j}`).text(item.stats[j])
            if(item.change[j]) {
              const badge = target.find(`.${j}`).parents('.badge')
              badge.removeClass('animation-expandOpen')
              setTimeout(function(){
                badge.addClass('animation-expandOpen')
              }, 100)
            }
          }
        })
        return $.growl.notice({
          title: 'Atención',
          message: `Se ha${res.results.length > 1 ? 'n':''} actualizado ${res.results.length} campaña${res.results.length > 1 ? 's':''}`,
          queue: true,
        });
      }
      $.growl.notice({
        title: 'Atención',
        message: `No se actualizaron campañas`,
        queue: true,
      });      
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

