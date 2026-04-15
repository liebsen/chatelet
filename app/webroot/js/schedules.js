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
  $.ajax({
    type: "POST",
    url: "/admin/schedules_update",
    success: function (res) {
      if(res.results.length) {
        $.each(res.results, function(key, item) {
          const target = $(`.schedules-${item.NewsletterSchedule.id}`)
          target.removeClass('bg-warning bg-info bg-success bg-light')
          target.addClass(`bg-${item.rowclass}`)
          target.find('.status').text(item.status)
          target.find('.clicks').text(item.stats.clicks)
          target.find('.push_sent').text(item.stats.push_sent)
          target.find('.email_sent').text(item.stats.email_sent)
        })
        return $.growl.notice({
          title: 'Atención',
          message: `Se han actualizado ${res.results.length} campañas`,
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

