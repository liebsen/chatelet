$(document).ready(function() {
  $('#add-logistoc-price').click(e => {

  });
});

function edit_logistic_price(price_id) {
  let block = $('#prices_' + price_id)
  if (block) {
    console.log(price_id)
    $('.logistic-price-form #id').val(price_id)
    $('.logistic-price-form #zips').val(block.find('.zips').text().trim())
    $('.logistic-price-form #info').val(block.find('.info').text().trim())
    $('.logistic-price-form #price').val(block.find('.price').text().trim())
  }
  $('.logistic-price-form').removeClass('hide')
  console.log('edit_logistic_price')
} 

function save_logistic_price () {
  var formData = Object.fromEntries(new FormData(document.getElementById('add_logistic_price')).entries())
  $('#table_prices tr').removeClass('bg-success')
  $.post('/admin/save_logistic_price', formData).then(res => {
    let data = JSON.parse(res)
    if(data.status === 'success') {
      let block = $('#prices_' + data.data.id)
      if (block.length) {
        console.log(block)
        block.find('.zips').text(formData.zips)
        block.find('.info').text(formData.info)
        block.find('.price').text(formData.price)
        block.addClass('bg-success')
      } else {
        let row = `<tr id="prices_${data.data.id}" class="bg-success">
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
  })
  return false;
}

function remove_logistic_price(price_id) {
  if (confirm('Realmente deseas eliminar esta tarifa?')) {
    $.post('/admin/remove_logistic_price', { id: price_id }).then(res => {
      let data = JSON.parse(res)
      if(data.status === 'success') {
        $('#prices_' + price_id).remove()
      }
    })
  }
} 
