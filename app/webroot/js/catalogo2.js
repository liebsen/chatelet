$(document).ready(function() {
    var root = location.protocol + '//' + location.host;
    var path = location.pathname;//cahatelet-new/catalog/index
    var isDev = (path.indexOf('chatelet-new')!=-1)?true:false;
    $("a.right.carousel-control").on('click', function(event){
        event.preventDefault();
        $('#carousel2 .carousel-inner').carousel('next');
        /*
        if($('#carousel2 .carousel-inner').children('.item').hasClass('active')) {
             var img = $(".item.active").data('img');
             location.href = root+'/catalogo/index/'+img;
        }
        */
        
    });
    $("a.left.carousel-control").on('click', function(event){
        event.preventDefault();
        $('#carousel2 .carousel-inner').carousel('prev');
        /*
        if($('#carousel2 .carousel-inner').children('.item').hasClass('active')) {
             var img = $(".item.active").data('img');
             location.href = root+'/catalogo/index/'+img;
        }*/
        
    });
});