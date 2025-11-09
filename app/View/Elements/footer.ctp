  <?php echo $this->Html->css('font-awesome', array('inline' => false)); ?>
  <?php echo $this->element('whatsapp') ?>

  <footer>
    <div class="wrapper">
      <?php echo $this->element('footer-options') ?>
    </div>

    <?php echo $this->element('signature') ?>
  </footer>
  
  <?php echo $this->Html->script('plugins', array('inline'=>false))?>
