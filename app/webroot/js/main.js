//new WOW().init();

$(function () {
  var body    = $('body');
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
  if(document.querySelector("#myModal")!=null && $('.js-show-modal') && $('.js-show-modal').length){
    setTimeout(function () {
      $('#myModal').modal({ show: true })
    }, 3000)
  }

  $('.dropdown-toggle.search').click(() => {
    setTimeout(() => {
      if($('.input-search').is(':visible')) {
        $('.input-search').focus()            
      }
    }, 500)        
  })
  let searchInt = 0
  $('.input-search').keyup(e => {
    if (searchInt) {
        clearInterval(searchInt)
    }
    searchInt = setTimeout(() => {
      $.ajax({
        type: "POST",
        url: "/shop/search/",
        data: JSON.stringify({q: $(this).val()}),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data) {
          console.log(data)
         /* $.each(data, function(key, val) {
                      str += '<li id="a'+key+'" term="'+val+'" data-did="'+key+'">'+val+'</li>';
          }); */
        },
        error: function (errormessage) {
          console.log(errormessage)
          //oPrnt.find("ul.result").html('<li><b>No Results</b></li>');
        }
      })
    }, 500)        
  })
          
  // Toggle Side content
  /*body.toggleClass('hide-side-content');*/
  $('#toggle-side-content').click(function(){ body.toggleClass('hide-side-content');if(body.hasClass('hide-side-content')){$('#page-sidebar.collapse').collapse('hide');} else {$('#page-sidebar.collapse').collapse('show');}});
})
