var lastscroll = 0
//new WOW().init();
let focusAnim = 'pulse'
let clock = 0
let fakeshown = 0 
let growlTimeout = 15000
const log = false

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

$(function () {
  $(document).on('click', '.toggle-force', function(){
    $(this).parent().find('input').trigger('click')
  })

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
  $('.logout-btn').click(function(){ 
    const prompt = confirm('¿Deseas abandonar la sesión?')
    if(prompt) {
      location.href = '/admin/logout'
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

  $('.nav-tabs .fa-question-circle').click(function(e) {
    e.preventDefault()
    const target = $(e.target)
    $.growl.notice({
      title: target.parent().text(),
      message: target.data('text'),
      duration: 15000
    });
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
    $(e).append(`<span class="form-box-handle"><i class="gi gi-star"></i></span>`)
  })

  $('.form-box > .form-box-handle').click(function(event){
    $(this).parent().toggleClass('fs')
  })

  Growl.settings.duration = 2000
})

