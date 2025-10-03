

<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?=Configure::read('GA_CODE')?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '<?=Configure::read('GA_CODE')?>');
</script>
<!-- End Google Analytics -->

