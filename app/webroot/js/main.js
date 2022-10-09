//new WOW().init();
let searchInt = 0
let searchPageSize = 12
let searchPage = 0
let loadMoreSearch = p => {
  searchPage = p
  $('.search-more a').text('Cargando...')
  apiSearch(localStorage.getItem('lastsearch'))
}

let strtoFloat = (text) => { 
  return parseFloat(parseFloat(text.replace('.', '').replace(',', '').replace('$', '')).toFixed(2))
}

let fxTotal = (total) => {
  $('.cost_total').text( total )
  const block = document.querySelector('.cost_total-container')
  block.classList.remove('fadeIn', 'fadeOut', 'delay')
  block.classList.add('hidden')
  setTimeout(() => {
    block.classList.remove('hidden')
    block.classList.add('delay', 'fadeIn')
  }, 100)
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
      $.each(data.results, function(key, item) {
        str += '<div class="col-xs-6 col-md-4 col-lg-3 search-item animate fadeIn">' +
          '<a href="/tienda/producto/'+ item.id+'/'+item.category_id+'/'+item.slug+'">' + 
            '<div class="is-background-cover is-background-search" style="background-image: url('+item.img_url+')">' + (item.promo.length ? '<div class="ribbon sp3"><span>' + item.promo + '</span></div>' : '') + (item.discount_label ? '<div class="ribbon small bottom-left sp2"><span>' + item.discount_label + '% OFF</span></div>' : '') + '<p class="search-desc">'+item.desc+'</p></div>' + 
            '<h2 class="text-center">'+item.name+'</h2>' + 
            '<h3 class="price text-center">'+(item.old_price ? '<span class="old_price text-grey">$' + item.old_price + '</span>' : '') + '<span>$' + item.price + '</span></h3>' + 
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
    if (!$('.navbar-toggle').hasClass('collapsed')) {
      $('.navbar-toggle').addClass('collapsed')
    }
    if ($('.navbar-collapse').hasClass('in')) {
      $('.navbar-collapse').removeClass('in')
    }
    window.scrollTo(0,0)
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
          if(!$('.search-item').length){
            $('.input-search').keyup()
          }
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
  $('#toggle-side-content').click(function(){ 
    if(body.hasClass('hide-side-content')){
      $('#page-sidebar.collapse').collapse('hide');
    } else {
      $('#page-sidebar.collapse').collapse('show');
    }
    body.toggleClass('hide-side-content');

  });

  $(window).scroll(function(e) {
    var scroll = $(window).scrollTop()
    if (scroll > 200) {
      document.querySelector('.menuLayer .close').classList.add('float-top-right')
    } else {
      document.querySelector('.menuLayer .close').classList.remove('float-top-right')
    }
  })
  /* trigger search from url */

  const queryCode = 'q'
  if(window.location.pathname === '/' && window.location.hash.indexOf(`${queryCode}:`) > -1) {
    var q = window.location.hash.replace(`#${queryCode}:`, '')
    if (q) {
      localStorage.setItem('lastsearch', q)
      $('#myModal').remove()
      $('.action-search').click()
      $('.input-search').val(q)
      $('.input-search').keyup()
    }
  }
})
