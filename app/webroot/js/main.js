//new WOW().init();
let searchInt = 0
let searchPageSize = 12
let searchPage = 0
let loadMoreSearch = p => {
  searchPage = p
  $('.search-more a').text('Cargando...')
  apiSearch(localStorage.getItem('lastsearch'))
}

let fxTotal = total => {
  $('.cost_total').text( total )
  document.querySelector('.cost_total-container').classList.remove('fadeIn', 'fadeOut', 'delay')
  document.querySelector('.cost_total-container').classList.add('fadeOut')
  setTimeout(() => {
    // document.querySelector('.cost_total-container').classList.add('hidden')
    document.querySelector('.cost_total-container').classList.remove('fadeOut')
    document.querySelector('.cost_total-container').classList.add('delay', 'fadeIn')
    // $('.cost_total-container').removeClass('hidden').css({opacity: 0}).fadeTo('slow', 1)
  }, 500)
}

let apiSearch = q => {    
  $.ajax({
    type: "POST",
    url: "/shop/search/",
    data: JSON.stringify({q: q, p: searchPage, s: searchPageSize}),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function (data) {
      let str = ''
      $('.search-more').html('')
      $.each(data.results, function(key, val) {
        str += '<div class="col col-md-4 col-lg-3 search-item animate fadeIn">' +
          '<a href="/tienda/producto/'+ val.id+'/'+val.category_id+'/'+val.slug+'">' + 
            '<div class="row">' + 
              '<div class="col-sm-12">' + 
                '<div class="is-background-cover is-background-search" style="background-image: url('+val.img_url+')">' + (val.promo.length ? '<div class="ribbon"><span>' + val.promo + '</span></div>' : '') + '<p class="search-desc">'+val.desc+'</p></div>' + 
                '<h2 class="text-center">'+val.name+'</h2>' + 
                '<h3 class="text-center">$'+val.price+'</h3>' + 
              '</div>' + 
            '</div>' +
          '</a>' + 
        '</div>'
      })
      if (str === '') {
        $('.search-results').html('<p class="results-text">No hay resultados para esta búsqueda</p>')
      } else {
        if (!searchPage) {
          $('.search-results').html(str)
        } else {
          $('.search-results').append(str)
        }
        setTimeout(() => {
          if (parseInt(data.query[0].count) > $('.search-item').length) {
            $('.search-more').html('<a href="javascript:loadMoreSearch(' + (searchPage + 1) + ')">Mostrar más resultados</a>')
          }
        }, 500)
      }
    },
    error: function (errormessage) {
      console.log(errormessage)
      //oPrnt.find("ul.result").html('<li><b>No Results</b></li>');
    }
  }).then(() => {
    setTimeout(() => {
      document.querySelector('.spinner-search').classList.remove('searching')
    }, 100)
  })    
}

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
    if ($('#menuSearch').is(':visible')) {
      $('#menuSearch').fadeOut();
    } else {
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
    }
  })


  $('.input-search').keyup(e => {
    if (searchInt) {
      clearInterval(searchInt)
    }
    searchPage = 0
    document.querySelector('.spinner-search').classList.add('searching')
    searchInt = setTimeout(() => {
      let q = $('.input-search').val().trim()
      localStorage.setItem('lastsearch', q)
      apiSearch(q)
    }, 500)        
  })
  // Toggle Side content
  /*body.toggleClass('hide-side-content');*/
  $('#toggle-side-content').click(function(){ body.toggleClass('hide-side-content');if(body.hasClass('hide-side-content')){$('#page-sidebar.collapse').collapse('hide');} else {$('#page-sidebar.collapse').collapse('show');}});
})
