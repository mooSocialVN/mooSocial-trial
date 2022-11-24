<?php $this->isFloatingSubMenu = true; ?>
<div class="bar-action-floating">
    <div class="container">
        <div id="stickyBrowseMenu" class="horizontal-main">
            <div class="horizontal-content">
                <div class="horizontal-menu-warp">
                    <ul class="browse-menu core-horizontal-menu horizontal-menu">
                        <li <?php if ($type == 'notifications'):?> class="current" <?php endif;?> id="browse_all">
                            <a class="horizontal-menu-link no-ajax" header-title="<?php echo __( 'Notifications')?>" ajax-type="html" data-url="<?php echo $this->request->base?>/user_info/index/notifications" href="<?php echo $this->request->base?>/user_info/index/notifications">
                                <!--<span class="horizontal-menu-icon material-icons">home</span>-->
                                <span class="horizontal-menu-text"><?php echo __( 'Notifications')?></span>
                                <span id="notification_count" class="badge_counter"><?php echo $cuser['notification_count']?></span>
                            </a>
                        </li>
                        <li <?php if ($type == 'messages'):?> class="current" <?php endif;?>>
                            <a class="horizontal-menu-link no-ajax" header-title="<?php echo __('Messages')?>" ajax-type="html" data-url="<?php echo $this->request->base?>/user_info/index/messages" href="<?php echo $this->request->base?>/user_info/index/messages">
                                <span class="horizontal-menu-text"><?php echo __('Messages')?></span>
                                <span class="badge_counter"><?php echo $cuser['conversation_user_count']?></span>
                            </a>
                        </li>
                        <li <?php if ($type == 'friends'):?> class="current" <?php endif;?>>
                            <a class="horizontal-menu-link no-ajax" header-title="<?php echo __("Friends")?>" ajax-type="html" data-url="<?php echo $this->request->base?>/user_info/index/friends" href="<?php echo $this->request->base?>/user_info/index/friends">
                                <span class="horizontal-menu-text"><?php echo __("Friends")?></span>
                                <span id="friend_count" class="badge_counter"><?php echo $friend_count?></span>
                            </a>
                        </li>
                        <?php if (Configure::read("core.allow_invite_friend")):?>
                        	<li <?php if ($type == 'invite_friends'):?> class="current" <?php endif;?>>
				                <a class="horizontal-menu-link no-ajax" header-title="<?php echo __("Invite Friends")?>" ajax-type="html" data-url="<?php echo $this->request->base?>/user_info/index/invite_friends" href="<?php echo $this->request->base?>/user_info/index/invite_friends">
	                                <span class="horizontal-menu-text"><?php echo __("Invite Friends")?></span>
	                            </a>
                            </li>
			            <?php endif;?>
			
			            <li <?php if ($type == 'request_friends'):?> class="current" <?php endif;?> <?php if ( !$cuser['friend_request_count'] ) echo 'style="display:none"' ?>>
			                <a class="horizontal-menu-link no-ajax" header-title="<?php echo __("Friend Requests")?>" ajax-type="html" data-url="<?php echo $this->request->base?>/user_info/index/request_friends" href="<?php echo $this->request->base?>/user_info/index/request_friends">
                                <span class="horizontal-menu-text"><?php echo __("Friend Requests")?></span>
                                <span class="badge_counter"><?php echo $cuser['friend_request_count']?></span>
                            </a>
			            </li>
                        <li class="core-horizontal-more hasChild hidden">
                            <a class="horizontal-menu-link horizontal-menu-header no-ajax" href="javascript:void(0);">
                                <span class="horizontal-menu-icon material-icons hidden">more_vert</span>
                                <span class="horizontal-menu-text"><?php echo __('More') ?></span>
                            </a>
                            <ul class="core-horizontal-dropdown horizontal-menu-sub"></ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooCoreMenu'), 'object' => array('$', 'mooCoreMenu'))); ?>
    $('.core-horizontal-menu').HorizontalMenu({asStickyBrowseMenuFor: '#stickyBrowseMenu'});
    $('#stickyBrowseMenu').StickyBrowseMenu({asHorizontalMenuFor: '.core-horizontal-menu'});
<?php $this->Html->scriptEnd(); ?>