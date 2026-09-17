$(document).ready(function() {
  const map = new mapboxgl.Map({
    accessToken: 'pk.eyJ1IjoiY29zbWljYmVhbXMiLCJhIjoiY211NWtqaWV1MDE5ZDJ3cThlZGduNjVjOCJ9.sNvuP7Uo6PIWpQrmKx2mcA',
    container: 'map-canvas', // container ID
    center: [-58.5297722, -34.6121795], // starting position [lng, lat]. Note that lat must be set between -90 and 90
    zoom: 9 // starting zoom
  });

	function initialize() {
		$.ajax({
			url: $('.sucursales').data('url'),
			method: 'GET',
			error: function(xhr, status, error) {
				console.error(xhr,status,error);
			},		
			success: function(response){
				if ($.isArray(response)) {
					$.each(response, function(i, data){
						const sucursal = data.Store
					  const marker = new mapboxgl.Marker({color: "deeppink"})
					    .setLngLat([sucursal.lng, sucursal.lat])
					    .addTo(map);
						const popup = new mapboxgl.Popup()
					  .setHTML('<div style="overflow: hidden; padding: 0.5rem; min-width: 300px"><img src="/img/logo.png" width=105><h4 style="margin-bottom:0;margin-top:0.5rem">'+ sucursal.name + '</h4>'+ (sucursal.takeaway == '1' ? '<br /><span class="text-chatelet"><i class="fa fa-shopping-bag"></i> Takeaway</span><br />' : '') + '<br><p><i class="fa fa-map-pin"></i>' + sucursal.address + '<br /><i class="fa fa-phone"></i>' + sucursal.phone + '<br /><i class="fa fa-whatsapp"></i>' + sucursal.whatsapp + '<br />' + '</p></div>');
						marker.setPopup(popup);
					})
				}
			}
		})
	}

	$('.sucursal').click(function() {
		const sucursal = $(this).data();
		console.log('data', sucursal)
		map.flyTo({
	    center: [sucursal.lng, sucursal.lat],
	    zoom: 15,
	    essential: true
		});		
		window.scrollTo(0,0)
		return false;
	});	
	initialize()
})
