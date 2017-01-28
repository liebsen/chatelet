$(document).ready(function() {
	var map,
		geocoder,
		markers = window.markers = {};

	function initialize() {
		var mapOptions = {
				zoom: 11,
				center: new google.maps.LatLng(-34.6121795, -58.5297722)
			},
			hostname = window.location.protocol + '//' + window.location.hostname;

		hostname += '/' + window.location.pathname.split('/')[1];

		geocoder = new google.maps.Geocoder();
		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		$.ajax( {
			url: $('.sucursales').data('url'),
			method: 'GET',
			error: function(xhr, status, error) {
				console.error(xhr,status,error);
			},		
			success: function(response){
			if ($.isArray(response)) {
				$.each(response, function(i, sucursal) {
					var sucursal = sucursal.Store,
						marker = new google.maps.Marker({
					        map: map,
					        draggable: true,
                        			animation: google.maps.Animation.DROP,
					        position: new google.maps.LatLng(sucursal.lat, sucursal.lng)
					    }),
						infowindow = new google.maps.InfoWindow({
							content: '<div><h4>'+ sucursal.name +'</h4>'+
							'<p>' + sucursal.address + '<br />Tel. ' + sucursal.phone + '</p></div>'
						}),
						open = false,
						toggle = function() {
							if (open) {
								infowindow.close();
								open = true;
							} else {
								infowindow.open(map, marker);
								open = true;
							}
						};

						

					google.maps.event.addListener(marker, 'click', function() {
						toggle();
					});
					console.error('ok');
					markers[sucursal.id] = { 
						toggle: toggle
					};
				});
			
			}else{ console.error('no array');} }
		});
	}

	function geocodeCbk(results, status, id, location, infoContent) {
		if (status == google.maps.GeocoderStatus.OK) {

		}
	}

	$('.sucursal').click(function() {
		var id = $(this).data('sucursal');

		if (!markers[id]) return false;

		markers[id].toggle();

		return false;
	});
    

	google.maps.event.addDomListener(window, 'load', initialize);
});
