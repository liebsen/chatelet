$(document).ready(function() {
  $('.btn-append-editor').click(function(){
		CKEDITOR.instances.newsletter.insertText($(this).data('text'));
  })

  let interval = 0
  $('#product-filter').keyup(e => {
    let q = $(e.target).val().trim()
    if (q.length < 3) {
      $('.product-container .label:not(.is-enabled)').remove()
      return false
    }
    $(e.target).addClass('searching')
    clearInterval(interval)
    interval = setTimeout(() => {
      searchRelations({
        q,
        parentId: $('input[name="data[id]"]').val(),
        type: 'product',
        source: 'newsletter',
        model: 'NewsletterProduct'
      })
    }, 500)        
  })  
})

CKEDITOR.replace('newsletter');

$(document).on('click', '.product-item', function(e){
  const target = $(e.target)
  const data = target.data()
  const action = target.hasClass('is-enabled') ? 'remove' : 'add'
  setRelation(action, data, target)
})

