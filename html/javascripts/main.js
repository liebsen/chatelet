new WOW().init();

$(function () {

	$('#filters .prices label span, #formulario label span').click(function () {
		$('#filters .prices label span, #formulario label span').removeClass('active');
		$(this).addClass('active')
		$('#filters .prices input, #formulario input[type="radio"]').removeAttr('checked');
		$(this).parent().find('input').attr('checked', 'checked');
	})

	setTimeout(function () {
		$('#myModal').modal({ show: true })
	}, 3000)

  $('#header_search').submit(e => {
    return false
  })
})