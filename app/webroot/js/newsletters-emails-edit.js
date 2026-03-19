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
        rel_id: $('input[name="id"]').val(),
        type: 'product',
        source: 'newsletter',
        model: 'NewsletterProduct'
      })
    }, 500)        
  })


  let checkRedirect = null

  $('#newsletter_edit').submit(function(e){
    return true
    
    console.log('newsletter_edit(submit)',e)
    e.preventDefault()

    $('input[type="submit"]').addClass('btn-loading')
    console.log('checkRedirect(1)',checkRedirect)

    return setTimeout(function(){
      console.log('checkRedirect(2)',checkRedirect)
      return false
    }, 1000)
  })

  $('input[type="submit"]').click(function(event) {
    console.log('submitButton(click)',event)
      var pageX = event.pageX; // X coordinate relative to the document
      var pageY = event.pageY; // Y coordinate relative to the document

      console.log("Document X: " + pageX + ", Document Y: " + pageY);

      // Optional: Get coordinates relative to the button itself
      var offset = $(this).offset();
      var relativeX = event.pageX - offset.left;
      var relativeY = event.pageY - offset.top;
      
      console.log("Relative X: " + relativeX + ", Relative Y: " + relativeY);

      // You can store these values or use them as needed
      // For example, adding them to a hidden input field before the form submits
      $('#mouseX').val(pageX);
      $('#mouseY').val(pageY);
      console.log('checkRedirect(=)')
      checkRedirect = '/admin/newsletters/emails'
      // If this is a submit button, the form will submit after this code runs
  });  
})

CKEDITOR.replace('newsletter');

$(document).on('click', '.product-item', function(e){
  const target = $(e.target)
  const data = target.data()
  const action = target.hasClass('is-enabled') ? 'remove' : 'add'
  setRelation(action, data, target)
})

