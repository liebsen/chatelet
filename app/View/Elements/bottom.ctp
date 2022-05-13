<?php if($_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['SERVER_NAME'] !== 'test.chatelet.com.ar'):?>
  <!--Start of Zopim Live Chat Script-->
  <script type="text/javascript">
  window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
  d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
  _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
  $.src='//v2.zopim.com/?2Wx0R7RlF7N6Yb4hFuFsPHPplnWJdWI1';z.t=+new Date;$.
  type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
  </script>
  <!--End of Zopim Live Chat Script-->
<?php endif;?>

  	<?php
      echo $this->Html->script('chatelet', array('inline' => false));
      echo $this->Html->script('product', array('inline' => false));
      echo $this->fetch('script');
  	?>

  </body>
</html>
