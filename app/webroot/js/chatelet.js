var carrito = JSON.parse(localStorage.getItem('cart')) || {}
var lastcp = localStorage.getItem('lastcp') || 0
var lastscroll = 0
//new WOW().init();
let searchInt = 0
let searchPageSize = 12
let searchPage = 0
let focusAnim = 'pulse'
let clock = 0
let fakeshown = 0 
const log = false

function addCart(data, button, label, redirect) {
  $(button).addClass('adding')
  $(button).text(label || 'Agregando...')
  $.post('/carrito/add', $.param(data))
    .success(function(res) {
      if (res.success) {
        const price = $('.price').text()
        const name = $('.product').text()        
        window.dataLayer = window.dataLayer || []
        fbq('track', 'AddToCart', {contents: [{id: data.id, quantity: data.count}], value: price, currency: 'ARS'});
        /* @Analytics: addToCart */
        gtag('event', 'add_to_cart', {
          "items": [
            {
              "id": data.id,
              "name": name,
              // "list_name": "Search Results",
              // "brand": "Google",
              // "category": "Apparel/T-Shirts",
              "variant": data.alias,
              "list_position": 1,
              "quantity": data.count,
              "price": price
            }
          ]
        })

        /*$.growl.error({
          title: 'Agregado al carrito',
          message: 'Podés seguir agregando más productos o finalizar esta compra en la sección carrito'
        });

        var reload = function() {
          window.location.href = '/carrito'
        };

        setTimeout(reload, 1000);
        
        $('.growl-close').click(reload);
        */
        var timeout = 0
        dataLayer.push({
          'event': 'addToCart',
          'ecommerce': {
            'currencyCode': 'ARS',
            'add': {         
              'products': [{
                'name': $('.product').text(),
                'id': data.id,
                'price': $('.price').text(),
                'brand': 'Google',
                'category': 'Apparel',
                'variant': data.alias,
                'quantity': 1
               }]
            }
          },
          'eventCallback': function() {
            clearInterval(timeout)
            timeout = setTimeout(function(){
              $.growl.notice({
                title: 'Redirigiendo al carrito ...',
                message: 'Carrito de compras actualizado'
              });
              var reload = function() {
                window.location.href = redirect || '/carrito'
              };
              setTimeout(reload, 1000);
              $('.growl-close').click(reload);
            }, 300)
          }
        })
      } else {
        $.growl.error({
          title: 'Ocurrió un error al agregar el producto al carrito',
          message: 'Por favor, intentá nuevamente en unos instantes'
        });
      }
    })
    .fail(function() {
      $.growl.error({
        title: 'Ocurrió un error al agregar el producto al carrito',
        message: 'Por favor, intente nuevamente'
      });
    }); 
}

var askremoveCart = (e) => {
  const item = $(e).parents('.carrito-data').data('json')
  let userInput = confirm(`¿Querés borrar el producto ${item.name} del carrito?`);
  if(userInput){
    $.get(`/carrito/remove/${item.id}`).then((res) => {
      /* @Analytics: removeFromCart */
      fbq('track', 'RemoveFromCart')
      gtag('event', 'remove_from_cart', {
        "items": [
          {
            "id": item.id,
            "name": item.article,
            // "list_name": "Results",
            "brand": item.name,
            // "category": "Apparel/T-Shirts",
            "variant": item.alias,
            "list_position": 1,
            "quantity": 1,
            "price": item.discount
          }
        ]
      })
      console.log('refersh')
      window.location.href = window.location.href
    })
  }
}

let sendBeacon = (tag) => { 
  const data = {
    tag,
    event: 'page_exit',
    page: window.location.pathname,
    timestamp: new Date().toISOString()
  };

  // Convert data to a Blob for sending
  const blob = new Blob([JSON.stringify(data)], { type: 'application/json' });

  // Send the beacon
  navigator.sendBeacon('/shop/analytics', blob);
}

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
  if($('.calc_total').text().replace("$ ", "") != total) {
    $('.calc_total').text( '$ ' + formatNumber(total) )
  }
}

