<div class="box2 bar-content-warp">
    <div class="box_content box_menu">
        <div class="user-summary">
            <div class="user-summary-avatar">
                <?php echo $this->Moo->getItemPhoto(array('User' => $user['User']),array('class' => 'user-summary-avatar-link', 'prefix' => '200_square', 'tooltip' => true), array('class' => 'user_avatar ava_home'))?>
            </div>
            <div class="user-summary-info">
                <a class="user-summary-name" href="<?php echo $this->Moo->getProfileUrl( $cuser )?>">
                    <?php echo $cuser['name']?>
                </a>
                <!--<a class="user-summary-link" href="<?php echo  $this->request->base; ?>/users/profile"><?php echo  __('Edit Profile') ?></a>-->
                <div class="user-summary-counter">
                    <span class="item-count"><?php echo __n( '%s friend', '%s friends', $user['User']['friend_count'], $user['User']['friend_count'] )?></span> . <span class="item-count"><?php echo __n( '%s photo', '%s photos', $user['User']['photo_count'], $user['User']['photo_count'] )?></span>
                </div>
            </div>
        </div>
        <ul class="browse-menu menu-list">
            <li class="menu-list-item current">
                <a class="menu-list-link no-ajax" id="whats_new" data-url="<?php echo $this->request->base?>/activities/ajax_browse/home" rel="home-content" href="<?php echo $this->request->base?>/home/index">
                    <span class="menu-list-icon material-icons moo-icon moo-icon-library_books">library_books</span>
                    <span class="menu-list-text"><?php echo __("What's New")?></span>
                </a>
            </li>
            <li class="menu-list-item">
                <a id="notifications" class="menu-list-link has-badge no-ajax" data-url="<?php echo $this->request->base?>/user_info/index/notifications" rel="home-content" href="<?php echo $this->request->base?>/user_info/index/notifications">
                    <span class="menu-list-icon material-icons moo-icon moo-icon-notifications">notifications</span>
                    <span class="menu-list-text"><?php echo __('Notifications')?></span>
                    <span id="notification_count" class="badge_counter"><?php echo $cuser['notification_count']?></span>
                </a>
            </li>
            <li class="menu-list-item">
                <a id="messages" class="menu-list-link has-badge no-ajax" data-url="<?php echo $this->request->base?>/user_info/index/messages" rel="home-content" href="<?php echo $this->request->base?>/user_info/index/messages">
                    <span class="menu-list-icon material-icons moo-icon moo-icon-email">email</span>
                    <span class="menu-list-text"><?php echo __('Messages')?></span>
                    <span class="badge_counter"><?php echo $cuser['conversation_user_count']?></span>
                </a>
            </li>

            <li class="menu-list-item">
                <a id="my-friends" class="menu-list-link has-badge no-ajax" data-url="<?php echo $this->request->base?>/user_info/index/friends" rel="home-content" href="<?php echo $this->request->base?>/user_info/index/friends">
                    <span class="menu-list-icon material-icons moo-icon moo-icon-group">group</span>
                    <span class="menu-list-text"><?php echo __('Friends')?></span>
                    <span id="friend_count" class="badge_counter"><?php echo $friend_count?></span>
                </a>
            </li>

            <?php if (Configure::read("core.allow_invite_friend")):?>
                <li class="menu-list-item">
                    <a id="invite-friends" class="menu-list-link no-ajax" data-url="<?php echo $this->request->base?>/user_info/index/invite_friends" rel="home-content" href="<?php echo $this->request->base?>/user_info/index/invite_friends">
                        <i class="menu-list-icon material-icons moo-icon moo-icon-share">share</i>
                        <span class="menu-list-text"><?php echo __('Invite Friends')?></span>
                    </a>
                </li>
            <?php endif;?>

            <li class="menu-list-item" <?php if ( !$cuser['friend_request_count'] ) echo 'style="display:none"' ?>>
                <a id="friend-requests" class="menu-list-link has-badge no-ajax" data-url="<?php echo $this->request->base?>/user_info/index/request_friends" rel="home-content" href="<?php echo $this->request->base?>/user_info/index/request_friends">
                    <i class="menu-list-icon material-icons moo-icon moo-icon-person_add">person_add</i>
                    <span class="menu-list-text"><?php echo __('Friend Requests')?></span>
                    <span class="badge_counter"><?php echo $cuser['friend_request_count']?></span>
                </a>
            </li> 
        </ul>
    </div>
</div>