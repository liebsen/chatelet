$(document).ready(function() {
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd'
	})
	$('.weekdays').click(function(a) {
		let weekdays = ''
		$('.weekdays').each(function(e, i) {
			weekdays+= $(i).is(':checked') ? $(i).val() : ''
		})
		console.log(weekdays)
		$('#weekdays').val(weekdays)
	})
});