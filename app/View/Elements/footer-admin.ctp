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
    echo $this->Html->script('main');
    echo $this->fetch('script');
?>