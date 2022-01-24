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
  $('.menuLayer a.close').click(function () {
    $('.menuLayer').fadeOut();
  })
  if(document.querySelector("#myModal")!=null && $('.js-show-modal') && $('.js-show-modal').length){
    setTimeout(function () {
      $('#myModal').modal({ show: true })
    }, 3000)
  }

  $('.action-search').click(() => {
    $('#menuSearch').fadeIn();
    setTimeout(() => {
      if($('.input-search').is(':visible')) {
        $('.input-search').focus()            
      }
      if (localStorage.getItem('lastsearch')) {
        $('.input-search').val(localStorage.getItem('lastsearch'))
        $('.input-search').keyup()
      }
    }, 500)        
  })
  let searchInt = 0
  $('.input-search').keyup(e => {
    if (searchInt) {
        clearInterval(searchInt)
    }
    searchInt = setTimeout(() => {
      $('.spinner-search').addClass('searching')
      let q = $('.input-search').val().trim()
      localStorage.setItem('lastsearch', q)
      $.ajax({
        type: "POST",
        url: "/shop/search/",
        data: JSON.stringify({q: q}),
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data) {
          let str = ''
          $.each(data, function(key, val) {
            str += '<div class="col col-md-6 col-lg-4">' + 
              '<a href="/tienda/producto/'+ val.id+'/'+val.category_id+'/'+val.slug+'">' + 
                '<div class="row">' + 
                  '<div class="col-sm-12">' + 
                    '<div class="is-background-cover is-background-search" style="background-image: url('+val.img_url+')"><p>'+val.desc+'</p></div>' + 
                    '<h2>'+val.name+'</h2>' + 
                    '<h3 class="text-center">$'+val.price+'</h3>' + 
                  '</div>' + 
                '</div>' +
              '</a>' + 
            '</div>'
          })
          $('.search-results').html(str)
        },
        error: function (errormessage) {
          console.log(errormessage)
          //oPrnt.find("ul.result").html('<li><b>No Results</b></li>');
        }
      }).then(() => {
        $('.spinner-search').removeClass('searching')
      })
    }, 500)        
  })
          
  // Toggle Side content
  /*body.toggleClass('hide-side-content');*/
  $('#toggle-side-content').click(function(){ body.toggleClass('hide-side-content');if(body.hasClass('hide-side-content')){$('#page-sidebar.collapse').collapse('hide');} else {$('#page-sidebar.collapse').collapse('show');}});
})
