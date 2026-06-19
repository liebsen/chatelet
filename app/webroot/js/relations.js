let interval = 0
let audienceMax = 0
const endpoints = { 
  user: {
    url: '/admin/search_users',
    parent: 'input[name="data[id]"]',
    model: 'NewsletterUser',
    source: 'list',
    field: 'email'
  },
  product: {
    url: '/api/search_products',
    parent: 'input[name="data[id]"]',
    model: 'NewsletterProduct',
    source: 'newsletter',
    field: 'name'
  } 
}

$(document).ready(function() {
  $('.relation-search').keyup(e => {
    let q = $(e.target).val().trim()
    const type = $(e.target).data('type')
    const data = endpoints[type] || {}
    if(!data.model) return 
    if (q.length < 3) {
      $('.'+type+'-container .label:not(.is-enabled)').remove()
      $('.relations-add-single').addClass('d-none')
      return false
    }
    $(e.target).addClass('searching')
    clearInterval(interval)
    interval = setTimeout(() => {
      searchRelations({
        q, 
        type: type,
        cb: updateRelationCount 
      })
    }, 500)        
  })
})

function setRelation(action, data, target, type, cb) {
  if(confirm('Realmente deseas hacer esto?')) {
    $.post('/admin/relation_' + action, {
      data: data
    }).success(function(res) {
      if (res.success) {
        $.growl.notice({
          title: action=='add' ? 'Agregado' : 'Eliminado',
          message: `Se ${action=='add' ? 'agregó' : 'eliminó'} la relación exitosamente`,
        });
        if(action=='add'){
          $(target && $(target).hasClass('relation-item') ? 
            target : 
            '.' + type + '-container .label:not(.is-enabled)'
          ).addClass('is-enabled')
          $('.relations-add:not(.btn-persist)').addClass('d-none')
          $('.relations-remove:not(.btn-persist)').removeClass('d-none')
        } else {
          $(target && $(target).hasClass('relation-item') ? 
            target : 
            '.' + type + '-container .label'
          ).removeClass('is-enabled')
          $('.relations-remove:not(.btn-persist)').addClass('d-none')
          $('.relations-add:not(.btn-persist)').removeClass('d-none')
        }
        if(typeof cb == 'function') {
          cb(type, target)
        }
      }
    }).fail(function() {
      $.growl.error({
        title: 'Error',
        message: `Ocurrió un error al establecer la relación en ${type}. Por favor, intente nuevamente`,
        queue: false,
      });
    });
  }  
}

function updateRelationCount(type, target, count){
  const count2 = $(`.${type}-container .label.is-enabled`).length
  if(!count&&!count2) return
  $(`.${type}-count`).text(count||count2)
  /*if(target) {
    $(target).remove()
  }*/
}

function searchRelations(data) {
  const curr = endpoints[data.type] || {}
  if(!curr.model) return 
  $('.relations-add:not(.btn-persist)').addClass('d-none')
  $('.relations-remove:not(.btn-persist)').addClass('d-none')
  $.ajax({
    type: "POST",
    url: curr.url,
    data: {
      q: data.q, 
      p: 0, 
      s: 500
    },
    success: function (res) {
      let str = ''
      let ids = []
      let filter = []      
      $(`#${data.type}-filter`).addClass('searching')
      $(`.${data.type}-container > .label:not(.is-enabled)`).remove()
      $(`.${data.type}-container`).parent().find(`.secondary-box .results-message`).remove()
      $(`.${data.type}-container > .label`).each(function(key, item) {
        const id = $(item).data('id')
        ids.push(id)
      })
      if(res.results.length) {
        $.each(res.results, function(key, item) {
          const id = parseInt(item.id)
          if ($.inArray(id, ids) === -1) {
            filter.push(item)
          }
        })
      }
      if(filter.length){
        $('.relations-count').text(filter.length)
        const parentId = $(curr.parent).val() || 0
        $.each(filter, function(key, item) {
          $(`.${data.type}-container`).append(`<span class="label relation-item ${data.type == 'user' ? 'text-lowercase' : ''} is-clickable" data-parent-id="${parentId}" data-id="${item.id}" data-type="${data.type}" data-source="${curr.source}" data-model="${curr.model}">${item[curr.field].slice(0, item[curr.field].indexOf('@')) }</span>`);
        })
        if(typeof data.cb == 'function') {
          data.cb(data.type, null, filter.length)
        }
        $('.relations-add:not(.btn-persist)').removeClass('d-none')
        // $('.relations-remove').addClass('d-none')
      } else {
        $(`.${data.type}-container`).parent().find('.secondary-box').append(`<span class="h6 results-message">No se hallaron resultados para <b>${data.q}</b></span>`)  
      }
      $(`.${data.type}-container`).removeClass('d-none')
    },
    error: function (errormessage) {
      $.growl.error({
        title: 'Error',
        message: errormessage
      });
      //oPrnt.find("ul.result").html('<li><b>No Results</b></li>');
    }
  }).then(() => {
    setTimeout(() => {
      $(`#${data.type}-filter`).removeClass('searching')
    }, 100)
  })    
}

$(document).on('click', '.relations-add-dialog', function(e){
  e.preventDefault()
  if(!$('#growls > div').length) {
	  $.growl.notice({
	    title: 'Agregar a todos. ¿Deseas segmentar en muestras?',
	    message: $('#relations-add-dialog').html(),
	    duration: 5000000
	  });
	}
})

$(document).on('click', '.toggle-split', function(){
  $(this).parent().find('input').trigger('click')
  $('.toggle-split-area, .toggle-split-desc').toggleClass('d-none')
})

$(document).on('keyup', '.relation-audience-max', function(e){
	audienceMax = parseInt($(e.target).val())
})

$(document).on('click', '.relations-add', function(e){
  const tData = $(e.target).is('a') || $(e.target).is('button') ? $(e.target).data() : $(e.target).parents('a').data()  
  if(!tData?.type) return
  var data = []
  var target = null
  if(tData.key=='all'){
  	tData.audienceMax = audienceMax
    target = e.target
    data.push(tData)
  } else {
    $(`.${tData.type}-container > .label:not(.is-enabled)`).each(function(i,e){
      data.push($(e).data())
    })
  }
  $('.growl-close').click()
  
  $(`.${tData.type}-container > .label`).removeClass('is-enabled')
  setRelation('add', data, target, tData.type, updateRelationCount)
})

$(document).on('click', '.relations-remove', function(e){
  const tData = $(e.target).is('a') ? $(e.target).data() : $(e.target).parents('a').data()
  if(!tData.type) return
  var data = []
  var target = null
  if(tData.key=='all'){
    target = e.target
    data.push(tData)
  } else {
    $(`.${tData.type}-container > .label:not(.is-enabled)`).each(function(i,e){
      data.push($(e).data())
    })
  }
  setRelation('remove', data, target, tData.type, updateRelationCount)
})

$(document).on('click', '.relation-item', function(e){
  const target = $(e.target)
  const data = target.data()
  const action = target.hasClass('is-enabled') ? 'remove' : 'add'
  const pressed = $('.relations-add-single')
  pressed.addClass('d-none')
  setRelation(action, [data], e.target, data.type, updateRelationCount)
})

