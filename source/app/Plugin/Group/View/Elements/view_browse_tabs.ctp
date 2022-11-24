<?php $this->setBodyClass('floating-menu'); ?>
<div class="bar-action-floating">
    <div class="container">
        <div id="stickyBrowseMenu" class="horizontal-main">
            <div class="horizontal-content">
                <div class="horizontal-menu-warp">
                    <ul id="browseGroupDetail" class="browse-menu core-horizontal-menu horizontal-menu">
                        <li id="browse_all" class="current">
                            <a class="horizontal-menu-link" href="<?php echo $this->request->base?>/groups/view/<?php echo $group['Group']['id']?>">
                                <span class="horizontal-menu-icon material-icons moo-icon moo-icon-library_books">library_books</span>
                                <span class="horizontal-menu-text"><?php echo __( 'Details')?></span>
                            </a>
                        </li>
                        <li>
                            <a class="horizontal-menu-link core-menu-ajax" header-title="<?php echo __( 'Members')?>" ajax-type="html" data-url="<?php echo $this->request->base?>/groups/members/<?php echo $group['Group']['id']?>" rel="profile-content" id="teams" href="<?php echo $this->request->base?>/groups/view/<?php echo $group['Group']['id']?>/tab:teams">
                                <span class="horizontal-menu-icon material-icons moo-icon moo-icon-people">people</span>
                                <span class="horizontal-menu-text"><?php echo __( 'Members')?></span>
                                <span id="group_user_count" class="badge_counter"><?php echo $group['Group']['group_user_count']?></span>
                            </a>
                        </li>
                        <li>
                            <a class="horizontal-menu-link core-menu-ajax" header-title="<?php echo __( 'Photos')?>" ajax-type="html" data-url="<?php echo $this->request->base?>/photos/ajax_browse/group_group/<?php echo $group['Group']['id']?>" rel="profile-content" id="photos" href="<?php echo $this->request->base?>/groups/view/<?php echo $group['Group']['id']?>/tab:photos">
                                <span class="horizontal-menu-icon material-icons moo-icon moo-icon-collections">collections</span>
                                <span class="horizontal-menu-text"><?php echo __('Photos')?></span>
                                <span id="group_photo_count" class="badge_counter"><?php echo $group['Group']['photo_count'];?></span>
                            </a>
                        </li>
                        <?php foreach ($group_menu as $item): ?>
                        <li>
                            <a class="horizontal-menu-link core-menu-ajax" header-title="<?php echo $item['name']?>" ajax-type="html" data-url="<?php echo $item['dataUrl']?>" rel="profile-content" id="<?php echo $item['id']?>" href="<?php echo $item['href']?>">
                                <span class="horizontal-menu-icon material-icons moo-icon moo-icon-<?php echo $item['icon-class']?>"><?php echo $item['icon-class']?></span>
                                <span class="horizontal-menu-text"><?php echo $item['name']?></span>
                                <span id="<?php echo $item['id_count']?>" class="badge_counter"><?php echo $item['item_count']?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
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
                <?php if ((empty($uid) && !empty($invited_user)) || (!empty($uid) && (($group['Group']['type'] != PRIVACY_PRIVATE && empty($my_status['GroupUser']['status'])) || ($group['Group']['type'] == PRIVACY_PRIVATE && !empty($my_status) && $my_status['GroupUser']['status'] == 0 ) ) ) ): ?>
                    <a class="box-btn btn btn-header_title btn-cs join-btn" href="<?php echo  $this->request->base ?>/groups/do_request/<?php echo  $group['Group']['id'] ?>">
                        <span class="btn-cs-main">
                            <span class="btn-icon material-icons moo-icon moo-icon-group_add">group_add</span>
                            <span class="btn-text hidden-xs"><?php echo  __('Join') ?></span>
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