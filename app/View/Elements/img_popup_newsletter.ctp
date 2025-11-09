  <?php $popupBG = array_filter(explode(';', @$home['img_popup_newsletter'])) ?>

  <div class="modal fade p-0" tabindex="-1" id="myModal" role="dialog" style="background-color: #262427;">
    <div class="content js-show-modal is-clickable" data-dismiss="modal" style="background-image: url(<?= Configure::read('uploadUrl').$popupBG[0] ?>);">
      <div class="tap-to-continue animated fadeIn delay" title="Continuar a la tienda">
        Continuar <span class="desktop"> a la tienda</span>
      </div>
    </div>
  </div>

<script>
  $(function () {
    $('#myModal').on('hidden.bs.modal', () => {
      $('body, html').removeClass('noscroll')
      focused = true
      var video = $("#carousel .item.active").find("video")
      if(video.length){
        video[0].play()
      }
    });
  })
</script>