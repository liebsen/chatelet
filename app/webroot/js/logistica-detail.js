$(document).ready(() => {
  if (!$('#code').is(':disabled')) {
    $('#title').keyup(e => {
      let str = $(e.target).val()
      let slug = convertToSlug(str)
      $('#code').val(slug)
    })
  }
})

function convertToSlug(Text) {
  return Text.toLowerCase().replace(/ /g, '').replace(/[^\w-]+/g, '')
}

function edit_logistic_price(price_id) {
  let block = $('#prices_' + price_id)
  if (block) {
    var radio = block.hasClass('bg-light') ? 0 : 1
    $(`.logistic-price-form #enabled_${radio}`).prop('checked', true)
    $('.logistic-price-form #id').val(price_id)
    $('.logistic-price-form #zips').val(block.find('.zips').text().trim())
    $('.logistic-price-form #info').val(block.find('.info').text().trim())
    $('.logistic-price-form #title').val(block.find('.title').text().trim())
    $('.logistic-price-form #price').val(block.find('.price').text().trim())
  }
  $('.logistic-price-form').removeClass('hide')
} 

function save_logistic_price () {
  var formData = Object.fromEntries(new FormData(document.getElementById('add_logistic_price')).entries())
  $('#table_prices tr').removeClass('bg-success')
  $('.btn-save-logistic-prices').button('loading')
  $.post('/admin/save_logistic_price', formData).then(res => {
    setTimeout(() => {
      $('.btn-save-logistic-prices').button('reset')
      let data = JSON.parse(res)
      if(data.status === 'success') {
        var block = $('#prices_' + data.data.id)
        var state = data.data.enabled == 1 ? 'bg-success' : 'bg-light'
        console.log('state', state)
        if (block.length) {
          block.removeClass('bg-light')
          block.addClass(state)
          block.find('.zips').text(data.data.zips)
          block.find('.info').text(data.data.info)
          block.find('.title').text(data.data.title)
          block.find('.price').text(data.data.price)          
        } else {
          
          let row = `<tr id="prices_${data.data.id}" class="${state}">
            <td>
              <p class="title">
                <strong>${data.data.title}</strong>
              </p>
            </td>
            <td>
              <p class="zips">
                ${data.data.zips}
              </p>
            </td>
            <td>
              <p class="price">
                ${data.data.price}
              </p>
            </td>
            <td>
              <p class="info">
                ${data.data.info}
              </p>
            </td>
            <td>
              <div class="controls">
                <button class="btn btn-success" type="button" onclick="edit_logistic_price(${data.data.id})">
                  <i class="gi gi-pencil"></i>
                </button>
                <button class="btn btn-danger" type="button" onclick="remove_logistic_price(${data.data.id})">
                  <i class="gi gi-remove"></i>
                </button>
              </div>
            </td>
          </tr>`
          $('#table_prices').append(row)
        }
        $('.logistic-price-form').addClass('hide')
      }
    }, 500)
  })
  return false;
}

function remove_logistic_price(price_id, target) {
  if (confirm('Realmente deseas eliminar esta tarifa?')) {
    $(target).button('loading')
    $.post('/admin/remove_logistic_price', { id: price_id }).then(res => {
      setTimeout(() => {
        $(target).button('reset')
        let data = JSON.parse(res)
        if(data.status === 'success') {
          $('#prices_' + price_id).remove()
        }
      }, 2000)
    })
  }
} 
