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

		$.get( $('.sucursales').data('url') )
		
		.done(function(response) {

			if ($.isArray(response)) {
				$.each(response, function(i, sucursal) {
					var sucursal = sucursal.Store,
						marker = new google.maps.Marker({
					        map: map,
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
								open = false;
							} else {
								infowindow.open(map, marker);
								open = true;
							}
						};

					google.maps.event.addListener(marker, 'click', function() {
						$('#location').html(' <div class="col-md-12" style="">'+'<h3>'+ sucursal.name +'</h3>'+
							'<ul><li>' + sucursal.address + '</li><li> ' + sucursal.phone + '</li></ul></div>');
						toggle();
					});

              		markers[sucursal.id] = { 
						toggle: toggle
					};
				});
			}
		})
		.fail(function() {
			console.error('An error ocurred while trying to get stores info');
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