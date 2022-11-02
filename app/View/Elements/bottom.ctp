<?php if($_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['SERVER_NAME'] !== 'test.chatelet.com.ar'):?>
<!-- Start of  Zendesk Widget script -->
<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=f59c61de-fe9a-4a76-919e-553b511b4a91"> </script>
<!-- End of  Zendesk Widget script -->
<?php endif;?>

  	<?php
      echo $this->Html->script('chatelet', array('inline' => false));
      echo $this->Html->script('product', array('inline' => false));
      echo $this->fetch('script');
  	?>

  </body>
</html>
