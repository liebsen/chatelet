<?php echo $this->Session->flash() ?>
<div class="wrapper content animation-fadeIn animation-both delay1">
  <div id="carousel" class="carousel slide animation-fadeIn delay" data-type="slider" data-interval="10000" data-ride="carousel">
    <?php echo $this->element('carousel') ?>
  </div>
  <section id="listShop">
    <?php echo $this->element('shop/list') ?>
  </section>
<?php if(!$loggedIn): ?>
  <?php echo $this->element('subscribe-box') ?>
<?php endif ?>
  <?php echo $this->element('follow_us') ?>
</div>
<?php echo $this->element('img_popup_newsletter') ?>
<?php
if(!empty($home['display_popup_form_in_last'])):?>
<style type="text/css">

  .news-carousel .item:last-child .in_last form {
    position: absolute!important;
    top:0px;
  }

  .news-carousel .item:last-child .in_last form input[type="email"] {
    margin-top: 217px;
    margin-left: 36px;
    border: none!important;
  }

  .news-carousel .item:last-child .in_last form input[type="submit"] {
    margin-top: 30px;
    float: left!important;
    border: none!important;
    margin-left: 50px;
    clear: both;
    color: transparent!important;
  }

</style>

<?php endif; ?>

<script type="text/javascript">
  function checkModal(){
    const today = new Date()
    var modalDate = today
    const dateStr = localStorage.getItem('modalDate')
    if (dateStr) {
      modalDate = new Date(dateStr)
    }
    const diffInMs = Math.abs(today - modalDate);
    const diffInMins = diffInMs / (1000 * 60);
    const diffInHours = diffInMs / (1000 * 60 * 60);
    setTimeout(function () {
      if(
        (diffInMins > 15 || !dateStr) && 
        document.querySelector("#myModal")
      ){
        localStorage.setItem('modalDate', today.toISOString());
        $('#myModal').modal({ show: true })
      } else {
        $('body, html').removeClass('noscroll')
      }
    }, 10)
  }
  $(document).ready(function() {
    checkModal()  
  })

</script>