let focusEl = (text) => { 
  var e = $(text) 
  if (e && !e.hasClass('hide')) {
    e.get(0).scrollIntoView({ behavior: "smooth" });
    setTimeout(() => {
      $(text).removeClass(`animated ${focusAnim}`)
      $(text).addClass(`animated ${focusAnim}`)
      $(text).find('input').first().focus()
    }, 500)
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


var alerts = {}
var interval = 0

groupAlerts = function(title, text) {
  if(!alerts[title]) {
    alerts[title] = []
  }
  alerts[title].push(text)
  clearInterval(interval)
  interval = setTimeout(function(){
    for(var title in alerts) {
      const item = alerts[title]
      const messages = item.map(function(e) { 
        return `<li>${e}</li>`;
      })
      $.growl.error({
        title: title || 'Error',
        message: '<ul>' + messages.join('') + '</ul>' || '',
        queue: true,
        duration: 15000
      });      
    }
    alerts = []
  }, 5000)
}

onErrorAlert = function(title, text, duration, group){
  if(group) {
    return groupAlerts(title, text)
  }    
  $.growl.error({
    title: title || 'Error',
    message: text && text !== 'undefined' ? text : '',
    queue: true,
    duration: duration || 15000
  });
}

onSuccessAlert = function(title, text, duration, group){
  if(group) {
    return groupAlerts(title, text)
  }  
  $.growl.notice({
    title: title || 'OK',
    message: text && text !== 'undefined' ? text : '',
    queue: true,
    duration: duration || 15000
  });
}

onWarningAlert = function(title, text, duration, group){
  if(group) {
    return groupAlerts(title, text)
  }
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

let apiSearch = (q) => {    
  $.ajax({
    type: "POST",
    url: "/shop/api_search/",
    data: JSON.stringify({q: q, p: searchPage, s: searchPageSize}),
    contentType: "application/json; charset=utf-8",
    dataType: "json",
    success: function (data) {
      let str = ''

      $('.search-more').html('')
      $.each(data.results, function(key, item) {    
        let strLegends = ''
        if(item.legends.length){
          strLegends+= `<span class="legends-container mb-8"><span class="legends w-100">`
          item.legends.forEach((e) => {
            if(!e.text.includes('1')) {
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
            }
          })
        }
        str += '<div class="col-sm-12 col-md-2 col-lg-2 search-item">' +
          '<a href="/tienda/producto/'+ item.id+'/'+item.category_id+'/'+item.slug+'">' + 
            '<div class="is-background-cover is-background-search" style="background-image: url('+item.img_url+')">' + (item.promo.length ? '<div class="ribbon sp3"><span>' + item.promo + '</span></div>' : '') + (item.number_ribbon ? '<div class="ribbon small bottom-left sp2"><span>' + item.number_ribbon + '% OFF</span></div>' : '') + '<p class="search-desc">'+item.desc+'</p></div>' + 
            '<h2 class="text-center">'+`<span>${item.name}</span>`+'</h2>' + 
            '<div class="price-list text-center mb-8">'+(item.old_price ? '<span class="old_price text-grey">$' + formatNumber(item.old_price) + '</span>' : '') + '<span>$' + formatNumber(item.price) + '</span></div>' + strLegends +
          '</a>' + 
        '</div>'
      })

      if (str === '') {
        $('.search-results').html('<h1>No hay resultados para <i>'+ q +'</i></h1>')
        $('.search-bar').css({'width': `0%`})
      } else {
        if (!searchPage) {
          $('.search-results').html(str)
        } else {
          $('.search-results').append(str)
        }
        setTimeout(() => {
          if(data && data.query && data.query[0]) {
            var w = ($('.search-item').length / data.query[0].count) * 100
            $('.search-bar').css({'width': `${w}%`})
            if (parseInt(data.query[0].count) > $('.search-item').length) {
              $('.search-more').html('<a href="javascript:loadMoreSearch(' + (searchPage + 1) + ')">Mostrar más resultados</a>')
            }
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
      document.querySelector('.input-search').classList.remove('searching')
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
  $('.layer').removeClass('active')
}



$(document).ready(function() {



  /* filter beforeunload events */
  var validNavigation = false;



  // Attach the event keypress to exclude the F5 refresh (includes normal refresh)
  $(document).bind('keypress', function(e) {
    if (e.keyCode == 116){
      validNavigation = true;
    }
  });

  // Attach the event click for all links in the page
  $("a").bind("click", function() {
    validNavigation = true;
  });

  // Attach the event submit for all forms in the page
  $("form").bind("submit", function() {
    validNavigation = true;
  });

  // Attach the event click for all inputs in the page
  $("input[type=submit]").bind("click", function() {
    validNavigation = true;
  });

  window.onbeforeunload = function() {                
    if (!validNavigation) {    
      sendBeacon()
    }
  } 
  
  $('body').click((e) => {
    /*if(!$(e.target).hasClass('action-search') && !$(e.target).parents('.burst').length) {
      $('.burst').hide()
    }*/
  })  

  $('#filters .prices label span, #formulario label span').click(function () {
    $('#filters .prices label span, #formulario label span').removeClass('active');
    $(this).addClass('active')
    $('#filters .prices input, #formulario input[type="radio"]').removeAttr('checked');
    $(this).parent().find('input').attr('checked', 'checked');
  })

  $('.btn-continue-shopping').click(function (e) {
    e.preventDefault()
    e.stopPropagation()
    let href = $(e.target).prop('href')
    if(localStorage.getItem('continue_shopping_url') && localStorage.getItem('continue-shopping-url') != 'undefined') {
      href = localStorage.getItem('continue_shopping_url')
    }
    localStorage.removeItem('continue_shopping_url')
    location.href = href 
  })
  $('.action-search').click(function () {
    location.href = '/shop/buscar'
  })

  $('.burst a.close').click(function () {
    $('.burst').fadeOut();
    if (!$('.navbar-toggle').hasClass('collapsed')) {
      $('.navbar-toggle').addClass('collapsed')
    }
    if ($('.navbar-collapse').hasClass('in')) {
      $('.navbar-collapse').removeClass('in')
    }
    //window.scrollTo(0,0)
  })

  if(
    window.location.hash.indexOf('listShop') === -1 && 
    document.querySelector("#myModal")!=null && 
    $('.js-show-modal') && 
    $('.js-show-modal').length
  ){
    setTimeout(function () {
      $('#myModal').modal({ show: true })
    }, 10)
  }

  if (window.location.hash.indexOf('listShop') > -1) {
    setTimeout(() => {
      window.scrollBy(0, -93)
    }, 5000)
  }

  /* generic clic handlers */

  $('[data-toggle="click"]').click((e) => {
    const show = $(e.target).data('show')
    const hide = $(e.target).data('hide')
    const remove = $(e.target).data('remove')
    if($(show).length) {
      $(show).fadeIn()
    }
    if($(hide).length) {
      $(hide).fadeOut()
    }
    if($(remove).length) {
      $(remove).remove()
    }
  })

  $('[data-toggle="mouseenter"]').mouseenter((e) => {
    const show = $(e.target).data('show')
    // stop all media
    $("video").each((i,e) => {
      e.pause()
    });
    if($(show).length) {
      $(show).fadeIn()
    }
  })

  $('[data-toggle="mouseleave"]').mouseleave((e) => {
    const hide = $(e.target).data('hide')
    if($(hide).length) {
      $(hide).fadeOut()
    }
    // resume media
    var video = $("#carousel .item.active").find("video")
    if(video.length){
      setTimeout(() => {
        $(video).get(0).play()
      }, 50)
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
    document.querySelector('.input-search').classList.add('searching')
    searchInt = setTimeout(() => {
      localStorage.setItem('lastsearch', q)
      apiSearch(q)
    }, 500)        
  })

  if (document.querySelector('.whatsapp-text.autohide')) {
    var segs = parseInt(Array.from(document.querySelector('.whatsapp-text.autohide').classList).filter(e => e.indexOf('segs-') > -1)[0].replace('segs-','')) || 30
    setTimeout(() => {
      document.querySelector('.whatsapp-text.autohide').classList.remove('chatIn')
      document.querySelector('.whatsapp-text.autohide').classList.add('chatOut')
    }, (segs + 3) * 1000)
  }

  var burstTop = 0;
  /*if (document.getElementById('carousel-banners')) {
    const height = document.getElementById('carousel-banners').clientHeight
    burstTop+= height;
  }*/
  document.querySelectorAll('.burst:not(.is-fullheight)').forEach(e => {
    e.style.top = `${burstTop}px`;
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
      const video = $("#carousel .item.active").find("video")
      $('.navbar-chatelet:not(.short)').removeClass('fadeIn')
      if($('.shop-options').is(':visible')) {
        $('.shop-options').hide()
      }
      void document.querySelector('.navbar-chatelet').offsetWidth;
      if (scroll > 100) {
        if (!fakeshown && lastscroll < scroll) {
          // $('#carousel-banners').addClass('invisible')
          $('body').addClass('top-fixed')
          $('.navbar-chatelet:not(.short)').addClass('fadeIn')
          if(video?.length) {
            $("video").each((i,video) => {
              video.pause()
            });
          }
          fakeshown = 1
        }
      } else {
        if (fakeshown && lastscroll > scroll) {
          // $('#carousel-banners').removeClass('invisible')
          $('body').removeClass('top-fixed')
          $('.navbar-chatelet:not(.short)').addClass('fadeIn')
          if(video?.length){
            setTimeout(() => {
              $(video).get(0).play()
            }, 200)
          }
          fakeshown = false
        }
      }
      lastscroll = scroll
    }, 500)
  })


  /* trigger search from url */

  if (window.location.hash) {
    const queryCode = 'q'
    const focusCode = 'f'
    if (window.location.pathname === '/' && window.location.hash.indexOf(`${queryCode}:`) > -1) {
      var q = window.location.hash.replace(`#${queryCode}:`, '')
      if (q) {
        localStorage.setItem('lastsearch', q)
        $('#myModal').remove()
        $('.input-search').val(q)
        $('.input-search').keyup()
      }
    }
    if (window.location.hash.indexOf(`${focusCode}:`) > -1) {
      focusEl(window.location.hash.replace(`#${focusCode}:`, ''))
    }
  }

  /*window.onerror = function (msg, url, lineNo, columnNo, error) {
    if (window.location.hostname != 'chatelet.com.ar') {
      onErrorAlert(`${msg}:${lineNo}`);
    }
    var browser = {
      appCodeName: navigator.appCodeName,
      appName: navigator.appName,
      appVersion: navigator.appVersion,
      cookieEnabled: navigator.cookieEnabled,
      platform: navigator.platform,
      userAgent: navigator.userAgent
    }
    $.post('/shop/log_error', {message: msg + JSON.stringify(browser), url: url, line: lineNo})
  }*/

  const sections = ['','/','/Home']

  if(!sections.includes(location.pathname)){
    $('body, html').removeClass('noscroll')
  }

	$('#flashMessage').each(function(i, flash) {
		flash = $(flash);
		if (flash.hasClass('error')) {
			$.growl.error({
				title: 'Error',
				message: flash.text()
			});
		}

		if (flash.hasClass('notice')) {
			$.growl.notice({
				title: 'Información',
				message: flash.text(),
			});
		}

		if (flash.hasClass('warning')) {
			$.growl.warning({
				title: 'Importante',
				message: flash.text()		
			});
		}

		flash.remove();
	});

	$(document).on('click', '.gotoaccount', () => {
		location.href = '/shop/cuenta'
	})

	$(document).on('click', '.gotocart', () => {
		console.log('click gotocart')
		location.href = '/carrito'
	})
	
	$('.dropdown-menu').click(function(e) {
		var target = $(e.target);

		if (target.is('a') || target.parent().is('a') || target.is('input[type="submit"]')) {
			return true;
		}

		return false;
	});

	if (typeof $.fn.datepicker != 'undefined'){ 
		$('.datepicker').datepicker({
			format: $(this).data('format') || 'dd/mm/yyyy',
			language: 'es'
		});
	}
	
	//$('.selectpicker').selectpicker();

	$('#registro-modal a[data-toggle="modal"]').click(function() {
		$(this).parents('#registro-modal').modal('hide');
		return true;
	});
});
