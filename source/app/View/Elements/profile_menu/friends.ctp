<li>
	<a class="horizontal-menu-link core-menu-ajax" data-url="<?php echo $this->request->base?>/users/profile_user_friends/<?php echo $user['User']['id']?>" rel="profile-content" href="#friends" data-anchor="#friends" autoload="false">
		<span class="horizontal-menu-icon material-icons hidden">people</span>
		<span class="horizontal-menu-text"><?php echo __('Friends')?></span>
		<span class="badge_counter"><?php echo $user['User']['friend_count']?></span>
	</a>
</li>