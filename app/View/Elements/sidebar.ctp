<div class="sidebar-backdrop"></div>

<?php echo $this->element('sidebar-search'); ?>
<?php echo $this->element('sidebar-account'); ?>
<?php echo $this->element('sidebar-cart'); ?>
<?php echo $this->element('shop-options'); ?>

<script type="text/javascript">
	
	$(function () {

		console.log('length', $('[data-toggle="sidebar"]').length)
	  $(document).on('click', '[data-toggle="sidebar"]', (e) => {
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