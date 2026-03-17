$(document).ready(function() {
  $('.btn-append-editor').click(function(){
		CKEDITOR.instances.newsletter.insertText($(this).data('text'));
  })

  let interval = 0
  $('#products-filter').keyup(e => {
    let q = $(e.target).val().trim()
    console.log('a(0)',q.length)

    if (q.length < 3) {
      $('.search-results').empty()
      return false
    }
    console.log('a(1)',q.length)

    
    $(e.target).addClass('searching')
    clearInterval(interval)
    interval = setTimeout(() => {
      prodSearch(q)
    }, 500)        
  })

  /*let clock = 0
  $('#products-filter').keyup(function(e){
    clearTimeout(clock)
    const value = $(e.target).val().toUpperCase()
    clock = setTimeout(() => {
      $('.product-item').each((j,i) => {
        if(!$(i).hasClass('is-enabled')){
          if($(i).text().toUpperCase().includes(value)) {
            $(i).removeClass('hidden')
          } else {
            $(i).addClass('hidden')
          }
        }
      })
    }, 500)
  })*/
})

CKEDITOR.replace('newsletter');

function prodSearch(q) { 
  console.log('prodSearch(q)', q)

  $.ajax({
    type: "POST",
    url: "/shop/api_search/",
    data: {
      q: q, 
      p: 0, 
      s: 10
    },
    success: function (data) {
      let str = ''

      $('.search-more').html('')
      $.each(data.results, function(key, item) {    
        /*let strLegends = ''
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
        }*/

        const newsletter_id = $('input[name="id"]').val();
        $('.products-container').append('<span class="label product-item is-clickable" data-rel_id="'+newsletter_id+'" data-type="product" data-id="'+item.id+'" data-type="product" data-source="newsletter" data-model="NewsletterProduct">'+item.name+'</span>');
        /*str += '<div class="col-sm-12 col-md-2 col-lg-2 search-item">' +
          '<a href="/tienda/producto/'+ item.id+'/'+item.category_id+'/'+item.slug+'">' + 
            '<div class="is-background-cover is-background-search" style="background-image: url('+item.img_url+')">' + (item.promo.length ? '<div class="ribbon sp3"><span>' + item.promo + '</span></div>' : '') + (item.number_ribbon ? '<div class="ribbon small bottom-left sp2"><span>' + item.number_ribbon + '% OFF</span></div>' : '') + '<p class="search-desc">'+item.desc+'</p></div>' + 
            '<h2 class="text-center">'+`<span>${item.name}</span>`+'</h2>' + 
            '<div class="price-list text-center mb-8">'+(item.old_price ? '<span class="old_price text-grey">$' + formatNumber(item.old_price) + '</span>' : '') + '<span>$' + formatNumber(item.price) + '</span></div>' + strLegends +
          '</a>' + 
        '</div>'*/
      })
    },
    error: function (errormessage) {
      console.log(errormessage)
      //oPrnt.find("ul.result").html('<li><b>No Results</b></li>');
    }
  }).then(() => {
    setTimeout(() => {
      $('#products-filter').removeClass('searching')
    }, 100)
  })    
}

$(document).on('click', '.product-item', function(e){

  const target = $(e.target)
  const data = target.data()
  const action = target.hasClass('is-enabled') ? 'remove' : 'add'

  $.post('/admin/relation_' + action, data)
    .success(function(res) {
      if (res.success) {
        $.growl.notice({
          title: action == 'add' ? 'Asociación exitosa' : 'Eliminación exitosa',
          message: action == 'add' ? 'Se asoció el producto exitosamente' : 'Se eliminó el producto exitosamente',
        });
        target.removeClass('is-enabled')
        if(action == 'add'){
          target.addClass('is-enabled')  
        }
      }
    })
    .fail(function() {
      $.growl.error({
        title: 'Ocurrio un error al agregar el producto al Newsletter',
        message: 'Por favor, intente nuevamente'
      });
    });
})