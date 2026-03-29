let interval = 0
const endpoints = { 
  user: {
    url: '/admin/search_users',
    parent: 'input[name="data[newsletter_id]"]',
    model: 'NewsletterUser',
    source: 'schedule',
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
      $(`.${type}-container .label:not(.is-enabled)`).remove()
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
  $.post('/admin/relation_' + action, {
    data: data
  }).success(function(res) {
    if (res.success) {
      $.growl.notice({
        title: action=='add' ? 'Agregado' : 'Eliminado',
        message: `Se ${action=='add' ? 'agregó' : 'eliminó'} la relación exitosamente`,
      });
      if(action=='add'){
        $(target || '.' + type + '-container .label:not(.is-enabled)').addClass('is-enabled')
      } else {
        $(target || '.' + type + '-container .label.is-enabled').removeClass('is-enabled')
      }
      if(typeof cb == 'function') {
        cb(type)
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

function unrelateAll(e){
  const type = $(e.target).data('type')
  if(!type) return
  var data = []
  $(`.${type}-container > .label.is-enabled`).each(function(i,e){
    data.push($(e).data())
  })
  setRelation('remove', data, null, type, updateRelationCount)
}

function relateAll(e){
  const type = $(e.target).data('type')
  if(!type) return
  var data = []
  $(`.${type}-container > .label:not(.is-enabled)`).each(function(i,e){
    data.push($(e).data())
  })
  setRelation('add', data, null, type, updateRelationCount)
  $(`.advanced-action-add`).addClass('d-none')
}

function updateRelationCount(type){
  const count = $(`.${type}-container .label.is-enabled`).length
  if(!count) return
  $(`.${type}-count`).text(count)
}

function searchRelations(data) { 
  const curr = endpoints[data.type] || {}
  if(!curr.model) return 
  $('.advanced-action-add').addClass('d-none')
  $('.advanced-action-remove').addClass('d-none')
  $.ajax({
    type: "POST",
    url: curr.url,
    data: {
      q: data.q, 
      p: 0, 
      s: 10
    },
    success: function (res) {
      let str = ''
      let ids = []
      let filter = []      
      $(`#${data.type}-filter`).addClass('searching')
      $(`.${data.type}-container > .label:not(.is-enabled)`).remove()
      $(`.${data.type}-container > .h6`).remove()
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
        console.log('curr.parent',curr.parent)
        console.log('parentId',parentId)

        $.each(filter, function(key, item) {
          $(`.${data.type}-container`).append(`<span class="label relation-item ${data.type == 'user' ? 'text-lowercase' : ''} is-clickable" data-parent-id="${parentId}" data-id="${item.id}" data-type="${data.type}" data-source="${curr.source}" data-model="${curr.model}">${item[curr.field]}</span>`);
        })
        if(typeof data.cb == 'function') {
          data.cb(filter.length)
        }
        $('.advanced-action-add').removeClass('d-none')
        $('.advanced-action-remove').addClass('d-none')
      } else {
        $(`.${data.type}-container`).append(`<span class="h6">No se hallaron resultados para <b>${data.q}</b></span>`)  
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

$(document).on('click', '.advanced-action-add', function(e){
  relateAll(e)
})

$(document).on('click', '.advanced-action-remove', function(e){
  unrelateAll(e)
})


$(document).on('click', '.relation-item', function(e){
  const target = $(e.target)
  const data = target.data()
  const action = target.hasClass('is-enabled') ? 'remove' : 'add'
  setRelation(action, [data], e.target, data.type, updateRelationCount)
})

