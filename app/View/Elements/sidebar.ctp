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
	    console.log('sidebar click', {target, focus})

	    if($(target).length) {
	      if(!$(target).hasClass('sidebar-expanded')) {
	        $(target).addClass('sidebar-expanded')
	        $('.sidebar-backdrop').fadeIn()
	        if($(focus).length) {
	          setTimeout(() => {
	            $(focus).focus()
	          }, 1000)
	        }
	      }
	    }
	  })
	})

</script>