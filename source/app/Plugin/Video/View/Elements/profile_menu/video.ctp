<li>
	<a class="horizontal-menu-link core-menu-ajax" data-url="<?php echo $this->request->base?>/videos/profile_user_video/<?php echo $user['User']['id']?>" rel="profile-content" href="#videos" data-anchor="#videos" autoload="false">
		<span class="horizontal-menu-icon material-icons hidden">videocam</span>
		<span class="horizontal-menu-text"><?php echo __('Videos')?></span>
		<span class="badge_counter"><?php echo $user['User']['video_count']?></span>
	</a>
</li>