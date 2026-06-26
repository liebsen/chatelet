var lastscroll = 0
//new WOW().init();
let focusAnim = 'pulse'
let clock = 0
let fakeshown = 0 
let growlTimeout = 15000
const log = false

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
  /*body.toggleClass('hide-side-content');*/

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
    if($(e.target).is(':checked')) {
      $(block).removeClass(className)
    } else {
      $(block).addClass(className)
    }
  })

  $(document).on('click','.toggle-click', function(e){
  //$('.toggle-click').click(function(e){
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

  $('#toggle-side-content').click(function(){ 
    if($('body').hasClass('hide-side-content')){
      $('#page-sidebar.collapse').collapse('hide');
      localStorage.sidebar = 0
    } else {
      $('#page-sidebar.collapse').collapse('show');
      localStorage.sidebar = 1
    }
    $('body').toggleClass('hide-side-content');
  });

  if(localStorage.sidebar == 1 && $(window).width() > 991) {
    $('#toggle-side-content').trigger('click')
  }

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

