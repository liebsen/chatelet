<div class="sidebar-backdrop"></div>

<?php echo $this->element('sidebar-search'); ?>
<?php echo $this->element('sidebar-account'); ?>
<?php echo $this->element('sidebar-cart'); ?>
<?php echo $this->element('shop-options'); ?>

<script type="text/javascript">
	
	$(function () {

	  $('.sidebar-backdrop, .btn-close-sidebar').click((e) => {
	    if($('nav.sidebar-expanded').length) {
	      $('.sidebar').removeClass('sidebar-expanded')
	      $('.sidebar-backdrop').fadeOut()
	    }
	  })

	  // $(document).on('click', '[data-toggle="sidebar"]', (e) => {
	  $('[data-toggle="sidebar"]').click((e) => {
	    const target = $(e.target).data('target')
	    const focus = $(e.target).data('focus')
	    if($(target).length) {
	      if(!$(target).hasClass('sidebar-expanded')) {
	        $(target).addClass('sidebar-expanded')
	        $('.sidebar-backdrop').fadeIn()
	        if($(focus).length) {
	          setTimeout(() => {
	            $(focus).focus()
	          }, 200)
	        }
	      }
	    }
	  })
	})

</script>

<style type="text/css">

.sidebar-backdrop {
	display: none;
  position: fixed;
  left: 0;
  top: 0;
  right: 0;
  bottom: 0;
  z-index: 10;
  background-color: black!important;
  opacity: 0.75;
}

nav.sidebar {
  position: fixed;
  z-index: 90;
  top: 0px;
  right: -320px;
  bottom: 0;
  width: 320px;
  height: 100%;
  background: white;
  padding: 1rem;
  transition: all 0.25s ease-in-out;
}

.sidebar-top {
  overflow-x: auto;
  width: 100%;
  /*max-height: calc(100dvh - 17rem);*/
  flex: 1;
}

.sidebar-bottom {
  background-color: #fff;
  width: 100%;
}
	
</style>