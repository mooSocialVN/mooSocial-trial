<?php if (!empty($uid)): ?>
<?php $this->setBodyClass('floating-menu'); ?>
<div class="bar-action-floating">
    <div class="container">
        <div id="stickyBrowseMenu" class="horizontal-main">
            <div class="horizontal-content">
                <div class="horizontal-menu-warp">
                    <ul class="browse-menu core-horizontal-menu horizontal-menu">
                        <li id="browse_all" class="<?php if(empty($cat_id)): ?>current<?php endif; ?>">
                            <?php echo $this->Html->link('<span class="horizontal-menu-text">' . __('All Videos') . '</span>', '/videos', array('class' => "horizontal-menu-link core-menu-ajax", 'header-title' => __('All Videos'), 'data-url' => $this->request->base . "/videos/browse/all", 'escape' => false)); ?>
                        </li>
                        <?php //if (!empty($uid)): ?>
                        <li>
                            <?php echo $this->Html->link('<span class="horizontal-menu-text">' . __('My Videos').'</span>',"/videos", array('class' => "horizontal-menu-link core-menu-ajax", 'header-title' =>__('My Videos'), 'data-url' => $this->request->webroot . "videos/browse/my", 'escape' => false)); ?>
                        </li>
                        <li>
                            <?php echo $this->Html->link('<span class="horizontal-menu-text">' . __("Friends' Videos") . '</span>', "/videos", array('class' => "horizontal-menu-link core-menu-ajax", 'header-title' =>__("Friends' Videos"), 'data-url' => $this->request->webroot . "videos/browse/friends", 'escape' => false)); ?>
                        </li>
                        <?php //endif; ?>
                        <li class="core-horizontal-more hasChild hidden">
                            <a class="horizontal-menu-link horizontal-menu-header no-ajax" href="javascript:void(0);">
                                <span class="horizontal-menu-icon material-icons moo-icon moo-icon-more_vert hidden">more_vert</span>
                                <span class="horizontal-menu-text"><?php echo __('More') ?></span>
                            </a>
                            <ul class="core-horizontal-dropdown horizontal-menu-sub"></ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="horizontal-action">
                <?php //if (!empty($uid)): ?>
                <?php $this->MooPopup->tag(array(
                        'href'=>$this->Html->url(array("controller" => "videos",
                            "action" => "create",
                            "plugin" => 'video',

                        )),
                        'title' => __( 'Share New Video'),
                        'innerHtml'=> '<span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>',
                        'data-backdrop' => 'static',
                        'class' => 'box-btn btn-header_icon box-add'
                    )); ?>
                <!-- Hook for video upload -->
                <?php $this->getEventManager()->dispatch(new CakeEvent('Video.View.Elements.uploadVideo', $this)); ?>
                <!-- Hook for video upload -->
                <?php //endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooCoreMenu'), 'object' => array('$', 'mooCoreMenu'))); ?>
    $('.core-horizontal-menu').HorizontalMenu({asStickyBrowseMenuFor: '#stickyBrowseMenu'});
    $('#stickyBrowseMenu').StickyBrowseMenu({asHorizontalMenuFor: '.core-horizontal-menu'});
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>