<?php if(empty($region)): ?>
    <?php
    $class_menu = 'menu_' . $menu_id;
    $class_footer = (isset($isFooterMenu) && $isFooterMenu) ? ' core_footer_menu':'';
    echo $this->Menu->generate(null, $menu_id, array('class' => "$class_menu core_menu".$class_footer));
    ?>
<?php else: ?>
    <?php $menu_attr_id = 'core_menu_' . $menu_id; ?>
    <?php if($region == 'center'): ?>
    <div class="menu-center-warp">
        <?php echo $this->Menu->generate(null, $menu_id, array('id' => $menu_attr_id, 'class' => "core_widget_menu")); ?>
    </div>
    <?php else: ?>
        <div class="box2 bar-content-warp">
            <div class="box_content box_menu box-region-<?php echo $region ?>">
                <?php echo $this->Menu->generate(null, $menu_id, array('id' => $menu_attr_id, 'class' => "core_widget_menu")); ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>