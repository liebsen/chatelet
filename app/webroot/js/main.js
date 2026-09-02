var lastscroll = 0
//new WOW().init();
let focusAnim = 'pulse'
let clock = 0
let fakeshown = 0 
let growlTimeout = 15000
let loadedFonts = []
const log = false

function getStore(key){
	return localStorage[key] && localStorage[key] != 'undefined' ? JSON.parse(localStorage[key]) : {}
}

function getStoreAttr(key, prop){
	const json = localStorage[key] && localStorage[key] != 'undefined' ? JSON.parse(localStorage[key]) : {}
	return json[prop] || '';
}

function saveStore(key, prop, value){
	var json = getStore(key)
	json[prop] = value;
	localStorage[key] = JSON.stringify(json)
}

function loadFont(font){
	if(loadedFonts[font]) return false
	const filename = 'https://fonts.googleapis.com/css?family='+encodeURIComponent(font)+':300,400,500,600,700,800,900,1000';
	var link = document.createElement('link');
  link.rel = 'stylesheet';
  link.type = 'text/css';
  link.href = filename;
  loadedFonts.push(font)
  document.getElementsByTagName('head')[0].appendChild(link);
}

function insertAtCursor(el, text) {
  const start = el.selectionStart;
  const end = el.selectionEnd;
  const originalValue = el.value;

  // Splice the string: [Text Before] + [New Text] + [Text After]
  el.value = originalValue.substring(0, start) + text + originalValue.substring(end);

  // Reposition cursor after the new text
  el.selectionStart = el.selectionEnd = start + text.length;

  // Restore focus
  el.focus();
}

function sanitizeDate (str) {
	if(str.length==10) {
		var parts = str.split('/')
		if(parts[2].length==4) {
			parts = parts.reverse()
		}
		return parts.join('-')
	}
	return str
}


function formatNumber (float) {
  if (typeof float === 'string') {
    return float
  }

  return number_format(float, 2, ',', '.').replace(',00','')
}


function number_format(number, decimals, dec_point, thousands_point) { 
  /*if (number == null || !isFinite(number)) {
    throw new TypeError("number is not valid: " + number);
  }*/


  try {
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
  } catch(e) {
    console.log('Error:' . e);
  }
}

function strtoFloat(text) { 
  return parseFloat(parseFloat(text.replace('.', '').replace('$', '')).toFixed(2))
}

function show_done(){
  document.querySelector('.draggable-saved').classList.add('lever')
  setTimeout(() => {
    document.querySelector('.draggable-saved').classList.remove('lever')
  }, 5000)
}

function slugify(input) {
  if (!input)
      return '';

  // make lower case and trim
  var slug = input.toLowerCase().trim();

  // remove accents from charaters
  slug = slug.normalize('NFD').replace(/[\u0300-\u036f]/g, '')

  // replace invalid chars with spaces
  slug = slug.replace(/[^a-z0-9\s-]/g, ' ').trim();

  // replace multiple spaces or hyphens with a single hyphen
  slug = slug.replace(/[\s-]+/g, '-');

  return slug;
}

function getDateDifference(start, end) {
  if (start > end) [start, end] = [end, start];

  let years = end.getFullYear() - start.getFullYear();
  let months = end.getMonth() - start.getMonth();
  let days = end.getDate() - start.getDate();

  // Adjust for negative days by borrowing from months
  if (days < 0) {
    months--;
    // Get days in the previous month of the end date
    const prevMonth = new Date(end.getFullYear(), end.getMonth(), 0);
    days += prevMonth.getDate();
  }

  // Adjust for negative months by borrowing from years
  if (months < 0) {
    years--;
    months += 12;
  }

  return { years, months, days };
}


function layerShow (layer) {
  const block = $(`.${layer}-layer`)
  if (block.hasClass('active')) {
    block.removeClass('active')
  } else {
    block.addClass('active')
  }  
  return false
}

function layerClose() {
  $('body').css('overflow-y', 'auto')
  $('.layer').removeClass('active')
}

