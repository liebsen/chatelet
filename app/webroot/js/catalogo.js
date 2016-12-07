$(function() {
	var slider = $('#content-box')
	  , slideInterval = 5000;

	slider.boxSlider({
            speed: 1000
          , autoScroll: true
          , timeout: slideInterval
          , next: '#next'
          , prev: '#prev'
          , pause: '#pause'
          , effect: 'fade'
    });
});