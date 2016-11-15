$(function(){
	$('#consult').click(function(event){
		event.preventDefault();
		var url = 'https://www1.oca.com.ar/OEPTrackingWeb/trackingenvio.asp?numero1='+$('[name="data[guia]"]').val();
		newwindow=window.open(url,'Oca Envios','height=230,width=430');
		if (window.focus) {newwindow.focus()}
		return false;
	});
})