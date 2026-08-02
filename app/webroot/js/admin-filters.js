
$(function () {
	$('.advanced-filter').change(function(e){
		const min = formatNumber(parseFloat($(e.target).val()))
		$('.sale_min-value').text(min)
	})
})