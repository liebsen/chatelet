var lastscroll = 0
//new WOW().init();
let focusAnim = 'pulse'
let clock = 0
let fakeshown = 0 
let growlTimeout = 15000
const log = false

function show_done(){
  document.querySelector('.draggable-saved').classList.remove('scaleOut')
  document.querySelector('.draggable-saved').classList.add('scaleIn')
  setTimeout(() => {
    document.querySelector('.draggable-saved').classList.remove('scaleIn')
    document.querySelector('.draggable-saved').classList.add('scaleOut')
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

function setRelation(action, data, target) { 
  //console.log('setRelation', action, data, target)
  $.post('/admin/relation_' + action, data)
    .success(function(res) {
      if (res.success) {
        $.growl.notice({
          title: 'Exito',
          message: `Se ${action=='add' ? 'agregó' : 'eliminó'} la relación exitosamente`,
          queue: false,
        });
        if(action=='add'){
          target.addClass('is-enabled')
        } else {
          target.removeClass('is-enabled')
        }
      }
    })
    .fail(function() {
      $.growl.error({
        title: 'Error',
        message: `Ocurrió un error al establecer la relación en ${data.model}. Por favor, intente nuevamente`,
        queue: false,
      });
    });    
}

function searchRelations(data) { 
  //console.log('searchRelations', data)
  const endpoints = { 
    user: {
      url: '/admin/search_users',
      selector: 'email'
    },
    product: {
      url: '/api/search_products',
      selector: 'name'
    } 
  }
  $.ajax({
    type: "POST",
    url: endpoints[data.type].url,
    data: {
      q: data.q, 
      p: 0, 
      s: 10
    },
    success: function (res) {
      let str = ''
      $(`#${data.type}-filter`).addClass('searching')
      $(`.${data.type}-container > .label:not(.is-enabled)`).remove()
      $.each(res.results, function(key, item) {
        $(`.${data.type}-container`).append(`<span class="label ${data.type}-item ${data.type == 'user' ? 'text-lowecase' : ''} is-clickable" data-rel_id="${data.rel_id}" data-id="${item.id}" data-type="${data.type}" data-source="${data.source}" data-model="${data.model}">${item[endpoints[data.type].selector]}</span>`);
      })
    },
    error: function (errormessage) {
      console.log(errormessage)
      //oPrnt.find("ul.result").html('<li><b>No Results</b></li>');
    }
  }).then(() => {
    setTimeout(() => {
      $(`#${data.type}-filter`).removeClass('searching')
    }, 100)
  })    
}

$(function () {

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
        language: 'es'
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
  $('#toggle-side-content').click(function(){ 
    if($('body').hasClass('hide-side-content')){
      $('#page-sidebar.collapse').collapse('hide');
    } else {
      $('#page-sidebar.collapse').collapse('show');
    }
    $('body').toggleClass('hide-side-content');
  });
})

