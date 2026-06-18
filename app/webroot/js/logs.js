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
	      processData: false,
	      contentType: false,
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
			    })
				}
			})
  	}, 100) 
  })

  $('.button-update-schedules').click(function(e){
    e.preventDefault()
    clock = 0
    updateLog()
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
      updateLog()
    }
    $('.update-countdown').text(clock > interval - 1 ? '-' : (interval-clock))
    clock++
  }, 1000)
})

function playSound(){
  const sound = new Audio('/sound/schedules.mp3');
  sound.play()
}

function updateLog(){
  var search = ""

  var data = {
  	lines_count: $('.log').html().split("\n").length
  }

  if(window.location.search) {
    search = window.location.search
  }

  $.ajax({
    type: "POST",
    url: `/admin/logs_update/${search}`,
    data: data,
    success: function (res) {
      if(res.lines.length > 0) {
        playSound()
        $('.log').html(res.lines.join(""))
				$('.log').animate({
				  scrollTop: $('.log')[0].scrollHeight
				}, 500);
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

