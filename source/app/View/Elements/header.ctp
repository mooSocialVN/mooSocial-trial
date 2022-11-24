<div class="header-inner-top">
    <div class="header-bg"></div>
    <div class="container header_container">
        <div class="header-inner-main">
            <?php echo $this->element('misc/logo'); ?>

            <?php if (!empty($cuser)): ?>
                <div id="menuAccount" class="menu_acc_content">
                    <div class="btn-group">
                        <span class="dropdown-user-box dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
                            <span class="dropdown-user-avatar">
                                <?php echo $this->Moo->getImage(array('User' => $cuser), array("id" => "member-avatar", "alt" => $cuser['name'], 'prefix' => '50_square'))?>
                            </span>
                            <!--<span class="dropdown-user-text"><?php //echo $cuser['name']; ?></span>-->
                            <span class="dropdown-user-arrow material-icons moo-icon moo-icon-expand_more">expand_more</span>
                        </span>
                        <ul class="dropdown-menu" role="menu">
                            <span class="arr-down"></span>
                            <?php
                                $hide_admin_link = Configure::read('core.hide_admin_link');
                                if ( $cuser['Role']['is_admin'] && empty( $hide_admin_link ) ):
                            ?>
                                <li><a href="<?php echo $this->request->base?>/admin/home"><?php echo __('Admin Dashboard')?></a></li>
                                <li><a href="<?php echo $this->request->base?>/make_guide"><?php echo __('Setup Guide')?></a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo $this->Moo->getProfileUrl( $cuser )?>"><?php echo __('View My Profile')?></a></li>
                            <li><a href="<?php echo $this->request->base?>/users/profile"><?php echo __('Profile Information')?></a></li>
                            <?php
                            $helperSubscription = MooCore::getInstance()->getHelper('Subscription_Subscription');
                            if ($helperSubscription->checkEnableSubscription() && $cuser['Role']['is_super'] != 1):
                                ?>
                                <li><?php echo $this->Html->link(__('Subscription Management'), array('plugin' => 'subscription', 'controller' => 'subscribes', 'action' => 'upgrade')) ?></li>
                            <?php endif;?>
                            <li><a href="<?php echo $this->request->base?>/users/avatar"><?php echo __('Change Profile Picture')?></a></li>

                            <li>
                                <a href="<?php echo $this->request->base?>/user_info/index/notifications">
                                    <?php echo __('Notifications')?>
                                </a>
                            </li>

                            <?php //if ( $cuser['conversation_user_count'] > 0 ): ?>
                                <li>
                                    <a href="<?php echo $this->request->base?>/user_info/index/messages">
                                        <?php echo __('Messages')?>
                                    </a>
                                </li>
                            <?php //endif; ?>
                            <?php if ( $cuser['friend_request_count'] > 0 ): ?>
                                <li>
                                    <a href="<?php echo $this->request->base?>/user_info/index/request_friends">
                                        <?php echo __('Friend Requests')?> (<span id="friend_request_count" class="badge_counter"><?php echo $cuser['friend_request_count']?></span>)
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (Configure::read("core.allow_invite_friend")) :?>
                            <li><a href="<?php echo $this->request->base?>/user_info/index/invite_friends"><?php echo __('Invite Friends')?></a></li>
                            <?php endif;?>

                            <!-- userMenuAccount.afterRenderMenu -->
                            <?php $this->getEventManager()->dispatch(new CakeEvent('userMenuAccount.afterRenderMenu', $this)); ?>

                            <?php if($this->isEnableDarkMode()): ?>
                            <li>
                                <a id="appearanceMode" href="javascript:void(0);">
                                    <?php echo __('Dark Mode') ?>
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="appearance" class="onoffswitch-checkbox" id="appearance" value="1" <?php if($isThemeDarkMode): ?>checked<?php endif; ?>>
                                        <label class="onoffswitch-label" for="appearance">
                                            <span class="onoffswitch-inner" data-check="<?php //echo __('Dark') ?>" data-uncheck="<?php //echo __('Light') ?>"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </a>
                            </li>
                            <?php endif; ?>
                            <li><a href="<?php echo $this->request->base?>/users/do_logout"><?php echo __('Log Out')?></a></li>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <div class="login_acc_content">
                    <div class="login-popup-group">
                        <a class="dropdown-popup-toggle" href="javascript:void(0);">
                            <span class="dropdown-user-avatar">
                                <img class="login-no-img" src="<?php echo $this->request->webroot ?>user/img/noimage/Male-user-sm.png" alt="">
                            </span>
                            <span class="dropdown-user-arrow material-icons moo-icon moo-icon-expand_more">expand_more</span>
                        </a>
                        <div class="dropdown-popup-main">
                            <div class="popup-login-form">
                                <div class="popup-login-title"><?php echo __('Login Now') ?></div>
                                <?php echo $this->element('signin') ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $this->Html->scriptStart(array('inline' => false,'requires'=>array('jquery','mooResponsive'),'object'=>array('$','mooResponsive'))); ?>
                mooResponsive.initLoginPopup();
                <?php $this->Html->scriptEnd(); ?>
            <?php endif;?>

            <?php if (!empty($cuser)): ?>
                <?php
                    $helper = MooCore::getInstance()->getHelper('Subscription_Subscription');
                    $subscribe = $helper->getSubscribeActive($cuser);
                    if ($subscribe):
                ?>
                <div class="notify_group">
                    <div class="btn-group">
                        <!-- GET MSG -->
                        <div class="dropdown notify_content">
                            <a class="dropdown-toggle <?php if (!empty($cuser['conversation_user_count'])): ?>hasNotify<?php endif; ?>" href="#" id="conversationDropdown" data-toggle="dropdown">
                                <span class="btn-group-icon material-icons-outlined moo-icon moo-icon-chat_bubble_outline">chat_bubble_outline</span>
                                <?php if (!empty($cuser['conversation_user_count'])): ?>
                                <span class="conversation_count"><?php echo $cuser['conversation_user_count']?></span>
                                <?php endif; ?>
                                <span class="spin"></span>
                            </a>
                            <div class="dropdown-menu notification_list" id="conversation_list" role="menu" aria-labelledby="dropdownMenu1"></div>
                        </div>
                        <!-- END GET MSG -->
                    </div>
                    <div class="btn-group">
                        <div class="dropdown notify_content">
                            <a class="dropdown-toggle <?php if (!empty($cuser['notification_count'])): ?>hasNotify<?php endif; ?>" href="#" id="notificationDropdown" data-toggle="dropdown">
                                <span class="btn-group-icon material-icons-outlined moo-icon moo-icon-notifications">notifications</span>
                                <?php if (!empty($cuser['notification_count'])): ?>
                                    <span class="notification_count"><?php echo $cuser['notification_count']?></span>
                                <?php endif; ?>
                                <span class="spin"></span>
                            </a>
                            <div class="dropdown-menu notification_list keep_open" id="notifications_list" role="menu" aria-labelledby="dropdownMenu1"></div>
                        </div>
                        <!-- END GET NOTIFICATION -->
                    </div>
                </div>
                    <!-- GET NOTIFICATION -->
                    <?php $this->Html->scriptStart(array('inline' => false,'requires'=>array('jquery','mooNotification'),'object'=>array('$','mooNotification'))); ?>
                    mooNotification.setUrl({
                    'show_notification': "<?php echo $this->request->base.'/notifications/show';?>",
                    'show_conversation': "<?php echo $this->request->base.'/conversations/show';?>",
                    'refresh_notification_url': "<?php echo $this->request->base.'/notifications/refresh';?>",
                    });
                    mooNotification.setInterval(<?php echo Configure::read('core.notification_interval'); ?>);
                    <?php $this->Html->scriptEnd(); ?>
                <?php else:?>
                    <!-- GET NOTIFICATION -->
                    <?php $this->Html->scriptStart(array('inline' => false,'requires'=>array('jquery','mooNotification'),'object'=>array('$','mooNotification'))); ?>
                    mooNotification.setActive(false);
                    <?php $this->Html->scriptEnd(); ?>
                <?php endif;?>
            <?php endif; ?>

            <!--headerMenuGroup.renderHeaderMenu-->
            <div class="notify_group header_menu_group">
                <div class="btn-group hidden-lg hidden-md">
                    <div class="notify_content">
                        <a class="" href="<?php echo $this->request->base ?>/home">
                            <span class="btn-group-icon material-icons-outlined moo-icon moo-icon-home">home</span>
                        </a>
                    </div>
                </div>
                <?php $this->getEventManager()->dispatch(new CakeEvent('headerMenuGroup.renderHeaderMenu', $this)); ?>
            </div>

            <?php if(!Configure::read('core.guest_search') && empty($cuser)): ?>
            <?php else: ?>
	            <?php if (!empty($cuser)): ?>
	                <?php
	                    $helper = MooCore::getInstance()->getHelper('Subscription_Subscription');
	                    $subscribe = $helper->getSubscribeActive($cuser);
	                    if ($subscribe):
	                ?>
			            <div class="global-search-header">
			                <div id="globalSearchBtnMobile" class="global-search-btn-mobile">
			                    <span class="global-search-btn-icon material-icons moo-icon moo-icon-search">search</span>
			                </div>
			                <div id="globalSearchOverview" class="global-search-overview"></div>
			                <div class="global-search">
			                    <label id="globalSearchCancel" class="global-search-label search-cancel">
			                        <span class="global-search-icon-cancel material-icons moo-icon moo-icon-cancel">cancel</span>
			                    </label>
			                    <label class="global-search-label search-submit" for="global-search">
			                        <span class="global-search-icon-submit material-icons moo-icon moo-icon-search">search</span>
			                    </label>
			                    <input type="text" id="global-search" placeholder="<?php echo __('Search')?>">
			                    <ul id="display-suggestion" style="display: none" class="suggestionInitSlimScroll">
			
			                    </ul>
			                </div>
			            </div>
	            <?php endif;?>
	            <?php endif;?>
            <?php endif; ?>

            <?php echo $this->element('main_menu'); ?>
        </div>
    </div>
</div>
<?php $this->Html->scriptStart(array('inline' => false,'requires'=>array('jquery'),'object'=>array('$'))); ?>
    var flag_menuAccount = false;
    $('#menuAccount').find('.badge_counter').each(function(){
        if( parseInt( $(this).text() ) ){
            flag_menuAccount = true;
        }
    });
    if(flag_menuAccount){
        $('#menuAccount').addClass('hasPoint');
    }
<?php $this->Html->scriptEnd(); ?>