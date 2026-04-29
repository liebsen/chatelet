$(document).ready(function() {
  $('.cloud-tag').each(function(i,e){
    const count = parseInt($(e).find('span').text())
    var size = count * Math.sqrt(count) + 6
    size = size > 30 ? 30 : size
    $(e).css('font-size', size)
  })
})