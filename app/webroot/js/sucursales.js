$(document).ready(function() {
	var map,
		geocoder,
		markers = window.markers = {};

	function initialize() {
		if (!google) return
		var mapOptions = {
			zoom: 11,
			center: new google.maps.LatLng(-34.6121795, -58.5297722),
			mapTypeId: 'roadmap'
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
					$.each(response, function(i, data){
						const sucursal = data.Store
						const marker = new google.maps.Marker({
			        map: map,
			        // icon: '/img/marker3.png',
			        draggable: true,
              animation: google.maps.Animation.DROP,
			        position: new google.maps.LatLng(sucursal.lat, sucursal.lng),
				    })
						const infowindow = new google.maps.InfoWindow({
							content: '<div style="overflow: hidden"><h4 style="margin:0">'+ sucursal.name +'</h4><br>'+'<p>' + sucursal.address + '<br />Tel: ' + sucursal.phone + '<br />WA: ' + sucursal.whatsapp + '<br />'+ (sucursal.takeaway == '1' ? '<span style="color: green">Takeaway</span>' : '') + '</p></div>'
						})
						var open = false
						var close = function(){
							infowindow.close();
						}
						var toggle = function() {
							for(var i in markers) {
								markers[i].close()
							}
							if (!open) {
								infowindow.open(map, marker);
							  const newCoords = new google.maps.LatLng(sucursal.lat, sucursal.lng);
							  map.panTo(newCoords); 
							  map.setZoom(16);
							}
							open = !open;
						};
						google.maps.event.addListener(marker, 'click', function() {
							toggle();
						});
						markers[sucursal.id] = { toggle, close, sucursal };
					});
				}else{ 
					console.error('no array');
				}
			}
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

		window.scrollTo(0,0)
		return false;
	});
    
	if (google) {
		google.maps.event.addDomListener(window, 'load', initialize);
	}
});
