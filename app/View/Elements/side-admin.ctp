<?php
/**
 * side.php
 *
 * Author: pixelcave
 *
 * The side content of the page
 *
 */
?>

<!-- Left Sidebar -->
<!-- In the PHP version you can set the following options from the config file -->
<!-- Add the class .sticky for a sticky sidebar -->
<aside id="page-sidebar" class="collapse navbar-collapse navbar-main-collapse<?php if ($template['sidebar'] == 'sticky') { echo ' sticky'; } ?>">
    <!--
    Wrapper for scrolling functionality
    Used only if the .sticky class added above. You can remove it and you will have a sticky sidebar
    without scrolling enabled when you set the sidebar to be sticky
    -->
    <div class="side-scrollable">
        <!-- Mini Profile -->
        <div class="mini-profile">
            <?php echo $this->Html->image('logo.jpg', array('class' => 'img-responsive')); ?>
        </div>
        <!-- END Mini Profile -->

        <!-- Sidebar Tabs -->
        <div class="sidebar-tabs-con">
            <ul class="sidebar-tabs" data-toggle="tabs">
                <li class="active">
                    <a href="#side-tab-menu"><i class="gi gi-list"></i></a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="side-tab-menu">
                    <!-- Primary Navigation -->
                    <nav id="primary-nav">
                        <?php if ($primary_nav) { ?>
                        <ul> 
                            <?php foreach ($primary_nav as $key => $link) {
                                $link_class = '';
                            //   pr($link);die;
                                // Get link's vital info
                                $url = (isset($link['url']) && $link['url']) ? $link['url'] : '#';
                                $active = (isset($link['url']) && ($template['active_page'] == $link['url'])) ? ' active' : '';
                                $icon = (isset($link['icon']) && $link['icon']) ? '<i class="' . $link['icon'] . '"></i>' : '';

                                // Check if we need add the class active to the li element (only if a sublink is active)
                                $li_active = '';
                                $menu_link = '';

                                if (isset($link['sub']) && $link['sub']) {
                                    foreach ($link['sub'] as $sub_link) {
                                        if (in_array($template['active_page'], $sub_link)) {
                                            $li_active = ' class="active"';
                                            break;
                                        }

                                        // Check and sublinks for active class if they exist
                                        if (isset($sub_link['sub']) && $sub_link['sub']) {
                                            foreach ($sub_link['sub'] as $sub2_link) {
                                                if (in_array($template['active_page'], $sub2_link)) {
                                                    $li_active = ' class="active"';
                                                    break;
                                                }
                                            }
                                        }
                                    }

                                    $menu_link = 'menu-link';
                                }

                                if ($menu_link || $active)
                                    $link_class = ' class="'. $menu_link . $active .'"';
                            ?>
                            <li<?php echo $li_active; ?>>
                                <a href="<?php echo '/chatelet-new/web'.$url; ?>"<?php echo $link_class; ?>><?php echo $icon . $link['name']; ?></a>
                                <?php if (isset($link['sub']) && $link['sub']) { ?>
                                    <ul>
                                        <?php foreach ($link['sub'] as $sub_link) {
                                            $link_class = '';

                                            // Get sublink's vital info
                                            $url = (isset($sub_link['url']) && $sub_link['url']) ? $sub_link['url'] : '#';
                                            $active = (isset($sub_link['url']) && ($template['active_page'] == $sub_link['url'])) ? ' active' : '';

                                            // Check if we need add the class active to the li element (only if a sublink is active)
                                            $li2_active = '';
                                            $submenu_link = '';

                                            if (isset($sub_link['sub']) && $sub_link['sub']) {
                                                foreach ($sub_link['sub'] as $sub2_link) {
                                                    if (in_array($template['active_page'], $sub2_link)) {
                                                        $li2_active = ' class="active"';
                                                        break;
                                                    }
                                                }

                                                $submenu_link = 'submenu-link';
                                            }

                                            if ($submenu_link || $active)
                                                $link_class = ' class="'. $submenu_link . $active .'"';
                                        ?>
                                        <li<?php echo $li2_active; ?>>
                                            <a href="<?php echo $url; ?>"<?php echo $link_class; ?>><?php echo $sub_link['name']; ?></a>
                                            <?php if (isset($sub_link['sub']) && $sub_link['sub']) { ?>
                                                <ul>
                                                    <?php foreach ($sub_link['sub'] as $sub2_link) {
                                                        // Get vital info of sublinks
                                                        $url = (isset($sub2_link['url']) && $sub2_link['url']) ? $sub2_link['url'] : '#';
                                                        $active = (isset($sub2_link['url']) && ($template['active_page'] == $sub2_link['url'])) ? ' class="active"' : '';
                                                    ?>
                                                    <li>
                                                        <a href="<?php echo $url; ?>"<?php echo $active ?>><?php echo $sub2_link['name']; ?></a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            <?php } ?>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </nav>
                    <!-- END Primary Navigation -->
                </div>
            </div>
        </div>
        <!-- END Sidebar Tabs -->
    </div>
    <!-- END Wrapper for scrolling functionality -->
</aside>
<!-- END Left Sidebar -->
