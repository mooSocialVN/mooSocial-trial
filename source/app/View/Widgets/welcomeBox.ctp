<?php if ($uid): ?>
    <div id="browse">
        <div class="summary-info p_15">
            <a href="<?php echo $this->Moo->getProfileUrl( $cuser )?>" class="no-ajax">
            <?php echo $this->Moo->getImage($user, array('prefix' => '50_square', 'class' => 'ava_home', 'width' => '50'));?>
            </a>
            <div class="user-info-home">
                <h3 class="info-home-name" style="padding: 0px;">
                    <a class="no-ajax" href="<?php echo $this->Moo->getProfileUrl( $cuser )?>">
                    <?php echo $cuser['name']?>
                    </a>
                </h3>
                <a class="no-ajax" href="<?php echo  $this->request->base; ?>/users/profile"><?php echo  __('Edit Profile') ?></a>
            </div>
        </div>
        <div class="clear"></div>
        <ul class="list2 block-body menu_top_list">
            <li class="current"><a class="no-ajax" id="whats_new" data-url="<?php echo $this->request->base?>/activities/ajax_browse/home" rel="home-content" href="<?php echo $this->request->base?>/home/index"><i class="material-icons">library_books</i> <?php echo __("What's New")?></a></li>
            <li><a id="notifications" data-url="<?php echo $this->request->base?>/notifications/ajax_show/home" rel="home-content" href="<?php echo $this->request->base?>/home/index/tab:notifications"><i class="material-icons">notifications</i> <?php echo __('Notifications')?> <span id="notification_count" class="badge_counter"><?php echo $cuser['notification_count']?></span></a></li>
            <li><a id="messages" data-url="<?php echo $this->request->base?>/conversations/ajax_browse" rel="home-content" href="<?php echo $this->request->base?>/home/index/tab:messages"><i class="material-icons">email</i> <?php echo __('Messages')?> <span class="badge_counter"><?php echo $cuser['conversation_user_count']?></span></a></li>
            <li><a id="my-friends" data-url="<?php echo $this->request->base?>/users/ajax_browse/home" rel="home-content" href="<?php echo $this->request->base?>/home/index/tab:my-friends"><i class="material-icons">people</i> <?php echo __('Friends')?> <span id="friend_count" class="badge_counter"><?php echo $cuser['friend_count']?></span></a></li>
            <li><a id="invite-friends" data-url="<?php echo $this->request->base?>/friends/ajax_invite" rel="home-content" href="<?php echo $this->request->base?>/home/index/tab:invite-friends"><i class="material-icons">share</i> <?php echo __('Invite Friends')?></a></li>
            <li <?php if ( !$cuser['friend_request_count'] ) echo 'style="display:none"' ?>><a id="friend-requests" data-url="<?php echo $this->request->base?>/friends/ajax_requests" rel="home-content" href="<?php echo $this->request->base?>/home/index/tab:friend-requests"><i class="material-icons">person_add</i> <?php echo __('Friend Requests')?> <span class="badge_counter"><?php echo $cuser['friend_request_count']?></span></a></li>

            <?php if (Configure::read('Event.event_enabled')): ?>
                <li><a id="my-events" data-url="<?php echo $this->request->base?>/events/browse/home" rel="home-content" href="<?php echo $this->request->base?>/home/index/tab:my-events"><i class="material-icons">event</i> <?php echo __('Upcoming Events')?> <span class="badge_counter"><?php echo $events_count?></span></a></li>
            <?php endif; ?>

            <?php if (Configure::read('Group.group_enabled')): ?>
                <li><a id="my-groups" data-url="<?php echo $this->request->base?>/groups/browse/home" rel="home-content" href="<?php echo $this->request->base?>/home/index/tab:my-groups"><i class="material-icons">group_work</i> <?php echo __('My Groups')?> <span class="badge_counter"><?php echo $groups_count?></span></a></li>
            <?php endif; ?>

            <?php if (Configure::read('Blog.blog_enabled')): ?>
                <li><a id="my-blogs" data-url="<?php echo $this->request->base?>/blogs/browse/home" rel="home-content" href="<?php echo $this->request->base?>/home/index/tab:my-blogs"><i class="material-icons">library_books</i> <?php echo __('My Blogs')?> <span class="badge_counter"><?php echo $cuser['blog_count']?></span></a></li>
            <?php endif; ?>

            <?php if (Configure::read('Photo.photo_enabled')): ?>
                <li><a id="my-photos" data-url="<?php echo $this->request->base?>/albums/browse/home" rel="home-content" href="<?php echo $this->request->base?>/home/index/tab:my-photos"><i class="material-icons">collections</i> <?php echo __('My Photos')?> <span class="badge_counter"><?php echo $cuser['photo_count']?></span></a></li>
            <?php endif; ?>

            <?php if (Configure::read('Video.video_enabled')): ?>
                <li><a id="my-videos" data-url="<?php echo $this->request->base?>/videos/browse/home" rel="home-content" href="<?php echo $this->request->base?>/home/index/tab:my-videos"><i class="material-icons">videocam</i> <?php echo __('My Videos')?> <span class="badge_counter"><?php echo $cuser['video_count']?></span></a></li>
            <?php endif; ?>

            <?php if (Configure::read('Topic.topic_enabled')): ?>
                <li><a id="my-topics" data-url="<?php echo $this->request->base?>/topics/browse/home" rel="home-content" href="<?php echo $this->request->base?>/home/index/tab:my-topics"><i class="material-icons">comment</i> <?php echo __('My Topics')?> <span class="badge_counter"><?php echo $cuser['topic_count']?></span></a></li>
            <?php endif; ?>
			<?php
				$this->getEventManager()->dispatch(new CakeEvent('welcomeBox.afterRenderMenu', $this)); 
			?>
            <?php
            if ( $this->elementExists('menu/home') )
                echo $this->element('menu/home');
            ?>
        </ul>
    </div>
<?php endif; ?>

<?php echo html_entity_decode( Configure::read('core.homepage_code') )?>