var carrito = JSON.parse(localStorage.getItem('carrito')) || {}
var lastcp = localStorage.getItem('lastcp') || 0
var lastscroll = 0
//new WOW().init();
let searchInt = 0
let searchPageSize = 12
let searchPage = 0
let focusAnim = 'pulse'
let clock = 0
let pageLoaded = () => {   
  $('body').removeClass('loading')
  $('#page-container').removeClass('loading')
  $('#page-loader').addClass('animated fadeOut')
  setTimeout(() => {
    $('#page-loader').remove()  
  },500)
}

let formatNumber = (float) => {
  if (typeof float === 'string') {
    return float
  }

  return number_format(float, 2, ',', '.').replace(',00','')
}

formatNumber2 = function (num) {
  if (typeof num === 'string') {
    return num
  }
  return ' $ '+number_format(num, 2, ',', '.').replace(',00','')
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

let calcDues = (total) => {
  $('.calc-dues').each(function(e){
    const dues = Number($(this).data('dues'))
    const interest = Number($(this).data('interest')) || 0
    const monto = total * (1 + interest / 100)
    $(this).text(dues + ' cuotas de ' + formatNumber(monto / dues))
  })
}

let fxTotal = (total) => {
  if($('.calc_total').text().replace("$ ", "") == total) {
    return false
  }
  $('.calc_total').text( '$ ' + formatNumber(total) )
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
    e.get(0).scrollIntoView({ behavior: "smooth" });
    setTimeout(() => {
      $(text).removeClass(`animated ${focusAnim}`)
      $(text).addClass(`animated ${focusAnim}`)
      $(text).find('input').first().focus()
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
  if (str.length >= 24) {
    size = '1rem'
  }        
  if (str.length >= 30) {
    size = '0.75rem'
  }
  return size
}

onErrorAlert = function(title, text, duration){
  $.growl.error({
    title: title || 'Error',
    message: text && text !== 'undefined' ? text : '',
    queue: true,
    duration: duration || 15000
  });
}

onSuccessAlert = function(title, text, duration){
  $.growl.notice({
    title: title || 'OK',
    message: text && text !== 'undefined' ? text : '',
    queue: true,
    duration: duration || 15000
  });
}

onWarningAlert = function(title, text, duration){
  // $('#growls').remove();
  $.growl.warning({
    title: title || 'OK',
    message: text && text !== 'undefined' ? text : '',
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
        let strLegends = ''
        if(item.legends.length){
          strLegends+= `<span class="legends-container mb-2"><span class="legends w-100">`
          item.legends.forEach((e) => {
            strLegends+= `<span class="text-legend">`
            if(e.discount) {
              strLegends+= ` <span class="text-theme text-bold text-high">-${e.discount}%</span> `
            }
            if(e.text) {
              if(!isNaN(e.text.split(' ')[0])) {
                strLegends+= `<span class="text-theme text-bold text-high">${e.text.split(' ')[0]}</span> ${e.text.split(' ').slice(1).join(' ')}`
              } else {
                strLegends+= ` <span class="text-theme text-muted">${e.text}</span> `
              }
            }
            if(e.price) {
              strLegends+= ` <span class="text-dark text-bold text-price text-high text-nowrap">$ ${formatNumber(e.price)}</span> `
            }
            strLegends+= `</span>`
          })
        }
        str += '<div class="col-sm-6 col-md-3 search-item animate fadeIn">' +
          '<a href="/tienda/producto/'+ item.id+'/'+item.category_id+'/'+item.slug+'">' + 
            '<div class="is-background-cover is-background-search" style="background-image: url('+item.img_url+')">' + (item.promo.length ? '<div class="ribbon sp3"><span>' + item.promo + '</span></div>' : '') + (item.number_ribbon ? '<div class="ribbon small bottom-left sp2"><span>' + item.number_ribbon + '% OFF</span></div>' : '') + '<p class="search-desc">'+item.desc+'</p></div>' + 
            '<h2 class="text-center">'+`<span>${item.name}</span>`+'</h2>' + 
            '<div class="price-list text-center mb-2">'+(item.old_price ? '<span class="old_price text-grey">$' + formatNumber(item.old_price) + '</span>' : '') + '<span>$' + formatNumber(item.price) + '</span></div>' + strLegends +
          '</a>' + 
        '</div>'
      })

      if (str === '') {
        $('.search-results').html('<h1>No hay resultados para esta búsqueda</h1>')
        $('.search-bar').css({'width': `0%`})
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

function layerShow (layer) {
  const selectr = $(`.${layer}-layer`)
  if (selectr.hasClass('active')) {
    selectr.removeClass('active')
  } else {
    selectr.addClass('active')
  }  
  return false
}

function layerClose() {
  $('body').css('overflow-y', 'auto')
  $('.fullhd-layer').removeClass('active')
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
      $("video").each((i,video) => {
        video.pause()
      });
      if (!$('.menuLayer').is(':visible').length) {
        $('#menuShop').removeClass('position-fixed')  
        if($('.navbar-chatelet').hasClass('top-fixed')){
          $('#menuShop').addClass('layer-fixed')  
        }
        $('#menuShop').fadeIn();
      }
    } else {
      $('#menuShop').fadeOut();
      var video = $("#carousel .item.active").find("video")
      if(video.length){
        setTimeout(() => {
          $(video).get(0).play()
        }, 200)
      }
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
    //window.scrollTo(0,0)
  })

  if(window.location.hash.indexOf('listShop') === -1 && document.querySelector("#myModal")!=null && $('.js-show-modal') && $('.js-show-modal').length){
    setTimeout(function () {
      $('#myModal').modal({ show: true })
    }, 10)
  }

  if (window.location.hash.indexOf('listShop') > -1) {
    setTimeout(() => {
      window.scrollBy(0, -93)
    }, 5000)
  }

  $('.action-search').click((e) => {
    if($('.navbar-collapse')){
      $('.navbar-collapse').removeClass('in');
    }
    e.stopPropagation()
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

  $('.close-search').click(e => {
    $('.input-search').val("")
    $('.close-search').css({opacity: "0"})
  })

  $('.input-search').keyup(e => {
    let q = $('.input-search').val().trim()
        
    $('.close-search').css({opacity: q.length?"100":"0"})

    if (q.length < 3) {
      $('.search-results').empty()
      return false
    }

    if (searchInt) {
      clearInterval(searchInt)
    }
    
    searchPage = 0
    window.scrollTo(0,0)
    document.querySelector('.spinner-search').classList.add('searching')
    searchInt = setTimeout(() => {
      localStorage.setItem('lastsearch', q)
      apiSearch(q)
    }, 500)        
  })

  if (document.querySelector('.whatsapp-text') && document.querySelector('.autohide')) {
    var segs = parseInt(Array.from(document.querySelector('.autohide').classList).filter(e => e.indexOf('segs-') > -1)[0].replace('segs-','')) || 30
    setTimeout(() => {
      document.querySelector('.autohide > .whatsapp-text').classList.add('animated','chatOut')
    }, segs * 1000)
  }

  var menuLayerTop = 0;
  /*if (document.getElementById('carousel-banners')) {
    const height = document.getElementById('carousel-banners').clientHeight
    menuLayerTop+= height;
  }*/
  document.querySelectorAll('.menuLayer:not(.is-fullheight)').forEach(e => {
    e.style.top = `${menuLayerTop}px`;
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
    if(clock) {
      clearInterval(clock)
    }
    clock = setTimeout(() => {
      var scroll = $(window).scrollTop()
      var tops = document.querySelectorAll('.top-fixable')
      var navbar = document.querySelector('.navbar-chatelet')
      if (scroll > 300) {
        if (document.getElementById('carousel-banners')) {
          document.getElementById('carousel-banners').classList.add('invisible')
        }
        if(document.querySelector('.float-tl')) {
          document.querySelector('.float-tl').classList.add('float-top-left')
        }
        if(document.querySelector('.float-tr')) {
          document.querySelector('.float-tr').classList.add('float-top-right')
        }
        tops.forEach((e) => {
          if (e && !e.classList.contains('top-fixed')) {
            e.classList.remove('fadeOut', 'fadeIn')
            setTimeout(() => {
              if (e.classList.contains('navbar-chatelet')) {
                document.querySelector('body').style.paddingTop = `${e.clientHeight}px`
              }
              e.classList.add('top-fixed', 'fadeIn')
            }, 10)
          } 
        })
        $("video").each((i,video) => {
          video.pause()
        });
      } else {
        if (document.getElementById('carousel-banners')) {
          document.getElementById('carousel-banners').classList.remove('invisible')
        }
        if(document.querySelector('.float-tl')) {
          document.querySelector('.float-tl').classList.remove('float-top-left')
        }
        if(document.querySelector('.float-tr')) {
          document.querySelector('.float-tr').classList.remove('float-top-right')
        }
        tops.forEach((e) => {
          if (e && e.classList.contains('top-fixed')) {
            if (e.classList.contains('navbar-chatelet')) {
              document.querySelector('body').style.paddingTop = 0
            }
            e.classList.remove('top-fixed')
          }
        })
        var video = $("#carousel .item.active").find("video")
        if(video.length){
          setTimeout(() => {
            $(video).get(0).play()
          }, 200)
        }
      }
      lastscroll = scroll
    }, 500)
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
    var browser = {
      appCodeName: navigator.appCodeName,
      appName: navigator.appName,
      appVersion: navigator.appVersion,
      cookieEnabled: navigator.cookieEnabled,
      platform: navigator.platform,
      userAgent: navigator.userAgent
    }
    $.post('/shop/log_error', {message: msg + JSON.stringify(browser), url: url, line: lineNo})
  }

  const sections = ['','/','/Home']

  if(!sections.includes(location.pathname)){
    $('body, html').removeClass('noscroll')
  }
})
