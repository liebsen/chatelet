<?php if($_SERVER['SERVER_NAME'] == 'chatelet.com.ar'): ?>
  <!--Start of Zopim Live Chat Script-->
  <script type="text/javascript">
  window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
  d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
  _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
  $.src='//v2.zopim.com/?2Wx0R7RlF7N6Yb4hFuFsPHPplnWJdWI1';z.t=+new Date;$.
  type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
  </script>
  <!--End of Zopim Live Chat Script-->
<?php endif ?>

  <?php

    //echo $this->Html->script('jquery-1.11.1.min');
    //echo $this->Html->script('jquery-1.11.1.min');
  	echo $this->Html->script('vendor/jquery.min');
    echo $this->Html->script('vendor/modernizr-2.8.3.min.js');
    #echo $this->Html->script('bootstrap');
    echo $this->Html->script('vendor/bootstrap.min');
    echo $this->Html->script('jquery.growl');
    echo $this->Html->script('bootstrap-select.min');
    echo $this->Html->script('bootstrapValidator.min');
    echo $this->Html->script('plugins');
    echo $this->Html->script('chatelet');

    if(!empty($user['id']) && $_SERVER['REQUEST_SCHEME'] === 'https' ) { 
      echo $this->Html->script('webpush.js?v='.$version['ver'], array('inline' => false));
    }

    echo $this->fetch('script');

  ?>
    <script>
    	document.addEventListener("DOMContentLoaded", function() {
	      $.ajaxSetup({
	        cache:false,
	        dataType: "json",
	        xhrFields: {
	          withCredentials: true
	        },
	      });
	    })
    </script>
  </body>
</html>
