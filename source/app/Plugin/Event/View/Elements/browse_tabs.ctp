<?php $this->setBodyClass('floating-menu'); ?>
<div class="bar-action-floating">
    <div class="container">
        <div id="stickyBrowseMenu" class="horizontal-main">
            <div class="horizontal-content">
                <div class="horizontal-menu-warp">
                    <ul class="browse-menu core-horizontal-menu horizontal-menu">
                        <li id="browse_all" class="<?php if(empty($cat_id)): ?>current<?php endif; ?>">
                            <?php echo $this->Html->link('<span class="horizontal-menu-text">'.__('Upcoming Events').'</span>', '/events', array('data-url' => $this->request->base . '/events/browse/upcoming', 'class' => "horizontal-menu-link core-menu-ajax", 'header-title' => __('Upcoming Events'),'escape' => false)); ?>
                        </li>
                        <?php if (!empty($uid)): ?>
                        <li>
                            <?php echo $this->Html->link('<span class="horizontal-menu-text">'.__('My Upcoming Events').'</span>', '/events', array('data-url' => $this->request->base . '/events/browse/my', 'class' => 'horizontal-menu-link core-menu-ajax', 'header-title' => __('My Upcoming Events'),'escape' => false)); ?>
                        </li>
                        <li>
                            <?php echo $this->Html->link('<span class="horizontal-menu-text">'.__('My Past Events').'</span>', '/events', array('data-url' => $this->request->base . '/events/browse/mypast', 'class' => 'horizontal-menu-link core-menu-ajax', 'header-title' => __('My Past Events'),'escape' => false)); ?>
                        </li>
                        <li>
                            <?php echo $this->Html->link('<span class="horizontal-menu-text">'.__('Friends Attending').'</span>', '/events', array('data-url' => $this->request->base . '/events/browse/friends', 'class' => 'horizontal-menu-link core-menu-ajax', 'header-title' => __('Friends Attending'),'escape' => false)); ?>
                        </li>
                        <?php endif; ?>
                        <li>
                            <?php echo $this->Html->link('<span class="horizontal-menu-text">'.__('Past Events').'</span>', '/events', array('data-url' => $this->request->base . '/events/browse/past', 'class' => 'horizontal-menu-link core-menu-ajax', 'header-title' => __('Past Events'),'escape' => false)); ?>
                        </li>
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
                <?php if (!empty($uid)): ?>
                    <a class="box-btn btn-header_icon box-add" href="<?php echo $this->request->base?>/events/create" title="<?php echo __( 'Create New Event')?>">
                        <span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooCoreMenu'), 'object' => array('$', 'mooCoreMenu'))); ?>
    $('.core-horizontal-menu').HorizontalMenu({asStickyBrowseMenuFor: '#stickyBrowseMenu'});
    $('#stickyBrowseMenu').StickyBrowseMenu({asHorizontalMenuFor: '.core-horizontal-menu'});
<?php $this->Html->scriptEnd(); ?>