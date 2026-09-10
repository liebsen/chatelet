document.addEventListener("DOMContentLoaded", function() {
	var carouselInterval = 0
	var carouselTimeout = 2000
	$('#productOptions .carousel').each(function(){
		$(this).swipe({
		  swipe: function(event, direction, distance, duration, fingerCount, fingerData) {
		    if (direction == 'left') $(this).carousel('next');
		    if (direction == 'right') $(this).carousel('prev');
		  },
		  tap: function(e, target) {
		  	if(e.target.href) {
		    	window.location = e.target.href
		    }
		  },
		  threshold: 50,
		  allowPageScroll: "vertical",
		  excludedElements: "label, button, input, select, textarea, .noSwipe"		  
		});
		$(this).hover(function(){
			const that = $(this)
			carouselInterval = setInterval(function(){
				that.carousel('next');	
			}, carouselTimeout)
		  $(this).carousel('next');
		},function(){
			clearInterval(carouselInterval)
		});
	})
})
