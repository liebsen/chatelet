var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);

}

function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  var i;
  var x = $('.mySlides');
  var dots = $('.demo');
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
     dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
  }
  x[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " w3-opacity-off";

}
//$(".mySlides").elevateZoom();
    CloudZoom.quickStart();

$(function(){
  $("label.loadColorImages").on('click', function(e){
    var images = $(this).data('images').split(';');
    var moreviews = '';
    var surround = '';
    var p =0;
    for(var i=0;i<images.length;i++){
      if(images[i]!=""){
        moreviews += '<li class="dontResize"><a href="#"><img  class="demo w3-opacity w3-hover-opacity-off img-responsive" onclick="currentDiv('+p+')" title="key__'+p+'"  id="img_01" src="https://d3baxuoyqsgua.cloudfront.net/thumb_'+images[i]+'" ></a></li>';
        surround += '<img  class="mySlides cloudzoom img-responsive"  id="mySlides zoom1"   style="" src="https://d3baxuoyqsgua.cloudfront.net/'+images[i]+'" data-cloudzoom=\'zoomSizeMode:"image",autoInside: 600\'/>';
        p++;
      }
    }
    $("#ul-moreviews").html(moreviews);
    $("#surround").html(surround);
    CloudZoom.quickStart();
    showDivs(1);
  });
});
