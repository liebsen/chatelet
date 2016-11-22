//jCarousel Plugin
$('#carousel').jcarousel({
	vertical: true, //orientation of the carousel, in this case we use vertical
	scroll: 1, //the number of items to scroll by
	auto: 2, //the interval of scrolling
	wrap: 'last', //wrap at last item and jump back to the start
	initCallback: mycarousel_initCallback	//we will use this to further enhance the behavior of this carousel
});