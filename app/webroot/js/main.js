new WOW().init();

$(function () {

    $('#filters .prices label span, #formulario label span').click(function () {
        $('#filters .prices label span, #formulario label span').removeClass('active');
        $(this).addClass('active')
        $('#filters .prices input, #formulario input[type="radio"]').removeAttr('checked');
        $(this).parent().find('input').attr('checked', 'checked');
    })

    $('ul.nav a').hover(function () {
        if( $(this).attr('class') == 'viewSubMenu' ) {
            $('#menuShop').fadeIn();
        } else {
            $('#menuShop').fadeOut();
        }
    })
    $('#menuShop a.close').click(function () {
        $('#menuShop').fadeOut();
    })

    setTimeout(function () {
        $('#myModal').modal({ show: true })
    }, 3000)
})