$(function () {
  $('.track-coords').click(function(e){
    const width = $(this).width();
    const height = $(this).height();
    const offset = $(this).offset();
    const relativeX = e.pageX - offset.left;
    const relativeY = e.pageY - offset.top;
    const absX = relativeX < width / 2 ? 0 : 1;
    const absY = relativeY < height / 2 ? 0 : 1;
    document.getElementById('x_coord').value = absX;
    document.getElementById('y_coord').value = absY;
  })

  $('#flashMessage').each(function(i, flash) {
    flash = $(flash);
    // console.log({flash})
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
  // Toggle Side content
  /*body.toggleClass('show-sidebar');*/

  if (typeof $.fn.datepicker != 'undefined'){ 
    $('.datepicker').each(function(i,e){
      if($(e).is('input') == false) return
      const format = $(e).data('format') || 'dd/mm/yyyy'
      $(e).datepicker({
        format: format,
        language: 'es',
        autoclose: true,
        todayHighlight: true,
      });
    })
  }

  var timeout = 0
  $('.logout-btn').click(function(e){ 
    e.preventDefault()
    e.stopPropagation()
    const prompt = confirm('¿Deseas abandonar la sesión?')
    if(prompt) {
      location.href = '/admin/logout'
    }
    return false
  })

  $('.toggle-block').change(function(e){
    const block = $(this).data('block')
    const className = $(this).data('class') || 'd-disable'
    if($(this).is(':checked')) {
      $(block).removeClass(className)
    } else {
      $(block).addClass(className)
    }
  })

  $(document).on('click','.toggle-click', function(e){
    const func = $(this).data('func')
    if(window[func]) {
    	console.log('func',func)
      window[func]()
    } else {
      console.log('Error: Could not find any function: ' + func)
    }
  })

  $('#filter-menu').keyup(function(){ 
    clearTimeout(timeout)
    const value = slugify($(this).val())
    if(value.length < 2) {
      $('#primary-nav ul li').removeClass('d-none')
      return false
    }
    timeout = setTimeout(() => {      
      $('#primary-nav li').each((e,element) => {
        const title = slugify($(element).find('span').text())
        if(title.includes(value)) {
          $(element).removeClass('d-none')
        } else {
          $(element).addClass('d-none')
        }
      })
    }, 100)
  })

  //$(document).on('click', '.nav-tabs .fa-question-circle', function(e) {
  $('.fa-question-circle').click(function(e) {
    e.preventDefault()
    e.stopPropagation()
    if(!$(this).data('text')) return false;
    const target = $(e.target)
    $.growl.notice({
      title: target.parent().text(),
      message: target.data('text'),
      duration: 15000
    });
    return false
  })

  $('.form-pass-icon').click(function(event) {
    const target = $(this).data('target')
    if($(target).prop('type') == 'password') {
      $(this).removeClass('fa-eye-slash')
      $(this).addClass('fa-eye active')
      $(target).prop('type', 'text')
    } else {
      $(this).removeClass('fa-eye active')
      $(this).addClass('fa-eye-slash')
      $(target).prop('type', 'password')
    }
  })
  
  $('.toggle-display').click(function(){ 
    $(this).parent().find($(this).data('target')).toggleClass('d-none')
  })

  $('#toggle-sidebar-button').mousedown(function(){ 
  	$('#toggle-sidebar.collapse').toggleClass('in');
    $('body').toggleClass('show-sidebar');
    localStorage.sidebar = $('#toggle-sidebar.collapse').hasClass('in')
  });

  if($(window).width() < 992) {
    $('#toggle-sidebar').removeClass('in')
    $('body').removeClass('show-sidebar');
  } else {
  	if(localStorage.sidebar == 'false') {
	    $('#toggle-sidebar').removeClass('in')
	    $('body').removeClass('show-sidebar');
  	}
  }

  /*if(localStorage.sidebar == 'true') {
    $('#toggle-sidebar').addClass('in')
    $('body').addClass('show-sidebar');
  }*/

  $('.form-box').each(function(i,e){
    $(e).append(`<span class="form-box-handle"><i class="gi gi-more_windows"></i></span>`)
  })

  $('.form-box > .form-box-handle').click(function(event){
    const target = $(this)
    //target.find('.gi').removeClass('gi-remove gi-more_windows')
    target.parent().toggleClass('fs')
    /*setTimeout(function(){
      target.find('.gi').addClass(
        target.parent().hasClass('fs') ? 
        'gi-remove' : 
        'gi-more_windows'
      )
    }, 100)*/
  })

  Growl.settings.duration = 2000
})

