(function() {
  var geocoder;
  var map;
  function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.599722, -58.381944);
    var mapOptions = {
      zoom: 8,
      center: latlng,
      disableDefaultUI: true
    };
    var map_canvas = document.getElementById('map-canvas');
    map = new google.maps.Map(map_canvas, mapOptions);
    var panel = $('#panel').detach();
    $(map_canvas).append(panel.show());
  }

  function codeAddress() {
    var address = document.getElementById('address').value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
        $('#lat').val(results[0].geometry.location.lat());
        $('#lng').val(results[0].geometry.location.lng());
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }

  google.maps.event.addDomListener(window, 'load', initialize);

  $(document).ready(function() {
    $('#geocode').click(codeAddress);
  });
}());