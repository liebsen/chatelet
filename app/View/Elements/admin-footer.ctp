    <footer>
        <div class="pull-left">
            <a href="https://chatelet.com.ar" target="_blank">
                <span id="year-copy"></span> &copy; <strong><?php echo $template['name'] . ' ' . $template['version']; ?></strong>
            </a>
        </div>
    </footer>
</div>

<a href="#" id="to-top"><i class="fa fa-chevron-up"></i></a>

<?php
    echo $this->Html->script('jquery-1.11.0.min');
    echo $this->Html->script('bootstrap.min');
    echo $this->Html->script('jquery.growl');
    echo $this->Html->script('plugins');
    echo $this->Html->script('main.js?v=' . Configure::read('APP_VERSION'), array('inline' => false));
    echo $this->fetch('script');
?>

<?php if($_SERVER['REMOTE_ADDR'] == '127.0.0.1'): ?>
<script type="text/javascript">
document.addEventListener('keydown', function(event) {
    // Check using event.code for the physical key
    if (event.code === 'Space') {
        console.log('Space key pressed using event.code!');
        // Prevent the default action (e.g., scrolling down the page)
        event.preventDefault(); 
        location.reload(true)
    }

    // Check using event.key for the character value
    if (event.key === ' ') {
        console.log('Space key pressed using event.key!');
        location.reload(true)
    }
});
</script>
<?php endif ?>