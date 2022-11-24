<?php if (!empty($uid)): ?>
<?php $this->setBodyClass('floating-menu'); ?>
<div class="bar-action-floating">
    <div class="container">
        <div id="stickyBrowseMenu" class="horizontal-main">
            <div class="horizontal-content">
                <div class="horizontal-menu-warp">
                    <ul class="browse-menu core-horizontal-menu horizontal-menu">
                        <li id="browse_all" class="<?php if(empty($cat_id)): ?>current<?php endif; ?>">
                            <a class="horizontal-menu-link core-menu-ajax" header-title="<?php echo __( 'All Groups')?>" ajax-type="html" data-url="<?php echo $this->request->base ?>/groups/browse/all" href="<?php echo $this->request->base ?>/groups">
                                <span class="horizontal-menu-text"><?php echo __('All Groups') ?></span>
                            </a>
                        </li>
                        <?php //if (!empty($uid)): ?>
                        <li>
                            <a class="horizontal-menu-link core-menu-ajax" header-title="<?php echo __( 'My Groups')?>" data-url="<?php echo $this->request->base ?>/groups/browse/my" href="<?php echo $this->request->base ?>/groups">
                                <span class="horizontal-menu-text"><?php echo __('My Groups') ?></span>
                            </a>
                        </li>
                        <li>
                            <a class="horizontal-menu-link core-menu-ajax" header-title="<?php echo __( "Friends' Groups")?>" data-url="<?php echo $this->request->base ?>/groups/browse/friends" href="<?php echo $this->request->base ?>/groups">
                                <span class="horizontal-menu-text"><?php echo __("Friends' Groups") ?></span>
                            </a>
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
                    <?php echo $this->Html->link('<span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>', array(
                        'plugin' => 'Group',
                        'controller' => 'groups',
                        'action' => 'create'
                    ), array(
                        'title' => __('Create New Group'),
                        'class' => 'box-btn btn-header_icon box-add',
                        'escape' => false
                    )); ?>
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