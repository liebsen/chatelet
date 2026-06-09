const update_partials = [
  'email_sent', 
  'push_sent', 
  'email_total', 
  'push_total', 
  'clicks'
]

$(document).ready(function() {
  let clock = 0
  const interval = 60
  $('.btn-refresh').click(function(e){
    window.location.href = window.location.href
  })

  $('.btn-play-pause').click(function(e){
  	clearInterval(clock)
  	const target = $(e.target).hasClass('btn') ? $(e.target) : $(e.target).parent()
  	const id = target.data('id') || 0
  	if(!id) return
  	clock = setTimeout(function(){
  		var enabled = target.hasClass('btn-danger') ? 0:1
  		var formData = new FormData();
  		formData.append('enabled', enabled)
			$.ajax({
	      type: 'post',
	      url: '/admin/newsletters/schedules/edit/'+id, 
	      data: formData,
	      processData: false, // Prevent jQuery from converting data to a string
	      contentType: false, // Prevent jQuery from setting a default content-type header
	    }).success(function(res){
				if(res.success) {
					target.removeClass('btn-success btn-danger')
					target.addClass(enabled ? 'btn-danger' : 'btn-success')
					target.find('i').removeClass('fa-play fa-pause')
					target.find('i').addClass(enabled ? 'fa-pause' : 'fa-play')
			    $.growl.success({
			      title: 'Camapaña actualizada',
			      message: 'La camapaña ha sido actualizada',
			      duration: 1000
			    });
				}
			})
  	}, 100) 
  })
  $('.button-update-schedules').click(function(e){
    e.preventDefault()
    clock = 0
    updateSchedules()
    $.growl.success({
      title: 'Actualizando',
      message: 'Buscando actualizaciones de campañas...',
      duration: 1000
    });

    return false
  })

  // Autorefresh every minute and update a countdown clock
  setInterval(function(){
    if(clock == interval + 1) {
      clock = 0
      updateSchedules()
    }
    $('.update-countdown').text(clock > interval - 1 ? '-' : (interval-clock))
    clock++
  }, 1000)
})

function playSound(){
  const sound = new Audio('/sound/schedules.mp3');
  sound.play()
}

function updateSchedules(){
  var data = {}
  var search = ""
  if(window.location.search) {
    search = window.location.search
  }
  $('.schedule-rt').each(function(i,e){
    const id = $(e).data('id')
    for(var i in update_partials) {
      const j = update_partials[i]
      const target = $(e).find(`.${j}`)
      const value = parseInt(target.text()) || 0
      if(!data[id]) {
        data[id] = {}
      }
      data[id][j] = value
    }
  })

  $.ajax({
    type: "POST",
    url: `/admin/schedules_update${search}`,
    data: data,
    success: function (res) {
      if(res.results.length && res.change > 0) {
        playSound()
        $.each(res.results, function(key, item) {
          const target = $(`.schedules-${item.NewsletterSchedule.id}`)
          target.find('.status').parent().removeClass('bg-warning bg-info bg-success bg-light')
          target.find('.status').parent().addClass(`bg-${item.rowclass}`)
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
          message: `Se ha${res.change > 1 ? 'n':''} actualizado ${res.change} campaña${res.change > 1 ? 's':''}`,
          queue: true,
        });
      }
      /*$.growl.notice({
        title: 'Sin novedades',
        message: `No se actualizaron campañas`,
        queue: true,
      });*/      
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

