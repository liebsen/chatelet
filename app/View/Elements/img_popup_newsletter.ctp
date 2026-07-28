<?php $popupBG = array_filter(explode(';', @$home['img_popup_newsletter'])) ?>

<?php if(!empty($popupBG)): ?>
  <div class="modal fade p-0" tabindex="-1" id="myModal" role="dialog" style="background-color: #333;">
    <div class="content js-show-modal is-clickable" data-dismiss="modal" style="background-image: url(<?=$popupBG[0]?>);">
      <div class="tap-to-continue animation-pullUp animation-both delay2" title="Continuar a la tienda">
        Continuar <span class="desktop"> a la tienda</span>
      </div>
    </div>
  </div>
<?php endif ?>

<script>
  $(function () {
    $('#myModal').on('hidden.bs.modal', () => {
    	console.log('hidden.bs.modal')
      $('body, html').removeClass('noscroll')
      var video = $("#carousel .item.active").find("video")
      if(video.length){
        video[0].play()
      }
    });
  })
</script>