var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
var lastcp = localStorage.getItem('lastcp') || 0
var lastpm = localStorage.getItem('pm') || 'mercadopago'

//new WOW().init();
let searchInt = 0
let searchPageSize = 12
let searchPage = 0
let focusAnim = 'flash'

let formatNumber = (float) => {
  if (typeof float === 'string') {
    return float
  }

  return number_format(float, 2, ',', '.') 
}

formatNumber2 = function (num) {
  if (typeof num === 'string') {
    return num
  }
  return '$'+number_format(num, 2, ',', '.').replace(',00','')
  //return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
}

isDateBeforeToday = function(date) {
  return new Date(date.toDateString()) < new Date(new Date().toDateString());
}

let number_format = (number, decimals, dec_point, thousands_point) => { 
  if (number == null || !isFinite(number)) {
    throw new TypeError("number is not valid: " + number);
  }

  if (!decimals) {
    var len = number.toString().split('.').length;
    decimals = len > 1 ? len : 0;
  }

  if (!dec_point) {
    dec_point = '.';
  }

  if (!thousands_point) {
    thousands_point = ',';
  }

  number = parseFloat(number).toFixed(decimals);
  number = number.replace(".", dec_point);
  var splitNum = number.split(dec_point);
  splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
  number = splitNum.join(dec_point);

  return number;
}

let strtoFloat = (text) => { 
  return parseFloat(parseFloat(text.replace('.', '').replace('$', '')).toFixed(2))
}

let fxTotal = (total) => {
  $('.cost_total').text( formatNumber(total) )
  const block = document.querySelector('.cost_total-container')
  block.classList.remove('fadeIn', 'fadeOut', 'delay')
  block.classList.add('hidden')
  setTimeout(() => {
    block.classList.remove('hidden')
    block.classList.add('delay', 'fadeIn')
  }, 100)
}

let focusEl = (text) => { 
  var e = $(text) 
  if (e && !e.hasClass('hide')) {
    let position = e.offset().top
    if(position > $(window).height() - e.height()) {
      $('html, body').animate({
        scrollTop: position
      }, 500)
    }
    setTimeout(() => {
      $(text).removeClass(`animated slow ${focusAnim}`)
      $(text).addClass(`animated slow ${focusAnim}`)
    }, 1000)
  }
}

let findSize = (str) => {
  var size = '1.5rem'
  if (str.length >= 15) {
    size = '1.25rem'
  }
  if (str.length >= 19) {
    size = '1.15rem'
  }
  if (str.length >= 22) {
    size = '1rem'
  }        
  if (str.length >= 26) {
    size = '0.75rem'
  }
  return size
}

onErrorAlert = function(title, text, duration){
  $.growl.error({
    title: title || 'Error',
    message: text,
    queue: true,
    duration: duration || 15000
  });
}

onSuccessAlert = function(title, text, duration){
  $.growl.notice({
    title: title || 'OK',
    message: text,
    queue: true,
    duration: duration || 15000
  });
}

onWarningAlert = function(title, text, duration){
  // $('#growls').remove();
  $.growl.warning({
    title: title || 'OK',
    message: text,
    queue: true,
    duration: duration || 15000
  })
}

let loadMoreSearch = (p) => {
  searchPage = p
  $('.search-more a').text('Cargando...')
  apiSearch(localStorage.getItem('lastsearch'))
}


callStart = function(){
  setTimeout(() => {
    $('.btn-calculate-shipping').button('loading')
    $('#cost_container').removeClass('text-muted', 'text-success');
    $('#cost_container').addClass('hide');
    // $('#loading').removeClass('hide');
  }, 10)
}

callEnd = function(){
  cargo = 'shipment'
  $('.btn-calculate-shipping').button('reset')
  $('.shipping-loading').removeClass('animated fadeOut');
  $('#cost_container').removeClass('animated fadeIn');
  setTimeout(() => {
    $('.shipping-loading').addClass('animated fadeOut');    
    $('#cost_container').addClass('animated fadeIn');
  }, 10)
  setTimeout(() => {
    $('#cost_container').removeClass('hide');
    $('.shipping-loading').addClass('hide');
    $('#cost_container').addClass('text-success');
  }, 500)
}



let apiSearch = (q) => {    
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
        str += '<div class="col-xs-6 col-md-3 col-lg-2 search-item animate fadeIn">' +
          '<a href="/tienda/producto/'+ item.id+'/'+item.category_id+'/'+item.slug+'">' + 
            '<div class="is-background-cover is-background-search" style="background-image: url('+item.img_url+')">' + (item.promo.length ? '<div class="ribbon sp3"><span>' + item.promo + '</span></div>' : '') + (item.discount_label ? '<div class="ribbon small bottom-left sp2"><span>' + item.discount_label + '% OFF</span></div>' : '') + '<p class="search-desc">'+item.desc+'</p></div>' + 
            '<h2 class="text-center">'+`<span style="font-size:${findSize(item.name)}!important">${item.name}</span>`+'</h2>' + 
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
          var w = ($('.search-item').length / data.query[0].count) * 100
          $('.search-bar').css({'width': `${w}%`})
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
  var body = $('body');
  body.click((e) => {
    if(!$(e.target).hasClass('action-search') && !$(e.target).parents('.menuLayer').length) {
      $('.menuLayer').hide()
    }
  })  

  $('#filters .prices label span, #formulario label span').click(function () {
    $('#filters .prices label span, #formulario label span').removeClass('active');
    $(this).addClass('active')
    $('#filters .prices input, #formulario input[type="radio"]').removeAttr('checked');
    $(this).parent().find('input').attr('checked', 'checked');
  })

  $('ul.nav a').hover(function () {
    if( $(this).attr('class') == 'viewSubMenu' ) {
      if (!$('.menuLayer').is(':visible').length) {
        $('#menuShop').fadeIn();
      }
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
    $('.menuLayer').hide()
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
    window.scrollTo(0,0)
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
      if(document.querySelector('.float-tl')) {
        document.querySelector('.float-tl').classList.add('float-top-left')
      }
      if(document.querySelector('.float-tr')) {
        document.querySelector('.float-tr').classList.add('float-top-right')
      }
    } else {
      if(document.querySelector('.float-tl')) {
        document.querySelector('.float-tl').classList.remove('float-top-left')
      }
      if(document.querySelector('.float-tr')) {
        document.querySelector('.float-tr').classList.remove('float-top-right')
      }
    }
  })

  /* trigger search from url */

  if (window.location.hash) {
    const queryCode = 'q'
    const focusCode = 'f'
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
    if (window.location.hash.indexOf(`${focusCode}:`) > -1) {
      focusEl(window.location.hash.replace(`#${focusCode}:`, ''))
    }
  }

  window.onerror = function (msg, url, lineNo, columnNo, error) {
    onErrorAlert(`${msg}:${lineNo}`);
    $.post('/shop/log_error', {message: msg, url: url, line: lineNo})
  }
})
