<?php if (!empty($uid)): ?>
<?php $this->setBodyClass('floating-menu'); ?>
<div class="bar-action-floating">
    <div class="container">
        <div id="stickyBrowseMenu" class="horizontal-main">
            <div class="horizontal-content">
                <div class="horizontal-menu-warp">
                    <ul class="browse-menu core-horizontal-menu horizontal-menu">
                        <li id="browse_all" class="<?php if(empty($cat_id)): ?>current<?php endif; ?>">
                            <a class="horizontal-menu-link core-menu-ajax" header-title="<?php echo __( 'All Photos')?>" ajax-type="html" rel="album-list-content" data-url="<?php echo $this->request->base ?>/albums/browse/all" href="<?php echo $this->request->base ?>/albums">
                                <span class="horizontal-menu-text"><?php echo __('All Photos') ?></span>
                            </a>
                        </li>
                        <?php //if (!empty($uid)): ?>
                        <li>
                            <a class="horizontal-menu-link core-menu-ajax" header-title="<?php echo __( 'My Photos')?>" ajax-type="html" rel="album-list-content" data-url="<?php echo $this->request->base ?>/albums/browse/my" href="<?php echo $this->request->base ?>/albums">
                                <span class="horizontal-menu-text"><?php echo __('My Photos') ?></span>
                            </a>
                        </li>
                        <li>
                            <a class="horizontal-menu-link core-menu-ajax" header-title="<?php echo __( "Friends' Photos")?>" ajax-type="html" rel="album-list-content" data-url="<?php echo $this->request->base ?>/albums/browse/friends" href="<?php echo $this->request->base ?>/albums">
                                <span class="horizontal-menu-text"><?php echo __("Friends' Photos") ?></span>
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
                    <?php $this->MooPopup->tag(array(
                        'href'=>$this->Html->url(array("controller" => "albums",
                            "action" => "create",
                            "plugin" => 'photo'
                        )),
                        'title' => __( 'Create New Album'),
                        'innerHtml'=> '<span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>',
                        'data-backdrop' => 'static',
                        'class' => 'box-btn btn-header_icon box-add'
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
