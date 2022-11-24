<?php if (!empty($cuser)): ?>
<?php $this->setBodyClass('floating-menu'); ?>
<div class="bar-action-floating">
    <div class="container">
        <div id="stickyBrowseMenu" class="horizontal-main">
            <div class="horizontal-content">
                <div class="horizontal-menu-warp">
                    <ul class="browse-menu core-horizontal-menu horizontal-menu">
                        <li id="browse_all" class="current">
                            <a class="horizontal-menu-link core-menu-ajax" header-title="<?php echo __( 'Everyone')?>" ajax-type="html" data-url="<?php echo $this->request->base?>/users/ajax_browse/all" href="<?php echo $this->request->base?>/users">
                                <span class="horizontal-menu-text"><?php echo __( 'Everyone')?></span>
                            </a>
                        </li>
                        <?php //if (!empty($cuser)): ?>
                        <li>
                            <a class="horizontal-menu-link core-menu-ajax" header-title="<?php echo __( 'My Friends')?>" ajax-type="html" data-url="<?php echo $this->request->base?>/users/ajax_browse/friends" href="<?php echo $this->request->base?>/users">
                                <span class="horizontal-menu-text"><?php echo __('My Friends')?></span>
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
                <?php if (Configure::read("core.allow_invite_friend")):?>
                    <a class="box-btn btn btn-header_title btn-cs" href="<?php echo $this->request->base?>/friends/ajax_invite?mode=model" data-target="#themeModal" data-toggle="modal" data-dismiss="" data-backdrop="static" title="<?php echo __('Invite Friends');?>">
                        <span class="btn-cs-main">
                            <span class="btn-icon material-icons moo-icon moo-icon-person_add">person_add</span> <span class="btn-text hidden-xs"><?php echo __('Invite Friends');?></span>
                        </span>
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
<?php endif; ?>
